<?php
include 'DB.php';
$db = new DB();

$condition = array('id' => $_POST['user_id']);
$delete = $db->delete('users',$condition);

$success = $delete? true:false;
$message = $delete?'User successfully deleted.':'Some problem occurred, please try again.';

// return response
$result = array(
	'success' => $success,
	'message' => $message,
);
echo json_encode($result, JSON_PRETTY_PRINT);