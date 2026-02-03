<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProxyRequest
{
    public function handle(Request $request, Closure $next, string $serviceUrl)
    {
        // ---- HEADERS ----
        $headers = collect($request->headers->all())
            ->except(['host', 'content-length', 'cookie'])
            ->map(fn($values) => $values[0] ?? '')
            ->toArray();

        // ---- BASE OPTIONS ----
        $options = [
            'query' => $request->query(),
            'headers' => $headers,
        ];

        // ---- BODY TYPES ----
        $contentType = $request->header('Content-Type', '');

        if ($request->isJson()) {
            $options['json'] = $request->json()->all();
        } elseif (str_starts_with($contentType, 'multipart/form-data')) {
            $options['multipart'] = [];

            foreach ($request->allFiles() as $key => $file) {
                $options['multipart'][] = [
                    'name' => $key,
                    'contents' => fopen($file->getRealPath(), 'r'),
                    'filename' => $file->getClientOriginalName(),
                    'headers' => [
                        'Content-Type' => $file->getMimeType(),
                    ],
                ];
            }

            foreach ($request->except(array_keys($request->allFiles())) as $key => $value) {
                $options['multipart'][] = [
                    'name' => $key,
                    'contents' => $value,
                ];
            }
        } else {
            $options['form_params'] = $request->all();
        }

        // ---- BUILD TARGET URL ----
        $proxiedPath = $request->route('path') ?? '';
        $url = rtrim($serviceUrl, '/') . '/' . ltrim($proxiedPath, '/');

        // ---- SEND ----
        $response = Http::withOptions(['verify' => false]) // optional
            ->send($request->method(), $url, $options);

        // ---- RETURN RESPONSE ----
        return response($response->body(), $response->status())
            ->withHeaders(
                collect($response->headers())
                    ->except(['transfer-encoding', 'content-encoding', 'content-length'])
                    ->toArray()
            );
    }
}
