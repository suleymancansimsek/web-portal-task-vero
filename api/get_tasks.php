<?php
// get_tasks.php

include 'auth.php'; // to take token include auth.php

function getTasks() {
    $token = getAccessToken(); // take token
    
    if (strpos($token, "cURL Error") !== false) {
        return $token;
    }

    $curl = curl_init();
    
    // GET reguest
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.baubuddy.de/dev/index.php/v1/tasks/select",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer " . $token, // add token into header
            "Content-Type: application/json"
        ]
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return "cURL Error: " . $err;
    } else {
        return json_decode($response, true); // return JSON
    }
}
?>
