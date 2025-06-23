<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;

use Session;
// use Http;
use App\Models\User;
use App\Models\Customer;
use App\Models\Cart;
use App\Models\CartItems;

use App\Models\Wishlist;
use App\Models\WishlistItems;
use App\Models\Settings;



use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    
    /*
    public function login(Request $request)
    { 
        \Log::info('All Session Data:', Session::all());
        // dd($request);
        // 1741157872pzik51osgdf6xcv7la4h980euwqyn23tmbrj
        // $session_id = Session::get('session_id') == null ? 0 : Session::get('session_id');
        $session_id = Session::get('session_id') ?? 0;
        \Log::info($session_id);
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
             $token =  $user->createToken('MyApp')-> accessToken; 
           $cart = Cart::where('customer_id', $session_id)->first();
            \Log::info($cart);
            if ($cart) {
                // Update cart customer_id to logged-in user
                $cart->update(['customer_id' => $user->id]);
    
                // Update all cart items with new customer_id
                CartItems::where('customer_id', $session_id)
                    ->update(['customer_id' => $user->id]);
            }
            
            $wishlist = Wishlist::where('customer_id', $session_id)->first();
            \Log::info($wishlist);
            if ($wishlist) {
                // Update cart customer_id to logged-in user
                $wishlist->update(['customer_id' => $user->id]);
    
                // Update all cart items with new customer_id
                WishlistItems::where('customer_id', $session_id)
                    ->update(['customer_id' => $user->id]);
            }
    
            // Remove session_id after migration
            Session::forget('session_id');
   
            return response()->json(['message' => 'Login successful','token'=>$token,'user'=>$user]);
        } 
        else{ 
            return response()->json(['error' => 'Invalid credentials'], 401);
        } 
    }
    */

    public function login(Request $request)
    {
        $request->validate([
            
            'phone' => 'required',
            'password' => 'required'
        ]);
        try{
            $cleanPhone = preg_replace('/[^0-9]/', '', $request->phone);
            if (strlen($cleanPhone) === 10) {
                $cleanPhone = '91' . $cleanPhone;
            }
            $user = \App\Models\User::where('phone', $cleanPhone)
                        ->first();
        
                        if (!$user) {
                            return response()->json(['error' => 'User with given phone not found.'], 404);
                        }
                    
                        if (!Hash::check($request->password, $user->password)) {
                            return response()->json(['error' => 'Invalid password.'], 401);
                        }
                    
                        if ($user->is_verified !== 'yes') {
                            return response()->json(['error' => 'User not verified. Please verify first.'], 403);
                        }
                        
            Auth::login($user);
            $token = $user->createToken('MyApp')->accessToken;
        
            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user
            ]);
        }
        catch (\Exception $e) 
        {
        return response()->json(['error' => 'Something went wrong. Please try again.'], 400);
        }
        
    }

    
    
    public function getUser(){
        try 
        {
            // \Log::info('Request Headers1:', request()->headers->all());
    
            $data = auth()->user();
    
            if (!$data)
            {
                throw new \Exception('User not authenticated');
            }
            $data->load('customer');
            // \Log::info($data);
    
            return response()->json(['data' => $data]);
        } 
        
        catch (\Exception $e) 
        {
            // \Log::error('Error in getUser: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong'], 500);
        } 
    }
    
    
    
   /* public function signUp(Request $request)
    {
        
        if (User::where('email', $request->email)) 
        {
           
        }
        if (User::where('email', $request->email)->exists()) 
        {
            return response()->json([
                'message' => 'User already registered with this email.'
            ], 409);
        }
        // dd($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'phone' => 'required',
            
          
        ]);
   
        if($validator->fails()){
           
            return response()->json(['error' => 'Validation Error ','error'=>$validator->errors()]);       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['user_type'] = 'customer'; 
        $input['phone']=$input['phone'];
       
        $user = User::create($input);
        $token =  $user->createToken('MyApp')->accessToken;

        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        // Mail::to($user->email)->send(new OtpMail($otp));
         
        $apiKey = env('TWO_FACTOR_API_KEY'); 
         
        $phone = $user->phone;
        $response = Http::get("https://2factor.in/API/V1/$apiKey/SMS/$phone/$otp/TEXT");
        
        Log::info($apiKey);
        Log::info($phone);
        Log::info($response);
        
   
        return response()->json([
            'message' => 'Register successful But not verified',
            'token'=>$token,
            'otp'=>$otp,
            'sms_status' => $response->json()
            ]);
    }
    */
    
    public function signUp(Request $request)
    {
       
        
        $cleanPhone = preg_replace('/[^0-9]/', '', $request->phone);
        if (strlen($cleanPhone) === 10) {
            $cleanPhone = '91' . $cleanPhone;
        } elseif (!(strlen($cleanPhone) === 12 && str_starts_with($cleanPhone, '91'))) {
            return response()->json([
                'error' => 'Invalid phone number format. Please enter a valid 10-digit Indian number.'
            ], 422);
        }
    
        $existingUser = User::where('email', $request->email)
                            ->orWhere('phone', $cleanPhone)
                            ->first();

        if ($existingUser) {
            if ($existingUser->is_verified === 'no') {
                $otp = rand(100000, 999999);
                $expiryMinutes = Settings::where('label', 'otp_expiry_minutes')->value('value') ?? 10;
    
                $existingUser->otp = $otp;
                $existingUser->otp_expires_at = Carbon::now()->addMinutes((int)$expiryMinutes);
                $existingUser->save();
    
                $apiKey = env('TWO_FACTOR_API_KEY_2');
                $response = Http::get("https://2factor.in/API/V1/$apiKey/SMS/$cleanPhone/$otp/TEXT");
    
                return response()->json([
                    'message' => 'User already exists but not verified. OTP resent, please verify.',
                    'otp' => $otp,
                    'sms_status' => $response->json()
                ], 200);
            }
    
            return response()->json([
                'message' => 'User already registered with this email or phone.'
            ], 409);
        }
    
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation Error',
                'details' => $validator->errors()
            ], 422);
        }
    
        // Generate OTP first
        $otp = rand(100000, 999999);
        $expiryMinutes = Settings::where('label', 'otp_expiry_minutes')->value('value') ?? 10;
    
        $apiKey = env('TWO_FACTOR_API_KEY_2');
        $response = Http::get("https://2factor.in/API/V1/$apiKey/SMS/$cleanPhone/$otp/Lagro%20V1");
        
        $smsResult = $response->json();
        if (!isset($smsResult['Status']) || $smsResult['Status'] !== 'Success') {
            return response()->json([
                'error' => 'Failed to send OTP. Please check the phone number or try again later.',
                'sms_status' => $smsResult
            ], 500);
        }
    
        // Create new user after successful OTP SMS
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['user_type'] = 'customer';
        $input['phone'] = $cleanPhone;
    
        $user = User::create($input);
        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes((int)$expiryMinutes);
        $user->save();
    
        $token = $user->createToken('MyApp')->accessToken;
    
        return response()->json([
            'message' => 'Register successful but not verified',
            'token' => $token,
            'otp' => $otp,
            'sms_status' => $smsResult
        ]);
    }



    
   public function VerifySignup(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'otp' => 'required'
        ]);
    

        $inputPhone = preg_replace('/[^0-9]/', '', $request->phone);
        if (strlen($inputPhone) === 10) {
            $inputPhone = '91' . $inputPhone;
        }
        
        $user = User::where(function($q) use ($inputPhone) {
            $q->where('phone', $inputPhone)
              ->orWhere('phone', substr($inputPhone, 2));
        })->first();
    
        if (!$user) {
            return response()->json(['message' => 'Phone number not registered'], 404);
        }
    
        if ($user->otp !== $request->otp) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }
    
        if (Carbon::now()->gt($user->otp_expires_at)) {
            return response()->json(['message' => 'OTP expired'], 400);
        }
    
        // Mark user as verified
        $user->is_verified = true;
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();
    
        // Create customer record
        $customer = new Customer();
        $customer->name = $user->name;
        $customer->user_id = $user->id;
        $customer->email = $user->email;
        $customer->phone = $user->phone;
        $customer->created_at = now();
        $customer->updated_at = now();
        $customer->created_by = $user->id;
        $customer->updated_by = $user->id;
        $customer->save();
    
        // Generate access token
        $token = $user->createToken('MyApp')->accessToken;
    
        return response()->json([
            'message' => 'OTP verified successfully. User verified and saved as customer.',
            'token' => $token
        ]);
    }

    
    
    public function updateProfile(Request $request)
    {
        $user=auth()->user();
        if(!$user)
        {
            return response()->json([
                'message' => 'User Not Found'
            ],404); 
        }
        $customer= Customer::where('user_id',$user->id)->first();
        $customer->name=$request->name;
        $customer->phone=$request->phone;
        $customer->address=$request->address;
        $customer->city=$request->city;
        $customer->pincode=$request->pincode;
        $customer->state=$request->state;
        $customer->country=$request->country;
        $customer->gender=$request->gender;
        $customer->updated_by =$user->id;
        $customer->save();
        if($user->name != $request->name)
        {
            $user->name=$request->name;
            $user->save();
        }
        return response()->json(['status'=>true,'message'=>'Profile Updated Successfully']);
       
    }
    
    
    public function logout(Request $request)
    {
       
        $user=auth()->user();

        if(!$user)
        {
            return response()->json([
                'message' => 'User Not Found'
            ],404); 
        }

        $user->tokens()->delete();
      
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
    
    
    /*
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
    
        // Log::info("Attempting to send password reset link to: " . $request->email);
    
        $status = Password::sendResetLink($request->only('email'));
    
        if ($status === Password::RESET_LINK_SENT) {
            // Log::info("Password reset link sent successfully to: " . $request->email);
            return response()->json(['message' => __($status)], 200);
        } 
        
        else {
            // Log::error("Failed to send reset link: " . __($status));
            return response()->json(['error' => __($status)], 400);
        }
    }
    
    
    
    public function resetPassword(Request $request)
    {
       $request->validate([
        'email' => 'required|email|exists:users,email',
        'password' => 'required|min:6|confirmed',
        'token' => 'required'
    ]);

    // Reset password using Laravel's built-in method
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? response()->json(['message' => 'Password has been reset successfully.'], 200)
        : response()->json(['error' => 'Invalid token or email.'], 400);
    }
    
    */
    
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required'
        ]);
        
        $inputPhone = preg_replace('/[^0-9]/', '', $request->phone);
        if (strlen($inputPhone) === 10) {
            $inputPhone = '91' . $inputPhone;
        }
        
        $user = User::where(function($q) use ($inputPhone) {
            $q->where('phone', $inputPhone)
              ->orWhere('phone', substr($inputPhone, 2));
        })->first();
    
        if (!$user) {
            return response()->json(['error' => 'No user found with this phone number.'], 404);
        }
    
        if ($user->is_verified !== 'yes') {
            return response()->json(['error' => 'User not verified.'], 403);
        }
    
        // Generate OTP
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $expiryMinutes = Settings::where('label','otp_expiry_minutes')->value('value') ?? 10;
        $user->otp_expires_at = Carbon::now()->addMinutes((int)$expiryMinutes);
        $user->save();
    
        $apiKey = env('TWO_FACTOR_API_KEY_2');
        $phone = $inputPhone;
        $response = Http::get("https://2factor.in/API/V1/$apiKey/SMS/$phone/$otp/LagroSMS");
    
        return response()->json([
            'message' => 'OTP sent for password reset.',
            'phone' => $user->phone,
            'otp' => $otp, 
            'sms_status' => $response->json()
        ], 200);
    }


    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'phone' => 'required',
        'otp' => 'required|digits:6',
        'password' => 'required|min:8|confirmed', // requires password_confirmation field
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation Error',
                'details' => $validator->errors()
            ], 422);
        }

        
  
        // Normalize phone
        $inputPhone = preg_replace('/[^0-9]/', '', $request->phone);
        if (strlen($inputPhone) === 10) {
            $inputPhone = '91' . $inputPhone;
        }
    
        // Find matching user with all three fields
       $user = User::where(function($q) use ($inputPhone) {
                $q->where('phone', $inputPhone)
                  ->orWhere('phone', substr($inputPhone, 2));
            })
            ->where('otp', $request->otp)
            ->first();
    
        if (!$user) {
            return response()->json(['error' => 'Invalid phone, or OTP.'], 400);
        }
    
        if ($user->otp_expires_at < now()) {
            return response()->json(['error' => 'OTP expired.'], 400);
        }
    
        $user->password = Hash::make($request->password);
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();
    
        return response()->json(['message' => 'Password has been reset successfully.'], 200);
    }


    
    
    
    
    /*
    public function sendChangePasswordOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if ($user->is_verified !== 'yes') {
            return response()->json(['error' => 'User not verified.'], 403);
        }
    
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $expiryMinutes = Settings::where('label', 'otp_expiry_minutes')->value('value');
        $user->otp_expires_at = Carbon::now()->addMinutes((int)$expiryMinutes);
        $user->save();
    
        // Send via SMS
        $apiKey = env('TWO_FACTOR_API_KEY');
        $phone = preg_replace('/[^0-9]/', '', $user->phone);
        if (strlen($phone) === 10) {
            $phone = '91' . $phone;
        }
    
         $response = Http::get("https://2factor.in/API/V1/$apiKey/SMS/$phone/$otp/Lagro V1");
         
        return response()->json([
            'message' => 'OTP sent to your registered mobile number.',
            'otp' => $otp, // Remove this in production
            'sms_status' => $response->json(),
        ]);
    }
    
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:6',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => 'Validation Error', 'errors' => $validator->errors()]);
        }
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user || $user->otp !== $request->otp) {
            return response()->json(['error' => 'Invalid OTP'], 400);
        }
    
        if ($user->otp_expires_at < now()) {
            return response()->json(['error' => 'OTP expired'], 400);
        }
    
        $user->password = bcrypt($request->new_password);
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();
    
        return response()->json(['message' => 'Password changed successfully via OTP']);
    }

    */
    
    
    

    /*
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Validation Error', 'errors' => $validator->errors()]);
        }

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'Invalid current password'], 401);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password changed successfully']);
    }
    */
    
    
    
    
    
   public function Clearuser(Request $request)
    {
        $request->validate([
            'data' => 'required'
        ]);
    
        $input = $request->input('data');
    
        $normalizedPhone = preg_replace('/[^0-9]/', '', $input);
        $phoneWithCode = (substr($normalizedPhone, 0, 2) === '91') ? $normalizedPhone : '91' . $normalizedPhone;
        $phoneWithoutCode = (substr($normalizedPhone, 0, 2) === '91') ? substr($normalizedPhone, 2) : $normalizedPhone;
    
        $existingUser = User::where(function ($query) use ($phoneWithCode, $phoneWithoutCode, $input) {
            $query->where('phone', $phoneWithCode)
                  ->orWhere('phone', $phoneWithoutCode)
                  ->orWhere('email', $input);
        })->first();
    
        if ($existingUser) {
            $existingCustomer = Customer::where('user_id', $existingUser->id)->first();
    
            if ($existingCustomer) {
                $existingCustomer->delete();
            }
    
            $existingUser->delete();
    
            return response()->json(['message' => 'User and related customer deleted successfully']);
        }
    
        return response()->json(['message' => 'User not found'], 404);
    }



}
