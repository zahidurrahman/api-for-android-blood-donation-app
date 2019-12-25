<?php
include 'DB.php';
$db = new DB();

// get password
$password = $_POST['password'];

// user data
$user = $db->getRows('users',array('where'=>array('email'=>$_POST['email']),'return_type'=>'single'));

// find hospital id from name
$hospital = $db->getRows('hospitals',array('where'=>array('name'=>$_POST['hospital_name']),'return_type'=>'single'));

// check last donation date
$last_donation_date = $_POST['last_donate'];

// user data
$user = $db->getRows('users',array('where'=>array('email'=>'user@demo.com'),'return_type'=>'single'));
$user_old_last_donate_date = $user['last_donate'];
$suggested_last_donate_date = "";
$can_update_donation_date = true;

if (!empty($user_old_last_donate_date)) {
	// convert two dates
	$check_last_donation_date = strtotime($last_donation_date);
	$check_user_old_last_donate_date = strtotime($user_old_last_donate_date);

	// if the dates are different
	if ($check_last_donation_date != $check_user_old_last_donate_date) {
		// add 120 days with old date
		$suggested_last_donate_date =  date('Y-m-d', strtotime($user_old_last_donate_date. ' + 120 days'));

		// compare two dates
		$ctd_last_donation_date = strtotime($last_donation_date);
		$ctd_suggested_last_donate_date = strtotime($suggested_last_donate_date);

		if ($ctd_last_donation_date < $ctd_suggested_last_donate_date) {
			$can_update_donation_date = false;
		}
	}
}

// check donation date
if($can_update_donation_date) {
	if (empty($password)) {
		$userData = array(
		    'hospital_id' => $hospital['id'],
		    'name' => $_POST['name'],
		    'email' => $_POST['email'],
		    'phone' => $_POST['phone'],
		    'address' => $_POST['address'],
		    'blood_group' =>$_POST['blood_group'],
		    'last_donate' =>$_POST['last_donate'],
		    'active_status' => $_POST['active_status'],
		);
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
	}

	$condition = array('id' => $_POST['user_id']);
	$update = $db->update('users',$userData,$condition);

	$success = $update? true:false;
	$message = $update?'User successfully updated.':'Some problem occurred, please try again.';
}
else {
	$success = false;
	$message = "The donation date must bigger than last donation date.";
}

// return response
$result = array(
	'success' => $success,
	'message' => $message,
);
echo json_encode($result, JSON_PRETTY_PRINT);