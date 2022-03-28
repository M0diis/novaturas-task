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
    $sql = "DELETE FROM `avlines` WHERE id = ".$id;

    $mysqli->query($sql);
}

if(isset($_POST['update']))
{
    $sql = "UPDATE `avlines` SET country_iso = ".$_POST['country_iso'].", name = '".$_POST['name']."' WHERE id = ".$id;

    $mysqli->query($sql);
}

if(isset($_POST['create']))
{
    $sql = "INSERT INTO avlines (country_iso, name) VALUES (".$_POST['country_iso'].", '".$_POST['name']."')";

    $mysqli->query($sql);
}

echo '<script type="text/javascript"> window.location="/avialinija/avlines.php";</script>';

exit();