<?php
/**
 * Created by PhpStorm.
 * User: vivek
 * Date: 7/6/14
 * Time: 6:44 PM
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
<meta charset="utf-8">
<title>Dashboard</title>
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

    h1 {
        font-size: 32px;
        text-align: center;
        padding-top: 50px;
    }

    table {
        margin: 0 auto;
        font-size: 20px;
    }

    table tr.top {
        border: 0;
        visibility: hidden;
    }

    table tr {
        height: 24px;
        border-bottom: 1px solid #535b5d;
    }

    table td {
        padding: 6px;
    }

    table tr.name {
        width: 150px;
    }

    table th.name {
        width: 150px;
    }

    table td.status {
        width: 80px;
    }

    table input[type='submit'] {
        border: 0;
        background-color: #59cbc7;
        height: 22px;
        width: 46px;
        box-sizing: border-box;
        margin: 0;
        border-bottom: 1px solid #48b3af;
        border-top: 1px solid #59cbc7;
        font-size: 16px;
        color: #6bfbf8;
        font-family: misoregular;
    }

    input#friendname {
        box-shadow: none;
        height: 26px;
        margin: 0 auto;
        z-index: 11;
        border: 1px solid #91aaa9;
        box-sizing: border-box;
        font-size: 14px;
        padding: 7px;
        color: #5f5f5f;
        font-family: misoregular;
        font-size: 18px;
        padding: 1px;
        margin: 0;
    }

    input#searchfriend {
        border: 0;
        background-color: #59cbc7;
        height: 26px;
        width: 56px;
        box-sizing: border-box;
        margin: 0;
        border-bottom: 1px solid #48b3af;
        border-top: 1px solid #59cbc7;
        font-size: 16px;
        color: #6bfbf8;
        font-family: misoregular;
        margin: 0;
    }

    label#entername {
        display: none;
    }

    form#findfriend {
        width: 217px;
        margin: 0 auto;
    }

    table#searchedfriends tr#top {
        visibility: hidden;
        border: 0;
    }

    table#searchedfriends input[type='submit'] {
        width: 80px;
    }

    div#navbar {
        height: 30px;
        background-color: #363636;
    }

    span#fListMenu {
        display: inline-block;
        width: 30px;
        height: 30px;
        float: right;
        background-color: #ffd3c2;
    }
    a#settings{
        display: inline-block;
        width: 30px;
        height: 30px;
        float: right;
        background-color: #ffd3c2;
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

    p.noresult {
        text-align: center;
        font-size: 18px;
        margin: 20px;
    }

    img#profileImage {
        width: 200px;
        height: 200px;
    }

    div#friendList {
        color: white;
        background-color: #2b3338;
        width: 200px;
        position: absolute;
        top: 30px;
        font-size: 6px;
    }

    div#friendList{
        display: none;
    }

    span#fListMenu:hover div#friendList{
        display: block;
    }

</style>
<script type="text/javascript" src="jquery-1.11.1.min.js"></script>

<?php
//create a unique string
$frStr = implode("_", array_map(function ($entry) {
    return $entry['id'] . '.' . $entry['online'];
}, $chatFriends));

$frHash = sha1($frStr);
?>

<script type="text/javascript">
    $(document).ready(function () {
//            document.getElementById('json').innerHTML += (' OK'); //d

        var frHashStr = '<?php echo $frHash; ?>';

        // send current friend list as an ajax request
        function fetchFrList() {
            var t;

            $.ajax({
                url: 'friendList.php',
                type: 'POST',
                data: 'frHash=' + frHashStr
                    + '&uid=' + <?php echo($_SESSION['userid']); ?>,
                dataType: 'json',
                success: function (msgs) {
                    //xmlDoc= $.parseXML(msgs),
                    //  $xml=$( xmlDoc ),
                    // $table=$xml.find("text");

                    //document.getElementById('json').innerHTML += (' OK');
                    clearInterval(t);

                    // send another request after approx 40 sec
                    t = setTimeout(function () {
                        fetchFrList();
                    }, 2500);

                    //document.getElementById('json').innerHTML += msgs;//$table.text();
                    //var mm=JSON.parse(msgs);
                    //var mgs=JSON.parse(msgs);

                    // think!! in response data special characters are escaped
                    if (msgs[0] == 'OK') {
                        //alert('hey');
                        //document.getElementById('json').innerHTML += msgs[0];
                        //document.getElementById('json').innerHTML += ('<br>'+msgs[1]);//d
                    }
                    else {
                        document.getElementById('frList').innerHTML = msgs[0];
                        //document.getElementById('json').innerHTML += ('<br>'+msgs[1]);//d
                        frHashStr = msgs[1];
                    }


                    //document.getElementById('json2').innerHTML = JSON.parse(msgs);//'sdsfsdfsd';
                    //document.getElementById('json2').innerHTML = JSON.stringify(msgs);
                },
                timeout: 42000,
                error: function () {
                    clearInterval(t);
                    t = setTimeout(function () {
                        fetchFrList();
                    }, 6000);
                }
            });
        }

        fetchFrList();

        var upFiles;

        //add events
        $('input[type=file]').on('change', prepareUpload);

        function prepareUpload(event) {
            upFiles = event.target.files;
            console.log(upFiles[0]);//d
            //alert('erwerew');
            document.getElementById('json2').innerHTML = JSON.stringify(upFiles);
        }


        $('form#uploadImg').on('submit', uploadFiles);

        // catch the form event and upload the files
        function uploadFiles(event) {
            // stop default behaviour when submit is clicked
            event.stopPropagation();
            event.preventDefault();
            //event.defaultp

            //show loading icon or something...

            //create a formdata object and add the files
            var upData = new FormData();

            upData.append("profileImg", upFiles[0]);//d    correct??

            /*
            $.each(upFiles, function (key, value) {
                console.log(key);//d
                upData.append("profileImg", value); // not proper
                //upData.append(key,value);
            });*/

            //alert('herer');

            $.ajax({
                url: 'uploadFile.php?action=uploadImg',
                type: 'POST',
                data: upData,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function (data, textStatus, jqXHR) {
                    if (typeof data.error === 'undefined') {
                        //success
                        alert('DOne');
                        //load image
                        //document.getElementById('json2').innerHTML=data[1];//JSON.stringify(upFiles);//d

                        //display image
                        $("img#profileImage").attr("src", data[1]);
                    }
                    else
                        console.log('ERRORS 1: ' + data.error);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log('ERRORS 2: ' + textStatus);
                }
            });
        }
    });
</script>
</head>
<body>
<div id="container">
    <!--the top navbar-->
    <div id="navbar">
        <p>Hi <span class="uname"> <?php htmlout($_SESSION['username']); ?></span>&nbsp;&excl;</p>
        <?php include 'logout.inc.html.php'; ?>
        <a id="settings" href="userSettings.html.php">

        </a>
        <span id="fListMenu">
            <div id="friendList">
                <?php if (isset($chatFriends) and !empty($chatFriends)): ?>
                    <h1>Your Friends</h1>
                    <table id="frList">
                        <tr class="top">
                            <th class="name">Name</th>
                            <th>status</th>
                            <th>click to chat</th>
                        </tr>
                        <?php foreach ($chatFriends as $friend): ?>
                            <tr>
                                <td class="name <?php htmlout($friend['id']) ?>"><?php htmlout($friend['first_name']); ?></td>
                                <td class="status <?php htmlout($friend['id']) ?>">
                                    <?php if ($friend['online'] == 1): ?>
                                        online
                                    <?php else: ?>
                                        offline
                                    <?php endif ?>
                                </td>
                                <td class="chat <?php htmlout($friend['id']) ?>">
                                    <?php if ($friend['online'] == 1): ?>
                                        <form action="" method="post">
                                            <input type="hidden" name="chatFriend" value="<?php htmlout($friend['id']) ?>">
                                            <input type="submit" value="Chat">
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <p>No Friends :(</p>
                <?php
                endif; ?>
            </div>
        </span>
    </div>

    <!-- print friends array in json format-->
    <?php
    //echo $frStr;
    //echo '<br>' . $frHash;
    ?>



    <!--show friend requests -->
    <?php if (isset($friendRequests) and !empty($friendRequests)): ?>
        <h1>Your Friend Requests</h1>
        <table>
            <tr>
                <th>Name</th>
                <th>Action</th>
            </tr>
            <?php foreach ($friendRequests as $friendRequest): ?>
                <tr>
                    <td><?php htmlout($friendRequest['first_name']); ?></td>
                    <td>
                        <form action="" method="post">
                            <div>
                                <input type="hidden" name="approveRequest">
                                <input type="hidden" name="requestorid"
                                       value="<?php htmlout($friendRequest['userid']) ?>">

                                <input type="submit" name="action" value="Approve">
                            </div>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <!--image upload-->
    <form id='uploadImg' action="uploadFile.php" method="post" enctype="multipart/form-data">
        <div><label for="profileImg">Select file</label></div>
        <div><input id="profileImg" type="file" name="profileImg[]"></div>
        <input type="hidden" name="action" value="uploadImg">
        <input type="hidden" name="MAX_FILE_SIZE" value="204800">
        <input type="submit" value="Submit">
    </form>

    <!-- display image here -->
    <img id="profileImage" width="200" height="200" src="uploads/images/141236745127.0.0.1.png">

    <h1>Find new friends</h1>

    <form id="findfriend" action="" method="post">
        <label id="entername">Enter a name</label><input type="text" id="friendname" name="friendname"></input>
        <input type="submit" id="searchfriend" name="searchFriend" value="Search">
    </form>
    <?php if (isset($searchedUsers) and !empty($searchedUsers)): ?>
        <table id="searchedfriends">
            <tr id="top">
                <th>Name</th>
                <th>Add as Friend</th>
            </tr>
            <?php foreach ($searchedUsers as $searchedUser): ?>
                <tr>
                    <td><?php htmlout($searchedUser['first_name']) ?></td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="requesteeid" value="<?php htmlout($searchedUser['id']); ?>">
                            <input type="submit" name="friendRequest" value="Send Request">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif (isset($searchedUsers) and empty($searchedUsers)): ?>
        <p class="noresult">Sorry, no matching results :(</p>
    <?php endif; ?>
    <div id="json"></div>
    <div id="json2"></div>


</div>

<script type="text/javascript">
    //var friends=JSON.parse('');
    //alert("sds");
    //document.getElementById("displaymsg").innerHTML="221212";
    //alert("sdsds");

</script>
</body>
</html>