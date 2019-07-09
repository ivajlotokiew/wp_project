<?php

require_once( dirname( __FILE__ ) .  '/combat_http_client.php' );

function combat_call_api($action, $params = array()) {
    if (!is_array($params)){
        $params = array($params);
    }

    $http_client = new HttpClient();
    $http_client->setAction($action);
    $headers = array();
    $response = $http_client->post($params, $headers, "application/x-www-form-urlencoded");
    if (!isset($response)) {
        $response = array("code" => 500, "message" => "Server Error");
    }

    return generate_response($response);
}

function generate_response ($response) {
    if (isset($response["code"]) && isset($response["body"])) {
        http_response_code($response["code"]);
        return array("code" => $response["code"], "body" => json_decode($response["body"], true));
    }
    else {
        return $response;
    }
}