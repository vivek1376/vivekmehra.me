<?php
/**
 * Created by PhpStorm.
 * User: vivek
 * Date: 11/6/14
 * Time: 1:29 PM
 */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>AJAX demo</title>
    <script type="text/javascript" src="jquery-1.11.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            /*$("p").mouseenter(function () {
             $(this).css({"background-color": "#cccccc", "font-size": "40px"});
             $("#ajax").load("test.html");
             });
             $("p").mouseleave(function () {
             $(this).css("background-color", "red");
             $(this).html('hellloo');
             });*/
            /*
             $("#but").click(function () {
             $.ajax({
             // the URL for the request
             url: "test.html",
             // the data to send (will be converted to a query string)

             // whether this is a POST or GET request
             type: "GET",
             // the type of data we expect back
             //dataType: "json",
             // code to run if the request succeeds;
             // the response is passed to the function
             success: function (returnVal) {
             $("#ajaxval").html(returnVal);
             //$("<h1/>").text(json.title).appendTo("body");
             //$("<div class=\"content\"/>").html(json.html).appendTo("body");
             }
             // code to run if the request fails; the raw request and
             // status codes are passed to the function
             });
             });*/

            var latestMsgID = '';

            //ajax code
            function fetchMsg() {
                var t;

                $.ajax({
                    url: 'chat2.php',
                    type: 'POST',
                    data: 'latestMsgID=' + latestMsgID,
                    dataType: 'json',
                    success: function (msgs) {
                        clearInterval(t);

                        t = setTimeout(function () {
                            fetchMsg();
                        }, 1100);

                        if (latestMsgID == '')
                            latestMsgID = msgs[0].id;
                        else {
                            if (msgs[0]) {//without it working but showed some error in console log
                                //console.log('heyyyyy');
                                for (var i in msgs) {
                                    document.getElementById("displaymsg").innerHTML += (
                                        '<p class="message">'
                                            + msgs[i].bd
                                            + '</p>'
                                        );
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
        });


    </script>
    <style type="text/css">
        body {
            background-color: #f8f2e9;
        }

        div#displaymsg {
            height: 300px;
            padding-top: 10px;
            width: 250px;
            margin: 0 auto;
            border: 2px solid #eecfbd;
        / / overflow : auto;
        / / overflow-x : hidden;

        /
        /
        background-color: #432818

        ;
        /
        /
        border:

        1
        px solid bl

        /
        /
        margin-top :

        20
        px

        ;
        }

        p.message {
            width: 65%;
            margin: 8px 0;
            padding: 4px;
            color: white;
            background-color: #6fbfcc;
            font-family: helvetica, arial, sans-serif;
            font-size: 12px;
            border: 1px solid #6dbcc9;
            border-top-color: #76cbd9;
            border-bottom-color: #6ab8c4;
            border-radius: 2px;
            -moz-border-radius: 2px;
            -webkit-border-radius: 2px;
        }

        textarea {
            border: 1px solid #c1a899;
            border-radius: 0;
            -moz-border-radius: 0;
            -webkit-border-radius: 0;
            width: 200px;
            background: #f4eee6;
            display: block;
            margin: 0 auto;
            margin-top: 4px;
            resize: none;
            position: relative;
            left: -25px;
        }

        #but {
            border-radius: 0;
            -moz-border-radius: 0;
            -webkit-border-radius: 0;
            border: 0;
            background-color: #41256c;
        }
    </style>
</head>
<body>
<p id="para">hey</p>

<div id="displaymsg" class="nano-content"></div>
<textarea id="msgbox"></textarea>
<input type="button" id="but" value="click">

</body>
</html>
