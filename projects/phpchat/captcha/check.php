<?php
/**
 * Created by PhpStorm.
 * User: vivek
 * Date: 22/6/14
 * Time: 4:59 PM
 */
session_start();
include_once 'securimage/securimage.php';
$securimage = new Securimage();

if ($securimage->check($_POST['captcha_code']) == false) {
    // the code was incorrect
    // you should handle the error so that the form processor doesn't continue

    // or you can use the following code if there is no validation or you do not know how
    echo "The security code entered was incorrect.<br /><br />";
    echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
    exit;
}
echo 'success';