<?php
/**
 * Created by PhpStorm.
 * User: vivek
 * Date: 3/5/14
 * Time: 8:43 PM
 */

try {
    $pdo = new PDO('mysql:host=fdb6.awardspace.net;port=3306;dbname=1719324_viv', '1719324_viv', 'vivmSqlDB0');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('SET NAMES "utf8"');
} catch (PDOException $e) {
    $error = 'unable to connect to database server: ' . $e->getMessage();
    include 'error.html.php';
    exit();
}
