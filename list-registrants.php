<?php
require_once 'config.php';
 
function list_meeting() {
    $client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
    $db = new DB();
    $arr_token = $db->get_access_token();
    $accessToken = $arr_token->access_token;
 
    try {
        $response = $client->request('GET', 'v2/meetings/{meetingId}/registrants', [
            "headers" => [
                "Authorization" => "Bearer $accessToken"
            ]
        ]);
 
        $data = json_decode($response->getBody());
		//print_r($data);
		echo "join_url: ". $data->join_url;
        echo "<br>";
        echo "Total registrants records: ". $data->total_records;
 
    }

}
 
list_meeting();