<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProxyRequest
{
    public function handle(Request $request, Closure $next, string $serviceUrl)
    {
        $proxiedPath = $request->route('path') ?? '';
        $url = rtrim($serviceUrl, '/') . '/' . ltrim($proxiedPath, '/');

        // ---- HEADERS (forward) ----
        $headers = collect($request->headers->all())
            ->except(['host', 'content-length', 'cookie'])
            ->map(function ($values) {
                // keep multi-values as comma-joined (typical HTTP behavior)
                return is_array($values) ? implode(',', $values) : (string) $values;
            })
            ->toArray();

        // Add/propagate request id (optional)
        $headers['X-Request-Id'] = $request->header('X-Request-Id', (string) str()->uuid());

        // ---- BASE OPTIONS ----
        $options = [
            'query'   => $request->query(),
            'headers' => $headers,
        ];

        $contentType = (string) $request->header('Content-Type', '');

        // ---- BODY ----
        if ($request->isJson()) {
            $options['json'] = $request->json()->all();
        }
        elseif (str_starts_with($contentType, 'multipart/form-data')) {

            // IMPORTANT: let client build boundary; don't forward original content-type
            unset($options['headers']['content-type'], $options['headers']['Content-Type']);

            $options['multipart'] = [];

            // files (handles arrays/nested)
            foreach ($this->flattenFiles($request->allFiles()) as $name => $file) {
                /** @var UploadedFile $file */
                $options['multipart'][] = [
                    'name'     => $name,
                    'contents' => fopen($file->getRealPath(), 'r'),
                    'filename' => $file->getClientOriginalName(),
                    'headers'  => [
                        'Content-Type' => $file->getMimeType() ?: 'application/octet-stream',
                    ],
                ];
            }

            // fields (handles arrays/nested)
            foreach ($this->flattenFields($request->except(array_keys($request->allFiles()))) as $name => $value) {
                $options['multipart'][] = [
                    'name'     => $name,
                    'contents' => is_bool($value) ? ($value ? '1' : '0') : (string) $value,
                ];
            }
        }
        else {
            // Default: form-url-encoded
            // Laravel HTTP client: use asForm() rather than form_params
            $options['data'] = $request->all();
        }

        // ---- SEND ----
        $http = Http::withOptions([
                'verify' => true, // keep true; turn off only if you really must
            ])
            ->connectTimeout(5)
            ->timeout(30)
            ->retry(1, 200); // 1 retry, 200ms

        // If not json and not multipart => send as form
        if (!isset($options['json']) && !isset($options['multipart']) && isset($options['data'])) {
            $http = $http->asForm();
        }

        $response = $http->send($request->method(), $url, $options);

        // ---- RETURN (copy headers safely) ----
        $respHeaders = collect($response->headers())
            ->except(['transfer-encoding', 'content-encoding', 'content-length'])
            ->map(function ($v) {
                // response headers are arrays
                return is_array($v) ? implode(',', $v) : $v;
            })
            ->toArray();

        return response($response->body(), $response->status())
            ->withHeaders($respHeaders);
    }

    /**
     * Flatten uploaded files into "field" => UploadedFile
     * Supports nested arrays like files[0], files[a][b]
     */
    private function flattenFiles(array $files, string $prefix = ''): array
    {
        $out = [];

        foreach ($files as $key => $value) {
            $name = $prefix === '' ? $key : "{$prefix}[{$key}]";

            if ($value instanceof UploadedFile) {
                $out[$name] = $value;
            } elseif (is_array($value)) {
                $out += $this->flattenFiles($value, $name);
            }
        }

        return $out;
    }

    /**
     * Flatten fields into multipart-compatible names:
     * a[b][c] => value, and arrays a[].
     */
    private function flattenFields(array $data, string $prefix = ''): array
    {
        $out = [];

        foreach ($data as $key => $value) {
            $name = $prefix === '' ? $key : "{$prefix}[{$key}]";

            if (is_array($value)) {
                $out += $this->flattenFields($value, $name);
            } else {
                $out[$name] = $value;
            }
        }

        return $out;
    }
}