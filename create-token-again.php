
<?php
require_once 'config.php';
function create_meeting() {
    $db = new DB();
    $refresh_token = $db->get_refersh_token();
    $client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
    $response = $client->request('POST', '/oauth/token', [
        "headers" => [
            "Authorization" => "Basic ". base64_encode(CLIENT_ID.':'.CLIENT_SECRET)
        ],
        'form_params' => [
            "grant_type" => "refresh_token",
            "refresh_token" => $refresh_token
        ],
    ]);
    $token = json_decode($response->getBody()->getContents(), true);
    $db->update_access_token(json_encode($token));
    echo "Access token inserted successfully.";
	}
 
create_meeting();
