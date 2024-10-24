<?php

class GeoService
{
    private string $userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.0 Safari/605.1.15';

    // Get coordinates from city name
    public function getCoordinates(string $city): array
    {
        $city = urlencode($city);
        $url = "https://nominatim.openstreetmap.org/search?q={$city}&format=json&limit=1";

        $context = stream_context_create([
            'http' => [
                'header' => "User-Agent: $this->userAgent",
            ]
        ]);
        $response = file_get_contents($url, false, $context);
        $data = json_decode($response, true);

        if (!empty($data)) {
            return [
                'latitude' => $data[0]['lat'],
                'longitude' => $data[0]['lon']
            ];
        } else {
            return ['error' => 'City not found'];
        }
    }

    public function getCity(float $latitude, float $longitude): array
    {
        $url = "https://nominatim.openstreetmap.org/reverse?lat={$latitude}&lon={$longitude}&format=json";
        $context = stream_context_create([
            'http' => [
                'header' => "User-Agent: $this->userAgent",
            ]
        ]);
        $response = file_get_contents($url, false, $context);

        $data = json_decode($response, true);

        if (!empty($data) && isset($data['address']['city'])) {
            return ['city' => $data['address']['city']];
        } else {
            return ['error' => 'City name not found'];
        }
    }
}