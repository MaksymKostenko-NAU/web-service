<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require_once 'GeoService.php';

$geoService = new GeoService();

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the URL path
    $requestUri = $_SERVER['REQUEST_URI'];

    if (str_contains($requestUri, '/geo-service/coordinates-by-city') !== false) {
        // Get the city parameter from the URL
        if (isset($_GET['city'])) {
            $response = $geoService->getCoordinates($_GET['city']);
            echo json_encode($response);
        } else {
            echo json_encode(['error' => 'City name not provided']);
        }
    } elseif (str_contains($requestUri, '/geo-service/city-by-coordinates') !== false) {
        // Get the latitude and longitude parameters from the URL
        if (isset($_GET['latitude']) && isset($_GET['longitude'])) {
            $response = $geoService->getCity($_GET['latitude'], $_GET['longitude']);
            echo json_encode($response);
        } else {
            echo json_encode(['error' => 'Latitude and Longitude not provided']);
        }
    } else {
        echo json_encode(['error' => 'Invalid endpoint']);
    }
} else {
    echo json_encode(['error' => 'Unsupported HTTP method']);
}