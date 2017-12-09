<?php

/*

	// how to use the web service file with jquery ajax:
	
	// to update ApartmentNumber 1
	// fields not included here will n	ot be updated
	// fields included here
	$.post("ws.php", {
		op_id: 1,
		ApartmentNumber: 1,
		firstName: "Shay",
		seniority: 1,
		testField: "ggg"		// this is a new field so it will be inserted to apartment number 1
	}, function(data){
		console.log("returned from server:");
		console.log(data);
	});


	// to insert a new apartment at ApartmentNumber 1000
	// it is possible to add new fields to this new apartment
	// after insertion like it is done in the previous example
	// in fact, the insert example is exactly the same as the
	// update example (difference is when ApartmentNumber exists)
	$.post("ws.php", {
		op_id: 1,
		ApartmentNumber: 1000,
		lastName: "Ziv",
		testField2: "bbb"
	}, function(data){
		console.log("returned from server:");
		console.log(data);
	});

	
	// to delete an apartment at ApartmentNumber 1
	$.post("ws.php", {
		op_id: 2,
		ApartmentNumber: 1
	}, function(data){
		console.log("returned from server:");
		console.log(data);
	});

*/

// field names that should NOT be strings in the json
$number_field_names = array("seniority", "floor", "balance");

function send_result($output, $isError = false){
	$out = array(
		"isError" => $isError,
		"output" => $output
	);
	
	header('Content-type: application/json');
	echo json_encode($out);
	die();
}

function get_data_from_json_file(){
	$json = "";
	$json = @file_get_contents("data.json");	
	
	if ($json == "")
		return array();
	
	return @json_decode($json, true);
}

function save_data_to_json_file($data){
	@file_put_contents("data.json", json_encode($data));
}


// get op_id
$op_id = 0;

if (isset($_POST["op_id"])){
	$op_id = intval($_POST["op_id"]);
	unset($_POST["op_id"]);
}

/*
	op_id == 1		update/insert
	op_id == 2		delete
*/

if ($op_id < 1 || $op_id > 2)
	send_result("op_id POST parameter must be set to 1 or 2", true);



// get apartment number
$apart_num = 0;

if (isset($_POST["ApartmentNumber"]))
	$apart_num = intval($_POST["ApartmentNumber"]);

if ($apart_num < 1)
	send_result("ApartmentNumber POST parameter must be set and greater than zero", true);

$_POST["ApartmentNumber"] = $apart_num;

// get the data from json file
$saved_data = get_data_from_json_file();

// if user wanted to delete then delete apartment by apartment number
if ($op_id == 2){
	$reduced_data = array();
	foreach ($saved_data as $i => $apart){
		if (array_key_exists("ApartmentNumber", $apart) && intval($apart["ApartmentNumber"]) != $apart_num)
			$reduced_data[] = $apart;
	}
	
	save_data_to_json_file($reduced_data);
	send_result(true);
	die();
}

// arrange received data to be saved / updated
$new_data = array();
foreach ($_POST as $field_name => $field_val){
	if ($field_name == "")
		continue;
	
	if (in_array($field_name, $number_field_names)){
		// field is a number so save it to json as number and not as string
		$field_val = floatval($field_val);
	}

	$new_data[$field_name] = $field_val;
}

$is_found = false;
$saved_data_i = -1;
foreach ($saved_data as $i => $apart){
	if (array_key_exists("ApartmentNumber", $apart) && intval($apart["ApartmentNumber"]) == $apart_num){
		$is_found = true;
		$saved_data_i = $i;
		break;
	}
}

if ($is_found){
	// this is an update
	foreach ($new_data as $field_name => $field_val)
		$saved_data[$saved_data_i][$field_name] = $field_val;
	
} else {
	// this is an insert
	$saved_data[] = $new_data;
}

save_data_to_json_file($saved_data);
send_result(true);



