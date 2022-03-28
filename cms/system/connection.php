<?php
// Path: cms\system\connection.php

$mysqli = mysqli_connect(SQL_HOST, SQL_USER, SQL_PASSWORD, SQL_DATABASE);

$mysqli->set_charset("utf8");

if (!$mysqli) {
    echo "Error: Unable to connect to MySQL.";
    
    exit;
}