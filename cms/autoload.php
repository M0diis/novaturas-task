<?php
// Path: cms/autoload.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include(__DIR__."/config.php");
include(__DIR__."/system/connection.php");
include(__DIR__."/system/functions.php");

init();

function init()
{
	session_start();

	// Could be used to check if user is logged in.
}
?>