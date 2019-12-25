<?php
include 'DB.php';
$db = new DB();

// find hospital id from name
$hospital = $db->getRows('hospitals',array('where'=>array('email' => $_POST['email']),'return_type'=>'single'));

if($hospital) {
	$success = false;
	$message = "Hospital already registered this email";
}
else {
	$userData = array(
	    'name' => $_POST['name'],
	    'email' => $_POST['email'],
	    'phone' => $_POST['phone'],
	    'address' => $_POST['address'],
	    'password' => md5($_POST['password'])
	);
	$insert = $db->insert('hospitals',$userData);
	$success = $insert? true:false;
	$message = $insert?'Hospital has been registered successfully.':'Some problem occurred, please try again.';
}

// return response
$result = array(
	'success' => $success,
	'message' => $message,
);
echo json_encode($result, JSON_PRETTY_PRINT);