<?php
/**
 * Created by PhpStorm.
 * User: vivek
 * Date: 11/10/14
 * Time: 6:32 PM
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="cssreset.css" media="screen">
    </head>
<body>
<h1>Modify settings</h1>
<!--upload image-->
<form id='uploadImg' action="uploadFile.php" method="post" enctype="multipart/form-data">
    <div><label for="profileImg">Select file</label></div>
    <div><input type="file" id="profileImg" name="profileImg"></div>
    <input type="hidden" name="action" value="uploadImg">
    <input type="hidden" name="MAX_FILE_SIZE" value="204800">
    <input type="submit" value="Submit">
</form>
</body>