<?php
include 'DB.php';
$db = new DB();

$hospital_id = $_POST['hospital_id'];

// get data
$events = $db->getRows('events',array('where'=>array('hospital_id'=>"$hospital_id")));
$success = true;
$message = "Data retrieve successful";

$results = array();

// check login
if($events) {
	foreach ($events as $event) {
		$items = array(
			'type' => 2,
			'event_id' => $event['id'],
			'hospital_id' => $event['hospital_id'],
			'event_name' => $event['event_name'],
			'event_date' => $event['event_date'],
			'event_location' => $event['event_location'],
			'created_at' => $event['created_at'],
			'updated_at' => $event['updated_at'],
		);
		array_push($results, $items);
	}
}
else {	
	$false = true;
	$message = "No event found";
}

// return response
$data = array(
	'success' => $success,
	'message' => $message,
	'results' => $results,
);
echo json_encode($data, JSON_PRETTY_PRINT);