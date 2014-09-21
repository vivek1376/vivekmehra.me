<?php
/**
 * Created by PhpStorm.
 * User: vivek
 * Date: 24/5/14
 * Time: 5:35 PM
 */
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport"
      content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>Chat</title>
<script type="text/javascript">
    /*function write() {
     document.getElementById("displaymsg").innerHTML += 'hahuuu<br>';
     }*/
</script>
<script type="text/javascript" src="jquery-1.11.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var latestMsgID = '';

        //ajax code
        function fetchMsg() {
            var t;

            $.ajax({
                url: 'chat.php',
                type: 'POST',
                data: 'latestMsgID=' + latestMsgID
                    + '&senderid=' + <?php echo($_SESSION['userid']); ?> +'&receiverid=' + <?php echo $friendid; ?>,
                dataType: 'json',
                success: function (msgs) {
                    clearInterval(t);

                    // send another request after approx 1 sec
                    t = setTimeout(function () {
                        fetchMsg();
                    }, 1100);

                    if (latestMsgID == '')
                        latestMsgID = msgs[0].id;
                    else {
                        if (msgs[0]) {//without it working but showed some error in console log
                            //console.log('heyyyyy');
                            var msgtype = '';
                            for (var i in msgs) {
                                if (msgs[i].sid ==<?php echo $_SESSION['userid']; ?>) {
                                    document.getElementById("displaymsg").innerHTML += (
                                        '<div class="msgbox sent"><p class="msgbody">'
                                            + msgs[i].bd
                                            + '</p><div class="arrowRight"></div></div>'
                                        );
                                }
                                else {
                                    if (msgs[i].sid ==<?php echo $friendid; ?>) {
                                        document.getElementById("displaymsg").innerHTML += (
                                            '<div class="msgbox received"><div class="arrowLeft"></div>'
                                                + '<p class="msgbody">'
                                                + msgs[i].bd
                                                + '</p></div>'
                                            );
                                    }
                                }

                                //document.getElementById("displaymsg").innerHTML += ('<p class="message"> ' + httpReqMsg.responseText + '</p>');
                            }
                            latestMsgID = msgs[i].id;

                            var objDiv = document.getElementById("displaymsg");
                            objDiv.scrollTop = objDiv.scrollHeight;
                        }
                    }
                },

                timeout: 40000,

                error: function () {
                    clearInterval(t);
                    t = setTimeout(function () {
                        fetchMsg();
                    }, 5000);
                }
            });
        }

        fetchMsg();

        var chatMsg = '';


        $("#entermsg").keydown(function (event) {
            if (event.keyCode == 13) {
                $("#msgform").submit();
            }
        });


        $("#msgform").submit(function () {
            chatMsg = $('#entermsg').val();
            $('#entermsg').val('');
            sendMessage();
            //alert(chatMsg);
            return false;
        });

        function sendMessage() {
            $.ajax({
                url: 'chat.php',
                type: 'POST',
                data: 'msg=' + chatMsg
                    + '&senderid=' + <?php echo($_SESSION['userid']); ?> +'&receiverid=' + <?php echo $friendid; ?>,
                dataType: 'json',
                success: function (returnVal) {
                    //alert('done');
                    //fetchMsg();//d
                }
            });
        }
    });
</script>

<link rel="stylesheet" type="text/css" href="cssreset.css" media="screen">
<!--<link rel="stylesheet" type="text/css" href="nanoscroller.css" media="screen">-->

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

#header {
    background-color: #424242;
    padding: 6px;
    font-size: 18px;
    color: white;
}

#chatbox {
    width: 350px;
    margin: 0 auto;
}

div#displaymsg {

    height: 340px;
    border: 2px solid #eecfbd;
    overflow: auto;
    overflow-x: hidden;
}

textarea#entermsg {
    border: 2px solid #eecfbd;
    border-right: 0;
    resize: none;
    width: 305px;
    height: 40px;
    float: left;
    margin-top: 2px;
    background-color: rgba(255, 255, 255, 0.6);
    padding: 2px;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
}

form#msgform {
    display: block;
    padding: 0;
    overflow: auto; /* to prevent height collapse */
}

/*
form #msg {
    /*display: block;
    border: 0;
    padding: 0;
    margin: 0;
    background-color: #ac6d50;
    border-top: 1px solid #9c604c;
    border-bottom: 1px solid #ba7952;
    box-sizing: border-box;
    height: 42px;
    width: 254px;
    resize: none;
    float: left;
    padding: 6px;
    overflow: hidden;

} */

form #submitbutton {
    display: block;
    padding: 0;
    height: 40px;
    width: 45px;
    right: 0;
    border: 0;
    background-color: #40c6d9;
    color: white;
    float: left;
    margin-top: 2px;
    background-image: url("images/sendButton.png");
}

p.msgbody {
    display: inline-block;
    margin: 0;
    padding: 4px;
    color: white;
    background-color: #6fbfcc;
    font-family: helvetica, arial, sans-serif;
    font-size: 12px;
    /*border: 1px solid #6dbcc9;*/
    border-top: 1px solid #76cbd9;
    border-bottom: 1px solid #6ab8c4;
    border-radius: 2px;
    -moz-border-radius: 2px;
    -webkit-border-radius: 2px;
    max-width: 210px;

}

div.msgbox {
    margin: 4px 0;
    /* max-width: 250px;*/
}

div.sent {
    float: right;
    clear: both;
    /*border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    -moz-border-radius-topright: 0;
    -moz-border-radius-bottomright: 0;
    -webkit-border-top-right-radius: 0;
    -webkit-border-bottom-right-radius: 0;  */
}

div.arrowRight {
    display: inline-block;
    width: 6px;
    height: 16px;
    background-image: url("images/raa.png");
    margin: 0;
}

div.received {
    float: left;
    clear: both;
}

div.arrowLeft {
    display: inline-block;
    width: 6px;
    height: 16px;
    background-image: url("images/arrowleft.png");
    margin: 0;
}

p#footer {
    text-align: center;
    bottom: 0;
    border: 0;
    color: #a8a391;
    font-size: 12px;
    margin-top: 50px;
}

form #msg:hover {
    background-color: #c48370;
}

form #msg:focus {
    background-color: #dba9a3;
    border-top: 1px solid #d3a19b;
    border-bottom: 1px solid #e6b3ad;
}

div#navbar {
    font-family: misoregular;
    height: 30px;
    background-color: #363636;
}

div#navbar form {
    float: right;

}

div#navbar input[type='submit'] {
    border: none;
    background-color: #692328;
    color: #ffd3cd;
    height: 30px;
    width: 90px;
    font-family: misoregular;
    font-size: 18px;
}

div#navbar input[type='submit']:hover {
    background-color: #8e2f36;
}

div#navbar p {
    color: white;
    height: 30px;
    font-size: 22px;
    padding: 4px;
    float: left;
    text-transform: capitalize;
}

div#navbar span.uname {
    font-weight: bold;
}
</style>
<!--<link rel="stylesheet" href="mobile.css" media="handheld">
<link rel="stylesheet" href="mobile.css" media="only screen and (max-width: 720px)">-->

</head>
<body>


<div id="container">
    <div id="navbar">
        <p>Hi <span class="uname"> <?php htmlout($_SESSION['username']); ?></span>&nbsp;&excl;</p>
        <?php include 'logout.inc.html.php'; ?>
    </div>

    <div id="chatbox">
        <p>Chat with <?php htmlout($friendName); ?></p>

        <div id="displaymsg">
        </div>

        <form name="writemsg" id="msgform" method="post">
            <textarea name="msg" id="entermsg"></textarea>
            <input type="hidden" name="senderid" value="<?php htmlout($_SESSION['userid']); ?>">
            <input type="hidden" name="receiverid" value="<?php htmlout($friendid); ?>">
            <input type="submit" id="submitbutton" value="">
        </form>
    </div>
    <p id="footer">Designed by Vivek</p>
</div>


<!--<script type="text/javascript">

    (function () {
        var latestMsgTimestamp = '';
        var latestMsgID = '';
        var lastMsgTime = '2014-05-27 01:21:47';
        var httpRequest;
        var httpReq;
        var httpReqMsg;
        var refreshIntervalID;

        var refreshMsg = function () {
            if (window.XMLHttpRequest) { // Mozilla, Safari, ...
                httpReqMsg = new XMLHttpRequest();
            } else if (window.ActiveXObject) { // IE
                try {
                    httpReqMsg = new ActiveXObject("Msxml2.XMLHTTP");
                }
                catch (e) {
                    try {
                        httpReqMsg = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    catch (e) {
                    }
                }
            }

            if (!httpReqMsg) {
                //alert('error!');
                return false;
            }
            httpReqMsg.onreadystatechange = fetchMsg;
            httpReqMsg.open('POST', 'chat.php');
            httpReqMsg.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            httpReqMsg.send('latestMsgID=' + encodeURIComponent(latestMsgID)
                + '&senderid=' + <?php echo($_SESSION['userid']); ?> +'&receiverid=' + <?php echo $friendid; ?>);
        }

        function fetchMsg() {
            if (httpReqMsg.readyState === 4) {
                if (httpReqMsg.status === 200) {
                    //document.getElementById("displaymsg").innerHTML += ('<p class="message"> ' + httpReqMsg.responseText + '</p>');
                    var msgs = JSON.parse(httpReqMsg.responseText);

                    //check if last message id is null
                    if (latestMsgID == '')
                        latestMsgID = msgs[0].id;
                    else {
                        if (msgs[0]) {//without it working but showed some error in console log
                            //console.log('heyyyyy');
                            for (var i in msgs) {
                                if (msgs[i].sid ==<?php echo $_SESSION['userid']; ?>)
                                    var msgtype = 'sender';
                                else if (msgs[i].sid ==<?php echo $friendid; ?>)
                                    var msgtype = 'receiver';
                                document.getElementById("displaymsg").innerHTML += (
                                    '<p class="message'
                                        + ' '
                                        + msgtype + '">'
                                        + msgs[i].bd
                                        + '</p>'
                                    );
                                //document.getElementById("displaymsg").innerHTML += ('<p class="message"> ' + httpReqMsg.responseText + '</p>');
                            }
                            latestMsgID = msgs[i].id;

                            var objDiv = document.getElementById("displaymsg");
                            objDiv.scrollTop = objDiv.scrollHeight;
                            //$(".nano").nanoScroller();
                            //setTimeout(refreshMsg,1200);   not wrking here why??
                        }

                    }
                    refreshIntervalID = setTimeout(refreshMsg, 1200);

                } else {
                    //alert('There was a problem with the request.');
                }
            }

        }

        refreshMsg();

        //refreshIntervalID = setInterval(refreshMsg, 1000);

        //submit message on clicking send button
        document.getElementById("msgform").onsubmit = function () {
            var msg = document.getElementById('msg').value;
            document.getElementById('msg').value = '';
            makeRequest('chat.php', msg);
            return false;
        }

        function makeRequest(url, msg) {
            //if (latestMsgID == '') {
            //  refreshMsg();
            //}

            if (window.XMLHttpRequest) { // Mozilla, Safari, ...
                httpRequest = new XMLHttpRequest();
            } else if (window.ActiveXObject) { // IE
                try {
                    httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
                }
                catch (e) {
                    try {
                        httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    catch (e) {
                    }
                }
            }

            if (!httpRequest) {
                //alert('Giving up :( Cannot create an XMLHTTP instance');
                return false;
            }
            httpRequest.onreadystatechange = alertContents;
            httpRequest.open('POST', url);
            httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            httpRequest.send('msg=' + encodeURIComponent(msg)
                + '&senderid=' + <?php echo($_SESSION['userid']); ?> +'&receiverid=' + <?php echo $friendid; ?>);
        }

        function alertContents() {
            if (httpRequest.readyState === 4) {
                if (httpRequest.status === 200) {
                    var response = httpRequest.responseText;

                    clearTimeout(refreshIntervalID);
                    refreshMsg();
                    refreshIntervalID = setTimeout(refreshMsg, 1200);

                } else {
                    //alert('There was a problem with the request.');
                }
            }
        }

        refreshMsg();
    })();
</script>-->
<!--<script type="text/javascript" src="jquery-1.11.1.min.js"></script>-->
<!--<script type="text/javascript" src="nanoScroller.js"></script>-->
<script type="text/javascript">
    //$(".nano").nanoScroller({ alwaysVisible: true });
    //$(".nano").nanoScroller();

</script>
</body>
</html>