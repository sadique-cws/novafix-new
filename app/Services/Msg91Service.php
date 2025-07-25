<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Msg91Service
{
    protected $authKey;
    protected $baseUrl = 'https://control.msg91.com/api/v5/';

    public function __construct()
    {
        $this->authKey = config('services.msg91.auth_key');
        if (empty($this->authKey)) {
            throw new \RuntimeException('MSG91 auth key is not configured');
        }
    }

    /**
     * Send OTP to mobile number
     *
     * @param string $mobile
     * @param string $customerName
     * @return array
     */
    public function sendOtp(string $mobile, string $customerName = 'Customer'): array
    {
        $otp = rand(100000, 999999);

        try {
            $payload = [
                'template_id' => '68825b97d6fc0541026fb512',
                'short_url' => 0,
                'recipients' => [
                    [
                        'mobiles' => '91' . $mobile,
                        'name' => $customerName,
                        'code' => $otp,
                    ]
                ]
            ];

            Log::debug('MSG91 OTP Send Request', [
                'mobile' => $mobile,
                'payload' => $payload
            ]);

            $response = Http::withHeaders([
                'authkey' => $this->authKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
                ->timeout(30)
                ->post($this->baseUrl . 'flow', $payload);

            $responseData = $response->json();

            Log::debug('MSG91 OTP Send Response', [
                'mobile' => $mobile,
                'status' => $response->status(),
                'response' => $responseData,
                'otp_sent' => $otp
            ]);

            // Cache the OTP for verification (for debugging)
            cache()->put('msg91_otp_' . $mobile, $otp, now()->addMinutes(5));

            return [
                'success' => $response->successful() &&
                    ($responseData['type'] ?? '') === 'success',
                'otp' => $otp,
                'response' => $responseData
            ];
        } catch (\Exception $e) {
            Log::error('MSG91 OTP Send Error', [
                'mobile' => $mobile,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'error' => 'Failed to send OTP: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Verify OTP
     *
     * @param string $mobile
     * @param string $otp
     * @return array
     */
    public function verifyOtp(string $mobile, string $otp): array
    {
        try {
            $payload = [
                'mobile' => '91' . $mobile,
                'otp' => $otp
            ];

            Log::debug('MSG91 OTP Verify Request', [
                'mobile' => $mobile,
                'payload' => $payload,
                'cached_otp' => cache()->get('msg91_otp_' . $mobile) // For debugging
            ]);

            $response = Http::withHeaders([
                'authkey' => $this->authKey,
                'Content-Type' => 'application/json'
            ])
                ->timeout(60)
                ->post($this->baseUrl . 'otp/verify', $payload);

            $responseData = $response->json();

            Log::debug('MSG91 OTP Verify Response', [
                'mobile' => $mobile,
                'status' => $response->status(),
                'response' => $responseData
            ]);

            // Multiple success conditions to handle different MSG91 responses
            $success = $response->successful() && (
                ($responseData['type'] ?? '') === 'success' ||
                ($responseData['message'] ?? '') === 'OTP verified successfully' ||
                ($responseData['status'] ?? '') === 'success'
            );

            // For debugging - compare with cached OTP
            $cachedOtp = cache()->get('msg91_otp_' . $mobile);
            if ($cachedOtp && $cachedOtp == $otp) {
                Log::debug('OTP matches cached value', ['mobile' => $mobile]);
                $success = true;
            }

            return [
                'success' => $success,
                'response' => $responseData,
                'debug' => [
                    'cached_otp_match' => $cachedOtp == $otp,
                    'response_status' => $response->status()
                ]
            ];
        } catch (\Exception $e) {
            Log::error('MSG91 OTP Verification Error', [
                'mobile' => $mobile,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'error' => 'OTP verification failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Fallback local verification for development
     */
    public function localVerifyOtp(string $mobile, string $otp): array
    {
        $cachedOtp = cache()->get('msg91_otp_' . $mobile);
        $success = $cachedOtp && $cachedOtp == $otp;

        Log::debug('Local OTP Verification', [
            'mobile' => $mobile,
            'success' => $success,
            'expected' => $cachedOtp,
            'received' => $otp
        ]);

        return [
            'success' => $success,
            'response' => [
                'message' => $success ? 'OTP verified locally' : 'Invalid OTP',
                'type' => $success ? 'success' : 'error'
            ]
        ];
    }
}
