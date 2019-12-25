<?php
include 'DB.php';
$db = new DB();

// get data
$hospitals = $db->getRows('hospitals');
$success = true;
$message = "Data retrieve successful";

$results = array();

// check login
if($hospitals) {
	foreach ($hospitals as $hospital) {
		$items = array(
			'type' => 1,
			'id' => $hospital['id'],
			'name' => $hospital['name'],
			'email' => $hospital['email'],
			'phone' => $hospital['phone'],
			'address' => $hospital['address'],
			'created_at' => $hospital['created_at'],
			'updated_at' => $hospital['updated_at'],
		);
		array_push($results, $items);
	}
}
else {	
	$false = true;
	$message = "No hospital found";
}

// return response
$data = array(
	'success' => $success,
	'message' => $message,
	'hospitals' => $results,
);
echo json_encode($data, JSON_PRETTY_PRINT);