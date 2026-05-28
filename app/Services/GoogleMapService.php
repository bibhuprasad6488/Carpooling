<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleMapService
{
    public function getRouteDetails($pickupLat, $pickupLng, $dropLat, $dropLng, $departureTimestamp)
    {
        $apiKey = config('services.google_maps.key');

        $response = Http::get('https://maps.googleapis.com/maps/api/directions/json', [
            'origin'      => "{$pickupLat},{$pickupLng}",
            'destination' => "{$dropLat},{$dropLng}",
            'mode'        => 'driving',
            'departure_time' => $departureTimestamp, // enables traffic-based ETA
            'key'         => $apiKey,
        ]);

        if ($response->failed() || empty($response['routes'])) {
            // Log::error('Error: ', ['resp' => $response]);
            throw new \Exception($responseData['error_message'] ?? 'Unable to fetch route from Google Maps.');
        }

        $route = $response['routes'][0];
        $leg   = $route['legs'][0];

        return [
            'polyline' => $route['overview_polyline']['points'],
            'distance' => $leg['distance']['value'], // meters
            'duration' => $leg['duration']['value'], // seconds
            'duration_in_traffic' => $leg['duration_in_traffic']['value'] ?? $leg['duration']['value'],
            'start_address' => $leg['start_address'],
            'end_address' => $leg['end_address'],
        ];
    }

    /**
     * Decode Google encoded polyline into latitude/longitude points.
     */
    public function decodePolyline($encoded)
    {
        $points = [];
        $index = 0;
        $lat = 0;
        $lng = 0;

        while ($index < strlen($encoded)) {
            $result = 1;
            $shift = 0;
            do {
                $b = ord($encoded[$index++]) - 63 - 1;
                $result += $b << $shift;
                $shift += 5;
            } while ($b >= 0x1f);
            $lat += ($result & 1) ? ~($result >> 1) : ($result >> 1);

            $result = 1;
            $shift = 0;
            do {
                $b = ord($encoded[$index++]) - 63 - 1;
                $result += $b << $shift;
                $shift += 5;
            } while ($b >= 0x1f);
            $lng += ($result & 1) ? ~($result >> 1) : ($result >> 1);

            $points[] = [
                'lat' => $lat * 1e-5,
                'lng' => $lng * 1e-5,
            ];
        }

        return $points;
    }
}
