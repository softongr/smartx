<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('settings')) {
            $settings = Setting::all()->pluck('value', 'key');

            $requiredKeys = [
                'mail_mailer',
                'mail_host',
                'mail_port',
                'mail_username',
                'mail_password',
                'mail_encryption',
                'mail_from_address',
                'mail_from_name',
            ];

            $allExist = collect($requiredKeys)->every(function ($key) use ($settings) {
                return $settings->has($key) && !empty($settings[$key]);
            });


            if ($allExist) {
                Config::set('mail.mailers.smtp', [
                    'transport' => 'smtp',
                    'host' => $settings['mail_host'] ?? null,
                    'port' => $settings['mail_port'] ?? 587,
                    'encryption' => $settings['mail_encryption'] ?? 'tls',
                    'username' => $settings['mail_username'] ?? null,
                    'password' => $settings['mail_password'] ?? null,
                    'timeout' => null,
                    'auth_mode' => null,
                ]);

                Config::set('mail.default', $settings['mail_mailer'] ?? 'smtp');
                Config::set('mail.from.address', $settings['mail_from_address'] ?? null);
                Config::set('mail.from.name', $settings['mail_from_name'] ?? null);
            }
        }
    }
}
