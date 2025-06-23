<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\ConfigValue;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $config=Config::get();
        // $configrazor=Config::where('name','Razorpay')->first();
        // $configpaypal=Config::where('name','Paypal')->first();
        // $configstripe=Config::where('name','Stripe')->first();
        // $configemail=Config::where('name','EMAIL')->first();
        return view('admin.config.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.config.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  dd($request->All());
        if ($request->has('type')) {
            $selectedName = $request->input('type');
            $modulename = $request->input('module_name');

            // Update the 'type' configuration value in the Config model
            $config = Config::where('module_name', $modulename)->first();
            if ($config) {
                $config->type = $selectedName;
               

                $config->save();
            }
        }

        $keysArray = ['RAZORPAY_LIVE_KEY', 'RAZORPAY_LIVE_SECRET',
            'RAZORPAY_SANDBOX_KEY', 'RAZORPAY_SANDBOX_SECRET',

        ];
        foreach ($keysArray as $value) {
            // dd($value);
            if ($request->has($value)) {
                // dd($request->$value);
                $config = ConfigValue::where('name', $value)->first();

                if (isset($config)) {
                    $config->value = $request->$value;
                    $config->save();
                }

            }
        }
       
        if ($request->has('type')) {
            $selectedName = $request->input('type');
            $modulename = $request->input('module_name');
            // dd(  $modulename);
            // Update the 'type' configuration value in the Config model
            $config = Config::where('module_name', $modulename)->first();
            if ($config) {
                $config->type = $selectedName;
                

                $config->save();
            }
        }

        $keysArray = ['PAYPAL_LIVE_KEY', 'PAYPAL_LIVE_SECRET',
            'PAYPAL_SANDBOX_KEY', 'PAYPAL_SANDBOX_SECRET',

        ];
        foreach ($keysArray as $value) {
            if ($request->has($value)) {
                $config = ConfigValue::where('name', $value)->first();

                if (isset($config)) {
                    $config->value = $request->$value;
                    $config->save();
                }

            }
        }
        // dd($request->all());
        if ($request->has('type')) {
            $selectedName = $request->input('type');
            $modulename = $request->input('module_name');
            // dd($modulename);
            // Update the 'type' configuration value in the Config model
            $config = Config::where('module_name', $modulename)->first();
            if ($config) {
                $config->type = $selectedName;
                

                $config->save();
            }
        }
        $keysArray = ['STRIPE_LIVE_KEY', 'STRIPE_LIVE_SECRET',
            'STRIPE_SANDBOX_KEY', 'STRIPE_SANDBOX_SECRET',

        ];
        foreach ($keysArray as $value) {
            if ($request->has($value)) {
                $config = ConfigValue::where('name', $value)->first();

                if (isset($config)) {
                    $config->value = $request->$value;
                    $config->save();
                }

            }
        }

        if ($request->has('type')) {
            $selectedName = $request->input('type');
            $modulename = $request->input('module_name');

            // Update the 'type' configuration value in the Config model
            $config = Config::where('module_name', $modulename)->first();
            if ($config) {
                $config->type = $selectedName;
                

                $config->save();
            }
        }

        $keysArray = ['MAIL_MAILER', 'MAIL_HOST',
            'MAIL_PORT', 'MAIL_USERNAME',
            'MAIL_PASSWORD', 'MAIL_ENCRYPTION',
            'MAIL_FROM_ADDRESS', 'MAIL_FROM_NAME',

        ];
        foreach ($keysArray as $value) {
            if ($request->has($value)) {
                $config = ConfigValue::where('name', $value)->first();

                if (isset($config)) {
                    $config->value = $request->$value;
                    $config->save();
                }

            }
        }

        return redirect('configuration')->with('success', 'Data stored successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function configStatus(Request $request)
    {
        $data=Config::find($request->thisId);
        if($data->is_enabled=='yes')
        {
            $data->is_enabled='no';
        }else{
            $data->is_enabled='yes';
        }
       
        $data->save();
        echo "Status Changed";
    }
}
