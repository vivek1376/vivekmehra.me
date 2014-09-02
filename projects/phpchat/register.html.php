<?php
/**
 * Created by PhpStorm.
 * User: vivek
 * Date: 19/6/14
 * Time: 6:52 PM
 */
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';

session_destroy();
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Register - Enter your details</title>
<link rel="stylesheet" type="text/css" href="cssreset.css" media="screen">
<style type="text/css">
    @font-face {
        font-family: 'misoregular';
        src: url('fonts/miso-webfont.eot');
        src: url('fonts/miso-webfont.eot?#iefix') format('embedded-opentype'), url('fonts/miso-webfont.woff') format('woff'), url('fonts/miso-webfont.ttf') format('truetype'), url('fonts/miso-webfont.svg#misoregular') format('svg');
        font-weight: normal;
        font-style: normal;

    }

    html {
        height: 100%;
    }

    body {
        font-family: sans-serif;
        font-size: 14px;
        height: 100%;
        background-image: url("images/backPattern1.png");
        font-family: misoregular;
    }

    #container {
        width: 350px;
        margin: 0 auto;
        height: 100%;
        width: 640px;
        background-image: url("images/backPattern.png");
        border-left: 1px solid #beb3a7;
        border-right: 1px solid #beb3a7;
    }

    form input {
        display: block;
        border: 1px solid #91aaa9;
        margin: 0 auto;
        box-sizing: border-box;
        height: 32px;
        width: 200px;
        margin-bottom: 8px;
    }
    h1#title{
        text-align: center;
        font-size: 32px;
        color: #786d67;
        padding-top: 20px;
        padding-bottom: 40px;
    }

    /*form label,input{
        display: block;
        border: 1px solid #91aaa9;
        box-sizing: border-box;
        height: 32px;
        width: 200px;
        margin: 0 auto;
    }
    form label{
        position: relative;
        top: 32px;
    }*/
    label {
        display: none;
        color: #afafaf;
        font-style: italic;
        z-index: 10;
        text-align: right;
        padding: 6px;
        background: white;
        font-size: 18px;
    }

    label.pwd, .pwdretype {
        display: block;
        border: 1px solid #91aaa9;
        margin: 0 auto;
        box-sizing: border-box;
        height: 32px;
        width: 200px;
        background-color: white;
    }

    label.pwdretype {
        position: relative;
        top: -32px;
    }

    input {
        color: #5f5f5f;
        font-family: misoregular;
        font-size: 22px;
        padding: 6px;
    }

    input.pwd {
        position: relative;
        top: -32px;
        z-index: 11;
        background-color: transparent;
    }

    input#retypepwd {
        position: relative;
        top: -64px;
        z-index: 11;
        background-color: transparent;
    }

    input#regbutton {
        border: 0;
        background-color: #59cbc7;
        display: block;
        height: 32px;
        width: 200px;
        box-sizing: border-box;
        margin: 0 auto;
        border-bottom: 1px solid #48b3af;
        border-top: 1px solid #59cbc7;
        font-size: 24px;
        padding: 0;
        color: #38817f;
        font-family: misoregular;
    }
    img#captcha_image {
        display: block;
        margin: 0 auto;
        position: relative;
        top: -50px;
    }

    #captcha_code {
        position: relative;
        top: -40px;
    }
</style>
<script src="jquery-1.11.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {

        //alert('dfsdf');
        $('#uname').focus(function () {
            $('#lbluname').css('visibility', 'hidden');
            $(this).css('background-color', 'white');
        });

        $('#fname').val('First Name');
        $('#fname').css('color', '#afafaf');
        $('#fname').css('font-size', '18px');
        $('#fname').css('padding', '6px');
        $('#fname').css('text-align', 'right');
        $('#fname').css('font-style', 'italic');

        $('#lname').val('Last Name');
        $('#lname').css('text-align', 'right');
        $('#lname').css('color', '#afafaf');
        $('#lname').css('font-size', '18px');
        $('#lname').css('padding', '6px');
        $('#lname').css('font-style', 'italic');

        $('#uname').val('Username');
        $('#uname').css('text-align', 'right');
        $('#uname').css('color', '#afafaf');
        $('#uname').css('font-size', '18px');
        $('#uname').css('padding', '6px');
        $('#uname').css('font-style', 'italic');

        $('#captcha_code').val('Enter captcha code');
        $('#captcha_code').css('text-align', 'right');
        $('#captcha_code').css('color', '#afafaf');
        $('#captcha_code').css('font-size', '18px');
        $('#captcha_code').css('padding', '6px');
        $('#captcha_code').css('font-style', 'italic');

        $('#email').val('Enter email');
        $('#email').css('text-align', 'right');
        $('#email').css('color', '#afafaf');
        $('#email').css('font-size', '18px');
        $('#email').css('padding', '6px');
        $('#email').css('font-style', 'italic');

        $('#fname').focus(function () {
            if ($(this).val() == 'First Name') {
                $(this).val('');
                $(this).css('text-align', 'left');
                $(this).css('color', '#5f5f5f');
                $(this).css('font-size', '22px');
                $(this).css('padding', '6px');
                $(this).css('font-style', 'normal');
            }
        });
        $('#fname').blur(function () {
            if ($(this).val() == '') {
                $(this).val('First Name');
                $(this).css('text-align', 'right');
                $(this).css('color', '#afafaf');
                $(this).css('font-size', '18px');
                $(this).css('padding', '6px');
                $(this).css('font-style', 'italic');
            }
        });

        $('#lname').focus(function () {
            if ($(this).val() == 'Last Name') {
                $(this).val('');
                $(this).css('text-align', 'left');
                $(this).css('color', '#5f5f5f');
                $(this).css('font-size', '22px');
                $(this).css('padding', '6px');
                $(this).css('font-style', 'normal');
            }
        });
        $('#lname').blur(function () {
            if ($(this).val() == '') {
                $(this).val('Last Name');
                $(this).css('text-align', 'right');
                $(this).css('color', '#afafaf');
                $(this).css('font-size', '18px');
                $(this).css('padding', '6px');
                $(this).css('font-style', 'italic');
            }
        });

        $('#uname').focus(function () {
            if ($(this).val() == 'Username') {
                $(this).val('');
                $(this).css('text-align', 'left');
                $(this).css('color', '#5f5f5f');
                $(this).css('font-size', '22px');
                $(this).css('padding', '6px');
                $(this).css('font-style', 'normal');
            }
        });
        $('#uname').blur(function () {
            if ($(this).val() == '') {
                $(this).val('Username');
                $(this).css('text-align', 'right');
                $(this).css('color', '#afafaf');
                $(this).css('font-size', '18px');
                $(this).css('padding', '6px');
                $(this).css('font-style', 'italic');
            }
        });

        $('#captcha_code').focus(function () {
            if ($(this).val() == 'Enter captcha code') {
                $(this).val('');
                $(this).css('text-align', 'left');
                $(this).css('color', '#5f5f5f');
                $(this).css('font-size', '22px');
                $(this).css('padding', '6px');
                $(this).css('font-style', 'normal');
            }
        });
        $('#captcha_code').blur(function () {
            if ($(this).val() == '') {
                $(this).val('Enter captcha code');
                $(this).css('text-align', 'right');
                $(this).css('color', '#afafaf');
                $(this).css('font-size', '18px');
                $(this).css('padding', '6px');
                $(this).css('font-style', 'italic');
            }
        });

        $('#email').focus(function () {
            if ($(this).val() == 'Enter email') {
                $(this).val('');
                $(this).css('text-align', 'left');
                $(this).css('color', '#5f5f5f');
                $(this).css('font-size', '22px');
                $(this).css('padding', '6px');
                $(this).css('font-style', 'normal');
            }
        });
        $('#email').blur(function () {
            if ($(this).val() == '') {
                $(this).val('Enter email');
                $(this).css('text-align', 'right');
                $(this).css('color', '#afafaf');
                $(this).css('font-size', '18px');
                $(this).css('padding', '6px');
                $(this).css('font-style', 'italic');
            }
        });
        $('#pwd').focus(function () {
            $(this).css('background-color', 'white');
        });
        $('#pwd').blur(function () {
            if ($('#pwd').val() == '')
                $(this).css('background-color', 'transparent');
        });
        $('#retypepwd').focus(function () {
            $(this).css('background-color', 'white');
        });
        $('#retypepwd').blur(function () {
            if ($('#retypepwd').val() == '') {
                $(this).css('background-color', 'transparent');
            }
        });
    });
</script>
</head>
<body>
<div id="container">
    <h1 id="title">Enter your details</h1>

    <form id="userdetails" action="?" name="regform" method="post">
        <label for="fname">First Name</label> <input name="fname" id="fname" type="text">
        <label for="lname">Last Name</label> <input name="lname" id="lname" type="text">
        <label for="uname">Username</label><input name="uname" type="text" id="uname">
        <label for="email">Email</label><input name="email" type="text" id="email">
        <label class="pwd" for="pwd">Password</label><input name="pwd" class="pwd" type="password" id="pwd">
        <label class="pwdretype" for="retypepwd">Confirm Password</label><input name="retypepwd" type="password"
                                                                                id="retypepwd">
        <img width="200" src="securimage/securimage_show.php" id="captcha_image">
        <input type="text" name="captcha_code" id="captcha_code">
        <input type="hidden" name="registernew">
        <input type="submit" id="regbutton" value="Register">
    </form>
</div>
</body>
</html>