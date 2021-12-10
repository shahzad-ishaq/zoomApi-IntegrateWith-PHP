<?php
require_once 'config.php';
 
$client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
 
$db = new DB();
$arr_token = $db->get_access_token();
echo $accessToken = $arr_token->access_token;
 
$response = $client->request('DELETE', '/v2/meetings/76285161496', [
    "headers" => [
        "Authorization" => "Bearer $accessToken"
    ]
]);
