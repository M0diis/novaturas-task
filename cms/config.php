<?php
// Path: cms\system\connection.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define database connection constants
define("SQL_HOST", "localhost");
define("SQL_USER", "root");
define("SQL_PASSWORD", "");
define("SQL_DATABASE", "avialinija");

// Other constants
// define("SITE_URL", "//domain-name/avialinija");

/**
 * Used to store website configuration information.
 *
 * @var string or null
 */
function config($key = '')
{
    $config = [
        'name' => 'Avialinija'
    ];

    return isset($config[$key]) ? $config[$key] : null;
}