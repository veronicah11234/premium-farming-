<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CategoryComposer
{
    public function compose(View $view): void
    {
        $categories = [];

        try {

            $apiUrl = rtrim(
                config('services.django_api.url'),
                '/'
            );

            $response = Http::timeout(10)
                ->acceptJson()
                ->get($apiUrl . '/categories/');

            if ($response->successful()) {

                $data = $response->json();

                if (is_array($data)) {
                    $categories = $data;
                }

            } else {

                Log::error('Category API failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

            }

        } catch (\Throwable $e) {

            Log::error('Category composer error', [
                'message' => $e->getMessage(),
            ]);

        }

        $view->with('globalCategories', $categories);
    }
}