<?php
// Path: cms/system/functions.php

include(__DIR__."/connection.php");

/*
 * Function to get all airports.
 * 
 * @param mysqli $mysqli
 * @param int $id - airport id
 * @param int $limit - limit of results
 * 
 * @return array of airports.
 */
function getAirports($mysqli, $join = false, $limit = -1)
{    
    $query;

    if($join) {
        $query = "SELECT `airports`.`id`, X(`airports`.`location`) AS lat, Y(`airports`.`location`) AS lng, 
                    `countries`.`iso` AS country_iso, `countries`.`name` AS country_name 
                  FROM `airports` 
                  LEFT JOIN `countries` 
                    ON `airports`.`country_iso` = `countries`.`iso`";
    }
    else {
        $query =  "SELECT `airports`.`id`, X(`airports`.`location`) AS lat, Y(`airports`.`location`) AS lng, country_iso FROM `airports`";
    }

    if($limit != -1) {
        $query .= " LIMIT $limit";
    }
    
    $result = $mysqli->query($query);

    if (!$result) {
        echo "Error: " . $mysqli->error;
        exit;
    }

    return getArray($result);
}

/*
 * Returns a single airport.
 * 
 * @param mysqli $mysqli
 * @param int $id - airport id
 * @param bool $join - if true, joins countries table
 * 
 * @return result object
 */
function getAirport($mysqli, $id, $join = false)
{
    $query;

    if($join) {
        $query = "SELECT `airports`.`id`, X(`airports`.`location`) AS lat, Y(`airports`.`location`) AS lng, 
                    `countries`.`iso` AS country_iso, `countries`.`name` AS country_name 
                  FROM `airports` 
                  LEFT JOIN `countries` 
                    ON `airports`.`country_iso` = `countries`.`iso`
                  WHERE `airports`.`id` = $id";
    }
    else {
        $query =  "SELECT `airports`.`id`, X(`airports`.`location`) AS lat, Y(`airports`.`location`) AS lng, country_iso FROM `airports` WHERE `airports`.`id` = $id";
    }

    $result = $mysqli->query($query);

    if (!$result) {
        echo "Error: " . $mysqli->error;
        exit;
    }

    return $result->fetch_assoc();
}

/*
 * Returns an array of avialines
 * 
 * @param mysqli $mysqli
 * @param int $airport_id - airport id
 * @param bool $join - if true, joins with countries and airport table
 */
function getAvialines($mysqli, $airport_id = -1, $join = false)
{
    $query;

    if($join) {
        $query = "SELECT `avlines`.`name` AS avline_name, `avlines`.`id` AS avline_id, `countries`.`name` AS country_name, `countries`.`iso` AS country_iso
              FROM `airports_avlines` 
              LEFT JOIN `avlines` 
                ON `airports_avlines`.`avline_id` = `avlines`.`id`
              LEFT JOIN `countries`
                ON `avlines`.`country_iso` = `countries`.`iso`
              WHERE `airports_avlines`.`airport_id` = $airport_id";
    }
    else {
        $query =  "SELECT * FROM `avlines`";
    }

    $result = $mysqli->query($query);

    if (!$result) {
        echo "Error: " . $mysqli->error;
        exit;
    }

    return getArray($result);
}

function getAvline($mysqli, $id)
{
    $query = "SELECT * FROM `avlines` WHERE `id` = $id";

    $result = $mysqli->query($query);

    if (!$result) {
        echo "Error: " . $mysqli->error;
        exit;
    }

    return $result->fetch_assoc();
}

function getAvlines($mysqli, $join = false)
{
    $query;

    if($join) {
        $query = "SELECT `avlines`.`name` AS avline_name, `avlines`.`id` AS avline_id, `avlines`.`country_iso`, `countries`.`name` AS country_name
              FROM `avlines`
              LEFT JOIN `countries`
                ON `avlines`.`country_iso` = `countries`.`iso`";
    }
    else {
        $query =  "SELECT * FROM `avlines`";
    }

    $result = $mysqli->query($query);

    if (!$result) {
        echo "Error: " . $mysqli->error;
        exit;
    }

    return getArray($result);
}

/* 
 * Returns an array of countries
 * 
 * @param mysqli $mysqli
 * @param int $limit - limit of results
 * 
 * @return array of countries
 */
function getCountries($mysqli, $limit = -1)
{
    $query = "SELECT `iso`, `name` FROM `countries`";

    if($limit != -1) {
        $query .= " LIMIT $limit";
    }

    $result = $mysqli->query($query);

    if (!$result) {
        echo "Error: " . $mysqli->error;
        exit;
    }

    return getArray($result);
}

/* 
 * Returns a single country.
 * 
 * @param mysqli $mysqli
 * @param int $iso - country iso
 * 
 * @return result object
 */
function getCountry($mysqli, $iso)
{
    $query = "SELECT `iso`, `name` FROM `countries` WHERE `iso` = '$iso'";

    $result = $mysqli->query($query);

    if (!$result) {
        echo "Error: " . $mysqli->error;
        exit;
    }

    return $result->fetch_assoc();
}

function getCountriesWithoutAvialines($mysqli)
{
    $query = "SELECT `countries`.*, count(`avlines`.`id`) AS avline_count        
            FROM countries
            LEFT JOIN avlines
                ON (`countries`.`iso` = `avlines`.`country_iso`)
            GROUP BY `countries`.`iso`";

    $result = $mysqli->query($query);

    if (!$result) {
        echo "Error: " . $mysqli->error;
        exit;
    }

    $countries = Array();

    while($row = $result->fetch_assoc()) {
        if($row['avline_count'] == 0) {
            $countries[] = $row;
        }
    }

    return $countries;
}

/* 
 * Returns an array of specified mysqli result.
 * 
 * @param mysqli $mysqli
 * 
 * @return array of results
 */
function getArray($result)
{
    $array = Array();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $array[] = $row;
        }
    }
    
    return $array;
}