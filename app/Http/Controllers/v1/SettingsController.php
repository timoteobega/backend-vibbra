<?php

namespace App\Http\Controllers\v1;

use App\Models\Settings;
use Exception;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Settings::all('max_revenue_amount','sms_notification','email_notification');
        if ($settings->isEmpty())
        {
            return response()->json(['error' => 'Not found'],404);
        }

        return response()->json([
            'max_revenue_amount' => (double)$settings[0]['max_revenue_amount'],
            'sms_notification' => (boolean)$settings[0]['sms_notification'],
            'email_notification' => (boolean)$settings[0]['email_notification']
        ]);
    }

    public function store(Request $request)
    {
        try
        {
            $settings = Settings::all()->first();
            if (!is_null($settings))
            {
                return response()->json(['error' => 'Settings alread registered'],404);
            }

            $settings = new Settings;
            $settings->max_revenue_amount = $request->input('max_revenue_amount');
            $settings->sms_notification = $request->input('sms_notification');
            $settings->email_notification = $request->input('email_notification');
            $settings->save();

            return response()->json([
                'max_revenue_amount' => (double)$settings->max_revenue_amount,
                'sms_notification' => (boolean)$settings->sms_notification,
                'email_notification' => (boolean)$settings->email_notification
            ]);
        } catch (Exception $exception)
        {
            return response('',400);
        }
    }

    public function update(Request $request)
    {
        try
        {
            $settings = Settings::all()->first();
            if (is_null($settings))
            {
                return response()->json(['error' => 'Not found'],404);
            }
            $settings->max_revenue_amount = $request->input('max_revenue_amount');
            $settings->sms_notification = $request->input('sms_notification');
            $settings->email_notification = $request->input('email_notification');
            $settings->save();

            return response()->json([
                'max_revenue_amount' => (double)$settings->max_revenue_amount,
                'sms_notification' => (boolean)$settings->sms_notification,
                'email_notification' => (boolean)$settings->email_notification
            ]);
        } catch (Exception $exception)
        {
            return response('',400);
        }
    }
}
