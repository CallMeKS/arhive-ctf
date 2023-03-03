<?php

$sname= "localhost";
$uname= "readlyst";
$password = "P@ssw0rd";
$db_name = "readlyst";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
}

if (isset($_COOKIE['debug'])) {
	if ($_COOKIE['debug'] == "true" || $_COOKIE['debug'] == 1) {
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
	}
}

function mysql_debug($result, $conn) {		
	if (isset($_COOKIE['debug'])) {
		if ($_COOKIE['debug'] == "true" || $_COOKIE['debug'] == 1) {
			if (!isset($_SESSION['mysql_error'])) {
				$_SESSION['mysql_error'] = array();
			}
			if (!$result) {
				$_SESSION['mysql_error'][] = mysqli_error($conn);
			}
		}
	}
}
