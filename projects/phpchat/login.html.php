<?php
/**
 * Created by PhpStorm.
 * User: vivek
 * Date: 19/5/14
 * Time: 11:47 PM
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Log In</title>
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

        #loginbox {
            /*width: 350px;
            height: 260px;
            margin: 0 auto;
            background-color: #f9f8e7;
            border: 1px solid #eddfca; */
            margin-top: 120px;
        }

        #title {
            display: block;
            padding-top: 20px;
            text-align: center;
            font-size: 20px;
            color: #786d67;
            font-size: 56px;
        }

        #uname {
            box-shadow: none;
            display: block;
            position: relative;
            height: 32px;
            width: 200px;
            margin: 0 auto;
            z-index: 11;
            border: 1px solid #91aaa9;
            box-sizing: border-box;
            background: transparent;
            font-size: 14px;
            padding: 7px;
            color: #5f5f5f;
            font-family: misoregular;
            font-size: 20px;
            padding: 4px;
        }

        #lbluname {
            display: block;
            height: 32px;
            width: 200px;
            border: 1px solid #000000;
            box-sizing: border-box;
            position: relative;
            top: 32px;
            color: #969ba8;
            font-style: italic;
            z-index: 10;
            text-align: right;
            margin: 0 auto;
            text-align: right;
            padding: 6px;
            background: white;
            font-size: 18px;
        }

        #pwd {
            box-shadow: none;
            display: block;
            position: relative;
            height: 32px;
            width: 200px;
            border: 1px solid #91aaa9;
            color: #5f5f5f;
            box-sizing: border-box;
            margin: 0 auto;
            top: -33px;
            z-index: 11;
            background: transparent;
            font-family: misoregular;
            font-size: 18px;
            padding: 6px;
        }

        #lblpwd {
            display: block;
            height: 32px;
            width: 200px;
            color: #afafaf;
            border: 1px solid #000000;
            box-sizing: border-box;
            position: relative;
            top: -1px;
            text-align: right;
            font-style: italic;
            margin: 0 auto;
            z-index: 10;
            padding: 6px;
            background: white;
            font-size: 18px;
        }

        #button {
            border: 0;
            background-color: #59cbc7;
            display: block;
            height: 32px;
            width: 200px;
            box-sizing: border-box;
            margin: 0 auto;
            border-bottom: 1px solid #48b3af;
            border-top: 1px solid #59cbc7;
            font-size: 16px;
            color: #38817f;
            font-family: misoregular;
            font-size: 24px;

        }

        #loginbanner {
            text-align: center;
            font-size: 32px;
            color: #786d67;;
        }

        p#signup {
            margin-top: 60px;
            text-align: center;
            font-size: 22px;
            color: #a79c93;

        }

        p#signup a:link, a:visited, a:active {
            text-decoration: none;
            color: #777b86;
        }
    </style>
    <script type="text/javascript" src="jquery-1.11.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            //alert('dfsdf');
            $('#uname').focus(function () {
                $('#lbluname').css('visibility', 'hidden');
                $(this).css('background-color', 'white');
            });
            $('#uname').blur(function () {
                if ($('#uname').val() == '') {
                    $('#lbluname').css('visibility', 'visible');
                    $(this).css('background-color', 'transparent');
                }
            });

            $('#pwd').focus(function () {
                $('#lblpwd').css('visibility', 'hidden');
                $(this).css('background-color', 'white');
            });

            $('#pwd').blur(function () {
                if ($('#pwd').val() == '') {
                    $('#lblpwd').css('visibility', 'visible');
                    $(this).css('background-color', 'transparent');
                }
            });
        });
    </script>
</head>
<body>

<div id="container">
    <h1 id="title">A Simple Online Chat</h1>

    <div id="loginbox">

        <p id="loginbanner">Sign In to Chat</p>
        <?php if (isset($loginError)): ?>
            <p><?php htmlout($loginError); ?></p>
        <?php endif; ?>

        <form action="" method="post">
            <div>
                <label id="lbluname" for="username">Username</label>
                <input id="uname" type="text" name="username" id="username">
            </div>
            <div>
                <label id="lblpwd" for="password">Password</label>
                <input id="pwd" type="password" name="password" id="password">
            </div>
            <div>
                <input type="hidden" name="action" value="login">
                <input id='button' type="submit" value="SIGN IN">
            </div>
        </form>
        <p id="signup">Are you a new user?&nbsp;<a href="?registerform">Signup</a></p>
    </div>
</div>

</body>
</html>

