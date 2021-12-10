
<?php
require_once 'config.php';

function main_token() {
    $client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
 
    $db = new DB();
    $arr_token = $db->get_access_token();
    $accessToken = $arr_token->access_token;
 
    
        $response = $client->request('GET', 'v2/users/kipszoom@outlook.com', [
            
        ]);
 
        $data = json_decode($response->getBody());
		print_r($data);
		/**print_r($data->meetings);
		foreach ($data->meetings as $arr) {
		 echo "Id".$arr->id;
         echo "<br>";
		 echo "Id".$arr->id;
         echo "<br>";
		 **/

    

}
 
main_token();