<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" /> 
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<?php
require_once 'config.php';

function list_users() {
    $db = new DB();
    $arr_token = $db->get_access_token();
    $accessToken = $arr_token->access_token;

    $cURLConnection = curl_init();
    curl_setopt($cURLConnection, CURLOPT_URL, 'https://api.zoom.us/v2/users?page_size=100');
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer '.$accessToken
    ));

    $dataList = curl_exec($cURLConnection);
    curl_close($cURLConnection);
    $data = json_decode($dataList);

    echo "Total Meeting: ". $data->total_records;
		$url = "http://zoom.kips.edu.pk/list-meeting.php?client_id=";
    $db = new DB();
    $db->update_zoom_users($data->users);
 ?>
 <body style="
    margin: 60px;">
	<h2>User List</h2>
 <table id="example" class="table table-striped table-bordered" style="width:100%">
 </body>
        <thead>
            <tr>
               <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>email</th>
                <th>status</th>
                <th>User Type</th>
                <th>User host key</th>
                <th>List Of Meeting</th>
            </tr>
        </thead>
        <tbody>
		<?php foreach ($data->users as $arr) {
            /*$cURLConnection2 = curl_init();
            curl_setopt($cURLConnection2, CURLOPT_URL, 'https://api.zoom.us/v2/users/'.$arr->id.'');
            curl_setopt($cURLConnection2, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cURLConnection2, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer '.$accessToken
            ));

            $User_data = curl_exec($cURLConnection2);
            curl_close($cURLConnection2);
            $dataUser = json_decode($User_data);*/
            //$dataUser->host_key;

            ?>
            <tr>
                <td><?php echo $arr->id;?></td>
                <td><?php echo $arr->first_name;?></td>
                <td><?php echo $arr->last_name;?></td>
                <td><?php echo $arr->email;?></td>

                <td><?php echo $arr->status;?></td>
                <td><?php echo $arr->type;?></td>
              <!--  <td><?php /*$dataUser->host_key;*/?></td>-->
                <td><a href="<?php echo $url; ?><?php echo $arr->id;?>">List Of Meeting</a></td>
                
            </tr>
		<?php }?></tbody>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>email</th>
                <th>Pmi</th>
                <th>Phone Number</th>
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
 
list_users();