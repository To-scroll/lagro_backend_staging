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

use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    
   
/*
    public function login(Request $request)
    {
        $request->validate([
            
            'phone' => 'required',
            'password' => 'required'
        ]);
        try{
            $cleanPhone = preg_replace('/[^0-9]/', '', $request->phone);
            $phoneVariants = [$cleanPhone];
            
            if (strlen($cleanPhone) === 10) {
                $phoneVariants[] = '91' . $cleanPhone;
            } elseif (strlen($cleanPhone) === 12 && str_starts_with($cleanPhone, '91')) {
                $phoneVariants[] = substr($cleanPhone, 2); // add 10-digit version
            }
            

            
            $user = \App\Models\User::whereIn('phone', $phoneVariants)->first();
            
          
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
*/
    public function login(Request $request)
    {
        try {
            // Validate input
            $request->validate([
                'phone' => 'required',
                'password' => 'required'
            ]);
    
            // Clean and normalize phone number
            $cleanPhone = preg_replace('/[^0-9]/', '', $request->phone);
            $phoneVariants = [$cleanPhone];
    
            if (strlen($cleanPhone) === 10) {
                $phoneVariants[] = '91' . $cleanPhone;
            } elseif (strlen($cleanPhone) === 12 && str_starts_with($cleanPhone, '91')) {
                $phoneVariants[] = substr($cleanPhone, 2);
            }
    
            // Attempt to find user
            $user = User::whereIn('phone', $phoneVariants) ->where('user_type', 'customer')->first();
    
            if (!$user) {
                throw new AuthenticationException('User with given phone not found.');
            }
    
            // Check password
            if (!Hash::check($request->password, $user->password)) {
                throw new AuthenticationException('Invalid password.');
            }
    
            // Check verification status
            if ($user->is_verified !== 'yes') {
                return response()->json([
                    'error' => 'User not verified. Please verify first.',
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'phone' => $user->phone,
                        'is_verified' => $user->is_verified
                    ]
                ], 403);
            }
    
            // Login and generate token
            Auth::login($user);
            $token = $user->createToken('MyApp')->accessToken;
    
            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors()
            ], 422);
        } catch (AuthenticationException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong. Please try again.',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    
    public function getUser()
    {
        try {
            $user = auth()->user();
    
            if (!$user) {
                throw new AuthenticationException('User not authenticated');
            }
    
            // Load related customer details if exists
            $user->load('customer');
    
            return response()->json(['data' => $user]);
    
        } catch (AuthenticationException $e) {
            return response()->json([
                'error' => 'Authentication failed',
                'message' => $e->getMessage()
            ], 401);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage() // optional: remove in production
            ], 500);
        }
    }
    

    public function signUp(Request $request)
    {
        try {
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
    
                    $apiKey = env('TWO_FACTOR_API_KEY');
                    $response = Http::get("https://2factor.in/API/V1/$apiKey/SMS/$cleanPhone/$otp/FineFurnitureSMS");
                    //$response = Http::get("https://2factor.in/API/V1/$apiKey/SMS/$cleanPhone/$otp/TEXT");
                    //$response = Http::get("https://2factor.in/API/V1/1317400e-61ff-11f0-a562-0200cd936042/SMS/$cleanPhone/$otp/FineFurnitureSMS");
    
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
    
            $otp = rand(100000, 999999);
            $expiryMinutes = Settings::where('label', 'otp_expiry_minutes')->value('value') ?? 10;
    
            $apiKey = env('TWO_FACTOR_API_KEY');
            $response = Http::get("https://2factor.in/API/V1/$apiKey/SMS/$cleanPhone/$otp/FineFurnitureSMS");
            //$response = Http::get("https://2factor.in/API/V1/$apiKey/SMS/$cleanPhone/$otp/Lagro%20V1");
            //$response = Http::get("https://2factor.in/API/V1/1317400e-61ff-11f0-a562-0200cd936042/SMS/$cleanPhone/$otp/FineFurnitureSMS");
    
            $smsResult = $response->json();
            if (!isset($smsResult['Status']) || $smsResult['Status'] !== 'Success') {
                return response()->json([
                    'error' => 'Failed to send OTP. Please check the phone number or try again later.',
                    'sms_status' => $smsResult
                ], 500);
            }
    
            
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
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong.',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function VerifySignup(Request $request)
    {
        try {
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
            })->where('user_type', 'customer')->first();
    
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
    
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    
    public function updateProfile(Request $request)
    {
        try {
            $user = auth()->user();
    
            if (!$user) {
                throw new AuthenticationException('User not authenticated');
            }
            
            if ($user->user_type !== 'customer') {
                return response()->json([
                    'status' => false,
                    'error' => 'Unauthorized',
                    'message' => 'Only customers can update profile'
                ], 403);
            }
    
            $customer = Customer::where('user_id', $user->id)->first();
    
            if (!$customer) {
                return response()->json([
                    'message' => 'Customer record not found'
                ], 404);
            }
    
            
    
            $customer->name = $request->name;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->city = $request->city;
            $customer->pincode = $request->pincode;
            $customer->state = $request->state;
            $customer->country = $request->country;
            $customer->gender = $request->gender;
            $customer->updated_by = $user->id;
            $customer->save();
    
            if ($user->name != $request->name) {
                $user->name = $request->name;
                $user->save();
            }
    
            return response()->json([
                'status' => true,
                'message' => 'Profile Updated Successfully'
            ], 200);
    
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'error' => 'Validation failed',
                'messages' => $e->errors()
            ], 422);
        } catch (AuthenticationException $e) {
            return response()->json([
                'status' => false,
                'error' => 'Authentication failed',
                'message' => $e->getMessage()
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    
    
    public function logout(Request $request)
    {
        try {
            $user = auth()->user();
    
            if (!$user) {
                throw new AuthenticationException('User not authenticated');
            }
    
    
            $user->tokens()->delete();
    
            return response()->json([
                'message' => 'Successfully logged out',
            ], 200);
    
        } 
        catch (AuthenticationException $e) {
            return response()->json([
                'status' => false,
                'error' => 'Authentication failed',
                'message' => $e->getMessage()
            ], 401);
        }catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong during logout.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    
    
    
 
    public function forgotPassword(Request $request)
    {
        try {

            $request->validate([
                'phone' => 'required'
            ]);
    
  
            $inputPhone = preg_replace('/[^0-9]/', '', $request->phone);
            if (strlen($inputPhone) === 10) {
                $inputPhone = '91' . $inputPhone;
            }
    

            $user = User::where(function ($q) use ($inputPhone) {
                $q->where('phone', $inputPhone)
                  ->orWhere('phone', substr($inputPhone, 2));
            })->where('user_type', 'customer')->first();
            if (!$user) {
                return response()->json(['error' => 'No user found with this phone number.'], 404);
            }
    
            if ($user->is_verified !== 'yes') {
               return response()->json(['error' => 'User not verified.','user' => ['user' => $user]], 403);
            }
    

            $otp = rand(100000, 999999);
            $user->otp = $otp;
    
            $expiryMinutes = Settings::where('label', 'otp_expiry_minutes')->value('value') ?? 10;
            $user->otp_expires_at = Carbon::now()->addMinutes((int) $expiryMinutes);
            $user->save();
    
           
            $apiKey = env('TWO_FACTOR_API_KEY');
            $response = Http::get("https://2factor.in/API/V1/$apiKey/SMS/$inputPhone/$otp/FineFurnitureSMS");
    
            return response()->json([
                'message' => 'OTP sent for password reset.',
                'phone' => $user->phone,
                'otp' => $otp,
                'sms_status' => $response->json()
            ], 200);
    
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors()
            ], 422);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function resetPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required',
                'otp' => 'required|digits:6',
                'password' => 'required|min:8|confirmed',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation Error',
                    'details' => $validator->errors()
                ], 422);
            }
    
            $inputPhone = preg_replace('/[^0-9]/', '', $request->phone);
            if (strlen($inputPhone) === 10) {
                $inputPhone = '91' . $inputPhone;
            }
    
            $user = User::where(function($q) use ($inputPhone) {
                        $q->where('phone', $inputPhone)
                          ->orWhere('phone', substr($inputPhone, 2));
                    })
                    ->where('otp', $request->otp)
                    ->where('user_type', 'customer')
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
    
            return response()->json([
                'message' => 'Password has been reset successfully.'
            ], 200);
    
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong.',
                'message' => $e->getMessage()
            ], 500);
        }
    }



    

    
    public function Clearuser(Request $request)
    {
        try {
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
    
                return response()->json([
                    'message' => 'User and related customer deleted successfully'
                ], 200);
            }
    
            return response()->json([
                'message' => 'User not found'
            ], 404);
    
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }



    public function resendOtp(Request $request)
    {
        try {

            $request->validate([
                'phone' => 'required'
            ]);
    
  
            $inputPhone = preg_replace('/[^0-9]/', '', $request->phone);
            if (strlen($inputPhone) === 10) {
                $inputPhone = '91' . $inputPhone;
            }
    

            $user = User::where(function ($q) use ($inputPhone) {
                $q->where('phone', $inputPhone)
                  ->orWhere('phone', substr($inputPhone, 2));
            })->where('user_type', 'customer')->first();
            if (!$user) {
                return response()->json(['error' => 'No user found with this phone number.'], 404);
            }
    
            if ($user->is_verified == 'yes') {
              return response()->json(['error' => 'User is already verified.','user' => ['user' => $user]], 403);
            }
    

            $otp = rand(100000, 999999);
            $user->otp = $otp;
    
            $expiryMinutes = Settings::where('label', 'otp_expiry_minutes')->value('value') ?? 10;
            $user->otp_expires_at = Carbon::now()->addMinutes((int) $expiryMinutes);
            $user->save();
    
           
            $apiKey = env('TWO_FACTOR_API_KEY');
            $response = Http::get("https://2factor.in/API/V1/$apiKey/SMS/$inputPhone/$otp/FineFurnitureSMS");
    
            return response()->json([
                'message' => 'OTP resented.',
                'user'=>$user,
                'phone' => $user->phone,
                'otp' => $otp,
                'sms_status' => $response->json()
            ], 200);
    
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors()
            ], 422);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }



}
