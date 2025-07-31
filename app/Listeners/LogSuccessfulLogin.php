<?php

namespace App\Listeners;

use App\Mail\UserLoggedIn;
use App\Models\Setting;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Request;
use App\Models\UserLogin;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Crypto\SMime;


class LogSuccessfulLogin
{

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $ip = Request::ip();
        $agent = Request::header('User-Agent');
        $location = Location::get('8.8.8.8');

        UserLogin::create([
            'user_id'       => $event->user->id,
            'ip_address'    => $ip,
            'country'       => $location?->countryName,
            'city'          => $location?->cityName,
            'region'        => $location?->regionName,
            'zip'           => $location?->postalCode,
            'latitude'      => $location?->latitude,
            'longitude'     => $location?->longitude,
            'user_agent'    => $agent,
        ]);

        if (Setting::get('notify_on_login')) {

            if (Setting::get('notify_on_login_email')) {
                $toEmail = Setting::get('email_notification');
                Mail::to($toEmail)->send(new UserLoggedIn(
                    name: $event->user->name,
                    email: $event->user->email,
                    ip: $ip,
                    location: $location ? $location->cityName . ', ' . $location->countryName : null,
                    time: now()->format('d/m/Y H:i'),
                    user_agent: $agent
                ));
            }


            if (Setting::get('notify_on_login_sms'))
            {
                $adminPhone = Setting::get('admin_phone_number');
                if ($adminPhone) {
                    $text = "Ο χρήστης {$event->user->name} συνδέθηκε από IP {$ip}";
                    $data = [
                        'key'  => Setting::get('sms_api_key'),
                        'text' => $text,
                        'from' => Setting::get('sms_store_name'),
                        'to'   => Setting::get('admin_phone_number'),
                        'type' => 'json',
                    ];
                    $smsService = app(\App\Services\SmsService::class);
                    $smsService->send($data);
                }
            }
        }
    }
}
