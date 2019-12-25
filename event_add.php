<?php
include 'DB.php';
$db = new DB();

$userData = array(
    'hospital_id' => $_POST['hospital_id'],
    'event_name' => $_POST['event_name'],
    'event_date' => $_POST['event_date'],
    'event_location' => $_POST['event_location'],
);

$insert = $db->insert('events',$userData);
$success = $insert? true:false;
$message = $insert?'Event added successfully.':'Some problem occurred, please try again.';

// return response
$result = array(
	'success' => $success,
	'message' => $message,
);
echo json_encode($result, JSON_PRETTY_PRINT);