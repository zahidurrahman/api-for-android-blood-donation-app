<?php
include 'DB.php';
$db = new DB();

// get data
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// check user
$user = $db->getRows('users',array('where'=>array('email'=>$email),'return_type'=>'single'));

if($user) {
	$success = false;
	$message = "User already registered with this email";
}
else {
	$userData = array(
	    'hospital_id' => $_POST['hospital_id'],
	    'name' => $name,
	    'email' => $email,
	    'phone' => $_POST['phone'],
	    'address' => $_POST['address'],
	    'password' => md5($password),
	    'blood_group' =>$_POST['blood_group'],
	    'last_donate' =>$_POST['last_donate'],
	    'active_status' => $_POST['active_status'],
	);

	$insert = $db->insert('users',$userData);
	$success = $insert? true:false;
	$message = $insert?'User has been added successfully.':'Some problem occurred, please try again.';
}

// // send email to user if successfully added
// if($success) {

// 	// the message
// 	$msg = "Welcome $name \nThis is your login details\nEmail: $email & password: $password \nThanks.";
// 	$msg = wordwrap($msg,70);

// 	// send email
// 	mail($email,"My subject",$msg);
// }

// return response
$result = array(
	'success' => $success,
	'message' => $message,
);
echo json_encode($result, JSON_PRETTY_PRINT);