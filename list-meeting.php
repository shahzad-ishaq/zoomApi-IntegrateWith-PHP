<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" /> 
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<?php
require_once 'config.php';


function list_meeting() {

    $db = new DB();
    $arr_token = $db->get_access_token();
    $accessToken = $arr_token->access_token;
    $users_id  = $_GET['client_id'];
    $cURLConnection = curl_init();
    curl_setopt($cURLConnection, CURLOPT_URL, 'https://api.zoom.us/v2/users/'.$users_id.'/meetings');
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer '.$accessToken
    ));

    $phoneList = curl_exec($cURLConnection);
    curl_close($cURLConnection);

    $data = json_decode($phoneList);
    //print_r($data->meetings);
	echo "Total Meeting: ". $data->total_records;
 ?>
 <body style="
    margin: 60px;">
 <table id="example" class="table table-striped table-bordered" style="width:100%">
 </body>
        <thead>
            <tr>
                <th>ID</th>
                <th>Topic</th>
                <th>Start Time</th>
                <th>Duration</th>
                <th>Created date</th>
                <th>Join Url</th>
            </tr>
        </thead>
        <tbody>
		<?php foreach ($data->meetings as $arr) { ?>
            <tr>
                <td><?php echo $arr->id;?></td>
                <td><?php echo $arr->topic;?></td>
                <td><?php echo $arr->start_time;?></td>
                <td><?php echo $arr->duration;?></td>
                <td><?php echo $arr->created_at;?></td>
                <td><?php echo $arr->join_url;?></td>
                
            </tr>
		<?php } ?></tbody>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Topic</th>
                <th>Start Time</th>
                <th>Duration</th>
                <th>Created date</th>
                <th>Join Url</th>
            </tr>
        </tfoot>
    </table>
 <script>
 $(document).ready(function() {
    $('#example').DataTable();
} );
</script>
 <?php
    

}
 
list_meeting();