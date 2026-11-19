<?php

namespace Database\Seeders\Concerns;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use RuntimeException;

trait DownloadsIranDivisionData
{
    protected function iranDivisionData(string $filename): array
    {
        $directory = storage_path('app/iran-divisions');
        $path = $directory . DIRECTORY_SEPARATOR . $filename;
        File::ensureDirectoryExists($directory);


        if (! File::exists($path)) {
            $url = "https://raw.githubusercontent.com/sajaddp/list-of-cities-in-Iran/main/dist/json/{$filename}";

            $response = Http::timeout(60)
                ->retry(2, 500)
                ->get($url);

            $response->throw();

            File::put($path, $response->body());
        }

        $data = json_decode(File::get($path), true, 512, JSON_THROW_ON_ERROR);

        if (! is_array($data)) {
            throw new RuntimeException("Invalid JSON dataset: {$filename}");
        }

        return $data;
    }
}
