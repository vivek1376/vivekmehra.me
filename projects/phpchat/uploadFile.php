<?php
/**
 * Created by PhpStorm.
 * User: vivek
 * Date: 3/10/14
 * Time: 8:13 PM
 */
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/magicquotes.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';

//echo json_encode(array('OK'));

//return;


if (isset($_GET['action']) and $_GET['action'] == 'uploadImg') {

    //return;

    $allowedExts = array("jpeg", "jpg", "png");
    $temp = explode(".", $_FILES['profileImg']['name']);
    $fileExt = end($temp);

    if (!in_array($fileExt, $allowedExts)) {
        $error = 'filename has incorrect extension.';
        include 'error.html.php';
        exit();
    }

    if (preg_match('/^image\/p?jpeg$/i', $_FILES['profileImg']['type']) ||
        preg_match('/^image\/jpe?g$/i', $_FILES['profileImg']['type'])
    )
        $ext = '.jpg';
    elseif (preg_match('/^image\/(x-)?png$/i', $_FILES['profileImg']['type']))
        $ext = '.png';
    else {
        $error = 'Wrong image type.';
        include 'error.html.php';
        exit();
    }

    //check for error
    if ($_FILES['profileImg']['error'] > 0) {
        $error = "Return code: " . $_FILES['profileImg']['error'];
        include 'error.html.php';
        exit();
    }

    $filename = 'uploads/images/' . time() . $_SERVER['REMOTE_ADDR'] . $ext;

    //move the file
    if (move_uploaded_file($_FILES['profileImg']['tmp_name'], $filename))
        echo json_encode(array('OK', $filename));
    else {
        $error = 'not uploaded';
        include 'error.html.php';
        exit();
    }
}