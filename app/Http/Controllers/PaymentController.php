<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    
    protected $djangoBase;

    public function __construct()
    {
        $this->djangoBase = config('services.django_api.url', 'http://localhost:8000');
    }

    public function showPaymentPage($orderId)
    {
        $token = request()->get('token', '');

        if (!$token) {
            abort(403, 'Invalid payment link.');
        }

        return view('shop.payment', compact('orderId', 'token'));
    }

    public function initiatePayment(Request $request)
    {
        try {
            $validated = $request->validate([
                'order_id' => 'required',
                'token'    => 'required|string',
            ]);
            Log::info('[PaymentController] payment payload', [
            'payload' => $validated,
            ]);


            $orderId = $validated['order_id'];
            $token   = $validated['token'];

            $response = Http::timeout(30)
                ->withoutVerifying()
                ->withHeaders(['Accept' => 'application/json'])
                ->post("{$this->djangoBase}/api/ecommerce/pay/{$orderId}/", [
                    'token' => $token,
                ]);

             Log::info('[PaymentController] payment response', [
            'status' => $response->status(),
            'body' => $response->body(),
            ]);

            if ($response->successful()) {
                return response()->json([
                    'success'             => true,
                    'message'             => 'STK Push sent.',
                    'checkout_request_id' => $response->json()['checkout_request_id'] ?? null,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $response->json()['message'] ?? 'Payment initiation failed.',
            ], $response->status());

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => collect($e->errors())->flatten()->first(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Payment initiation failed', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to initiate payment. Please try again.',
            ], 500);
        }
    }

    public function checkPaymentStatus($orderId)
    {
        $token = request()->get('token', '');

        try {
            $response = Http::timeout(10)
                ->withoutVerifying()
                ->withHeaders(['Accept' => 'application/json'])
                ->get("{$this->djangoBase}/api/ecommerce/payment/status/{$orderId}/", [
                    'token' => $token,
                ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json(['success' => false, 'payment_status' => 'unknown'], $response->status());

        } catch (\Exception $e) {
            Log::error('Payment status check failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'payment_status' => 'unknown'], 503);
        }
    }

    public function paymentCallback(Request $request)
    {
        try {
            Http::timeout(10)
                ->withoutVerifying()
                ->withHeaders(['Accept' => 'application/json'])
                ->post("{$this->djangoBase}/api/mpesa/callback/", $request->all());
        } catch (\Exception $e) {
            Log::error('Payment callback error', ['error' => $e->getMessage()]);
        }

        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Accepted']);
    }
}