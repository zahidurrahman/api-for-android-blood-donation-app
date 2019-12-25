<?php
include 'DB.php';
$db = new DB();

$email = $_POST['email'];
$password = $_POST['password'];

// get user data
$user = $db->getRows('users',array('where'=>array('email'=>$email),'return_type'=>'single'));
$success = true;
$message = "Login successful";

// get hospital data
$hospital = $db->getRows('hospitals',array('where'=>array('id'=>$user['hospital_id']),'return_type'=>'single'));

// check login
if($user) {
	// check password
	if(md5($password) != $user['password']) {
		$success = false;
		$message = "Password not matched";
	}
}
else {	
	$success = false;
	$message = "Email or password don't match";
}

// return response
$result = array(
	'success' => $success,
	'message' => $message,
	'type' => "user",
	'user_id' => $user['id'],
	'hospital_id' => $user['hospital_id'],
	'hospital_name' => $hospital['name'],
	'name' => $user['name'],
	'email' => $user['email'],
	'phone' => $user['phone'],
	'address' => $user['address'],
	'blood_group' => $user['blood_group'],
	'last_donate' => $user['last_donate'],
	'active_status' => $user['active_status'],
);
echo json_encode($result, JSON_PRETTY_PRINT);