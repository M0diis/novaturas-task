<?php
// Path: airport_handler.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include(__DIR__."/cms/theme/layout_header.php");
include(__DIR__."/cms/theme/navigation.php");

if(empty($_POST))
{
    echo '<script type="text/javascript"> window.location="/avialinija/airports.php";</script>';

    exit();
}

$id = -1;

if(isset($_POST['id']))
{
    $id = $_POST['id'];
}

if($id == -1)
{
    echo '<script type="text/javascript"> window.location="/avialinija/airports.php";</script>';

    exit();
}

if(isset($_POST['delete']))
{
    $sql = "DELETE FROM airports WHERE id = ".$id;

    $mysqli->query($sql);
}

if(isset($_POST['update']))
{
    $sql = "UPDATE airports SET country_iso = ".$_POST['country_iso'].", location = POINT(".$_POST['lat'].",".$_POST['lng'].") WHERE id = ".$id;

    $mysqli->query($sql);
}

if(isset($_POST['create']))
{
    $sql = "INSERT INTO airports (country_iso, location) VALUES (".$_POST['country_iso'].", POINT(".$_POST['lat'].", ".$_POST['lng']."))";

    $mysqli->query($sql);
}

if(isset($_POST['add_avline']))
{
    $sql = "INSERT INTO airports_avlines(airport_id, avline_id) VALUES (".$id.", ".$_POST['avline_id'].")";

    $mysqli->query($sql);
}

if(isset($_POST['remove_avline']))
{
    $sql = "DELETE FROM airports_avlines WHERE avline_id = ".$_POST['avline_id'] . " AND airport_id = ".$id;

    $mysqli->query($sql);
}

echo '<script type="text/javascript"> window.location="/avialinija/airports.php";</script>';

exit();