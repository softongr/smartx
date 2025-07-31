<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;


class SmsService
{
    protected string $primaryUrl = 'https://easysms.gr/api/sms/send';
    protected string $backupUrl  = 'https://backup.easysms.gr/api/sms/send';

    public function send(array $parameters): array
    {
        try {
            $response = Http::asForm()->timeout(1)->post($this->primaryUrl, $parameters);

            if ($response->successful()) {
                return $response->json();
            }

            $backupResponse = Http::asForm()->timeout(1)->post($this->backupUrl, $parameters);
            return $backupResponse->json();

        } catch (\Exception $e) {
            return ['error' => true, 'message' => __('SMS failed to send.')];
        }
    }
}
