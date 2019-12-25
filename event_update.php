<?php
include 'DB.php';
$db = new DB();

$eventData = array(
    'event_name' => $_POST['name'],
    'event_date' => $_POST['date'],
    'event_location' => $_POST['location'],
);

$condition = array('id' => $_POST['id']);
$update = $db->update('events',$eventData,$condition);

$success = $update? true:false;
$message = $update?'Event successfully updated.':'Some problem occurred, please try again.';

// return response
$result = array(
	'success' => $success,
	'message' => $message,
);
echo json_encode($result, JSON_PRETTY_PRINT);