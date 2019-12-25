<?php
include 'DB.php';
$db = new DB();

// find hospital id from name
$hospital = $db->getRows('hospitals',array('where'=>array('name'=>$_POST['hospital_name']),'return_type'=>'single'));

// check user
$user = $db->getRows('users',array('where'=>array('email'=>$_POST['email']),'return_type'=>'single'));

if($user) {
	$success = false;
	$message = "User already registered with this email";
}
else {
	$userData = array(
	    'hospital_id' => $hospital['id'],
	    'name' => $_POST['name'],
	    'email' => $_POST['email'],
	    'phone' => $_POST['phone'],
	    'address' => $_POST['address'],
	    'password' => md5($_POST['password']),
	    'blood_group' =>$_POST['blood_group'],
	    'last_donate' =>$_POST['last_donate'],
	    'active_status' => $_POST['active_status'],
	);

	$insert = $db->insert('users',$userData);
	$success = $insert? true:false;
	$message = $insert?'User has been registered successfully.':'Some problem occurred, please try again.';
}

// return response
$result = array(
	'success' => $success,
	'message' => $message,
);
echo json_encode($result, JSON_PRETTY_PRINT);