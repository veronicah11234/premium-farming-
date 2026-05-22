<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected string $djangoBase;

    public function __construct()
    {
        $this->djangoBase = rtrim(config('services.django_api.url'), '/');
    }

    
    private function djangoAuthHeaders(): array
    {
        $headers = ['Accept' => 'application/json'];

        $token = Session::get('django_token');

        if ($token) {
            $headers['Authorization'] = 'Bearer ' . $token;
        } else {
           
            $headers['X-Session-ID'] = Session::getId();
        }

        return $headers;
    }

    
    public function getCsrfToken()
    {
        try {
            $response = Http::withHeaders([
                'ngrok-skip-browser-warning' => '1',
            ])->withOptions([
                'verify' => false,
            ])->get($this->djangoBase . '/ecommerce/csrf-token/');

            if (!$response->successful()) {
                Log::error('[OrderController] CSRF fetch failed', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return response()->json(['error' => 'Failed to fetch CSRF token'], 500);
            }

          
            $setCookie = $response->header('Set-Cookie');
            if ($setCookie) {
                preg_match('/csrftoken=([^;]+)/', $setCookie, $csrfMatches);
                if (!empty($csrfMatches[1])) {
                    Session::put('django_csrftoken_cookie', $csrfMatches[1]);
                }
            }

            return response()->json($response->json());

        } catch (\Exception $e) {
            Log::error('[OrderController] getCsrfToken exception: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    
    public function createOrder(Request $request)
    {
        try {
            $data = $request->validate([
                'cart_id'       => 'required|string',
                'customer_name' => 'required|string',
                'phone_number'  => 'required|string',
                'django_csrf'   => 'nullable|string', 
            ]);

            $djangoCsrf = $data['django_csrf'] ?? null;
            unset($data['django_csrf']); 

            
            $headers = array_merge(
                $this->djangoAuthHeaders(),
                [
                    'Content-Type'               => 'application/json',
                    'ngrok-skip-browser-warning' => '1',
                ]
            );

            if ($djangoCsrf) {
                $headers['X-CSRFToken'] = $djangoCsrf;
            }

            $csrftokenCookie = Session::get('django_csrftoken_cookie');
            if ($csrftokenCookie) {
                $headers['Cookie'] = "csrftoken={$csrftokenCookie}";
            }

            $response = Http::withHeaders($headers)
                ->withOptions(['verify' => false])
                ->post($this->djangoBase . '/api/ecommerce/place-order/', $data);

            Log::info('[OrderController] place-order', [
                'status'       => $response->status(),
                'session_id'   => Session::getId(),
                'has_token'    => Session::has('django_token'),
                'body'         => $response->body(),
            ]);

            return response()->json($response->json(), $response->status());

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            Log::error('[OrderController] createOrder exception: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

   
    public function showConfirmation(Request $request, string $orderId)
    {
        return view('checkout.confirmation', ['orderId' => $orderId]);
    }
}