<?php
// auth.php

function getAccessToken() {
    $curl = curl_init();
    
    // API login config
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.baubuddy.de/index.php/login",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Basic QVBJX0V4cGxvcmVyOjEyMzQ1NmlzQUxhbWVQYXNz",
            "Content-Type: application/json"
        ],
        CURLOPT_POSTFIELDS => json_encode([
            "username" => "365",
            "password" => "1"
        ])
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return "cURL Error: " . $err;
    } else {
        $responseData = json_decode($response, true);
        return $responseData["oauth"]["access_token"]; // return Access token
}
}
?>
