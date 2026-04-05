<?php

use LabForce\DotEnv;

require 'includes/dotenv.php';

(new DotEnv(__DIR__ . '/.env'))->load();

include_once("connect/fix_mysql.inc.php");

// this will avoid mysql_connect() deprecation error.
error_reporting(~E_DEPRECATED & ~E_NOTICE);
// but I strongly suggest you to use PDO or MySQLi.

define('DBHOST', getenv('DB_HOST'));
define('DBUSER', getenv('DB_USER'));
define('DBNAME', getenv('DB_NAME'));
define('DBPASS', getenv('DB_PASSWORD'));


$conn = mysql_connect(DBHOST, DBUSER, DBPASS);
$dbcon = mysql_select_db(DBNAME);

if (!$conn) {
    die("Connection failed : " . mysql_error());
}

if (!$dbcon) {
    die("Database Connection failed : " . mysql_error());
}

ini_set('max_execution_time', 1800);
