<?php
include 'DB.php';
$db = new DB();

$email = $_POST['email'];
$password = $_POST['password'];

// get data
$hospital = $db->getRows('hospitals',array('where'=>array('email'=>"$email"),'return_type'=>'single'));
$success = true;
$message = "Login successful";

// check login
if($hospital) {
	// check password
	if(md5($password) != $hospital['password']) {
		$success = false;
		$message = "Password not matched";
	}
}
else {	
	$success = false;
	$message = "Email or password don't match";}

// return response
$result = array(
	'success' => $success,
	'message' => $message,
	'type' => "hospital",
	'hospital_id' => $hospital['id'],
	'name' => $hospital['name'],
);
echo json_encode($result, JSON_PRETTY_PRINT);