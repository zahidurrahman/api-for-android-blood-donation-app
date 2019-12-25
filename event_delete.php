<?php
include 'DB.php';
$db = new DB();

$condition = array('id' => $_POST['id']);
$delete = $db->delete('events',$condition);

$success = $delete? true:false;
$message = $delete?'Event successfully deleted.':'Some problem occurred, please try again.';

// return response
$result = array(
	'success' => $success,
	'message' => $message,
);
echo json_encode($result, JSON_PRETTY_PRINT);