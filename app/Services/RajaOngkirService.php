<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class RajaOngkirService
{
    private function client(): PendingRequest
    {
        $apiKey = config('services.rajaongkir.api_key');

        if (!$apiKey) {
            throw new RuntimeException('RajaOngkir API Key belum dikonfigurasi.');
        }

        return Http::baseUrl(rtrim(config('services.rajaongkir.base_url'), '/'))
            ->withHeaders(['key' => $apiKey])
            ->acceptJson()
            ->timeout(25);
    }

    /** @return array<int, array<string, mixed>> */
    public function searchDestinations(string $keyword, int $limit = 10): array
    {
        $keyword = trim($keyword);

        if (mb_strlen($keyword) < 3) {
            return [];
        }

        $cacheKey = 'rajaongkir:destination:' . md5(mb_strtolower($keyword) . ':' . $limit);

        return Cache::remember($cacheKey, now()->addHour(), function () use ($keyword, $limit) {
            $response = $this->client()->get('/destination/domestic-destination', [
                'search' => $keyword,
                'limit' => $limit,
                'offset' => 0,
            ]);

            $payload = $response->json() ?? [];

            // API mengembalikan HTTP 404 dan meta.code 404 bila alamat tidak ditemukan.
            if ($response->status() === 404 || ($payload['meta']['code'] ?? null) === 404) {
                return [];
            }

            $response->throw();

            if (($payload['meta']['code'] ?? null) !== 200) {
                throw new RuntimeException($payload['meta']['message'] ?? 'Gagal mencari alamat tujuan.');
            }

            return is_array($payload['data'] ?? null) ? $payload['data'] : [];
        });
    }

    /** @return array<int, array<string, mixed>> */
    public function calculateDomestic(
        int $destinationId,
        int $weightGrams,
        ?string $courier = null
    ): array {
        $originId = (int) config('services.rajaongkir.origin_id');
        $courier = strtolower(trim($courier ?: (string) config('services.rajaongkir.couriers')));

        if ($originId < 1) {
            throw new RuntimeException('ID kecamatan asal pengiriman belum diatur di RAJAONGKIR_ORIGIN_ID.');
        }

        if ($destinationId < 1) {
            throw new RuntimeException('Alamat tujuan belum dipilih.');
        }

        if ($weightGrams < 1) {
            throw new RuntimeException('Berat paket harus lebih dari 0 gram.');
        }

        if (!preg_match('/^[a-z0-9]+(?::[a-z0-9]+)*$/', $courier)) {
            throw new RuntimeException('Kode ekspedisi tidak valid.');
        }

        $response = $this->client()
            ->asForm()
            ->post('/calculate/domestic-cost', [
                'origin' => $originId,
                'destination' => $destinationId,
                'weight' => $weightGrams,
                'courier' => $courier,
                'price' => 'lowest',
            ]);

        $payload = $response->json() ?? [];
        $response->throw();

        if (($payload['meta']['code'] ?? null) !== 200) {
            throw new RuntimeException($payload['meta']['message'] ?? 'Gagal menghitung ongkos kirim.');
        }

        return is_array($payload['data'] ?? null) ? $payload['data'] : [];
    }
}
