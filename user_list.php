<?php
include 'DB.php';
$db = new DB();

$hospital_id = $_POST['hospital_id'];

// get data
$users = $db->getRows('users',array('where'=>array('hospital_id'=>"$hospital_id")));
$success = true;
$message = "Data retrieve successful";

$hospital = $db->getRows('hospitals',array('where'=>array('id'=>"$hospital_id"), 'return_type'=>'single'));

$results = array();

// check login
if($users) {
	foreach ($users as $user) {
		$items = array(
			'type' => 1,
			'user_id' => $user['id'],
			'hospital_id' => $hospital_id,
			'hospital_name' => $hospital['name'],
			'user_name' => $user['name'],
			'user_email' => $user['email'],
			'user_phone' => $user['phone'],
			'user_address' => $user['address'],
			'user_blood_group' => $user['blood_group'],
			'user_last_donate' => $user['last_donate'],
			'user_active_status' => $user['active_status'],
			'created_at' => $user['created_at'],
			'updated_at' => $user['updated_at'],
		);
		array_push($results, $items);
	}
}
else {	
	$false = true;
	$message = "No user found";
}

// return response
$data = array(
	'success' => $success,
	'message' => $message,
	'results' => $results,
);
echo json_encode($data, JSON_PRETTY_PRINT);