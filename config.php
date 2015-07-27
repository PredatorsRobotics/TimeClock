<?php
	$timezone = "America/Chicago";

	// Database Information
	$servername = "127.0.0.1";
	$username = "villnoweric";
	$password = "";
	$database = "timeclock";
	
	$user_table = "users";
	$data_table = "hours";
	
	$title = "Predators Time Clock";
	$req_comp = 30; //Hours required for competition
	$req_letter = 60; //Hours required to letter
	date_default_timezone_set($timezone); // A bit of ignorable code to make the above work
?>