<?php
/**
 * Created by PhpStorm.
 * User: vivek
 * Date: 24/5/14
 * Time: 4:17 PM
 */

//remove magic quotes
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/magicquotes.inc.php';


require_once 'access.inc.php';

if (!userIsLoggedIn()) {
// user is not logged in
    if (isset($_GET['registerform'])) {
        // show registration form
        include 'register.html.php';
        exit();
    }
    if (isset($_POST['registernew'])) {
        //new user details submitted
        if ($_POST['fname'] != '' && $_POST['lname'] != '' && $_POST['uname'] != '') {
            if ($_POST['pwd'] != '' && ($_POST['pwd'] == $_POST['retypepwd'])) {

                include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

                //check if entered username is unique
                try {
                    $sql = 'SELECT COUNT(username) FROM chatusers WHERE username=:uname';
                    $s = $pdo->prepare($sql);
                    $s->bindValue(':uname', $_POST['uname']);
                    $s->execute();
                } catch (PDOException $e) {
                    $error = 'error finding number of usernames ' . $e->getMessage();
                    include 'error.html.php';
                    exit();
                }
                $usernames = $s->fetchColumn(0);
                if ($usernames > 0) {
                    echo 'username already exists';
                    exit();
                }

                //show captcha image
                include 'securimage/securimage.php';

                $securimage = new Securimage();

                if ($securimage->check($_POST['captcha_code']) == false) {
                    // the code was incorrect
                    // you should handle the error so that the form processor doesn't continue

                    // or you can use the following code if there is no validation or you do not know how
                    echo "The security code entered was incorrect.<br /><br />";
                    echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
                    exit();
                }

                //now ok, register users into database
                try {
                    $sql = 'INSERT INTO chatusers SET
                    first_name=:fname,
                    last_name=:lname,
                    email=:email,
                    username=:uname,
                    password=:pwd';

                    $password = hash('sha256', $_POST['pwd']);

                    $s = $pdo->prepare($sql);
                    $s->bindValue(':fname', $_POST['fname']);
                    $s->bindValue(':lname', $_POST['lname']);
                    $s->bindValue(':email', $_POST['email']);
                    $s->bindValue(':uname', $_POST['uname']);
                    $s->bindValue(':pwd', $password);

                    $s->execute();
                } catch (PDOException $e) {
                    $error = 'error inserting new user ' . $e->getMessage();
                    include 'error.html.php';
                    exit();
                }

                echo 'success<br>';
                echo 'now <a href="?">login</a>';
                exit();
            }
        }
        echo 'wrong'; //d
        exit();
    }

    // just show login form
    include 'login.html.php';
    exit();
}

// user already logged in
if (isset($_POST['searchFriend']) and $_POST['searchFriend'] == 'Search') {
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    //if(isset($_POST['friendname']) and $_POST['friendname']!='')
    //{
    try {
        $sql = 'SELECT id,first_name,username FROM chatusers where first_name LIKE "%' . $_POST['friendname'] . '%"' .
            ' AND id NOT IN (SELECT friendid FROM chatfriends WHERE userid="' . $_SESSION['userid'] . '")' .
            ' AND id NOT IN (SELECT userid FROM chatfriends WHERE friendid="' . $_SESSION['userid'] . '")' .
            ' AND id NOT IN (SELECT requesteeid FROM friendrequests WHERE userid="' . $_SESSION['userid'] . '")' .
            ' AND id !="' . $_SESSION['userid'] . '"';
        $result = $pdo->query($sql);
    } catch (PDOException $e) {
        $error = 'Error fetching details of users: ' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    $searchedUsers = $result->fetchAll();
    // }
}

if (isset($_POST['friendRequest'])) {
    // friend request sent, add it to database
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    try {
        $sql = 'INSERT INTO friendrequests SET
    userid=:userid,
    requesteeid=:requesteeid';
        $s = $pdo->prepare($sql);
        $s->bindValue(':userid', $_SESSION['userid']);
        $s->bindValue(':requesteeid', $_POST['requesteeid']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Error creating friend request: ' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
}


if (isset($_POST['approveRequest'])) {
    // approve button clicked, now add friend into database
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    try {
        $sql = 'INSERT INTO chatfriends SET
    userid=:userid,
    friendid=:friendid';
        $s = $pdo->prepare($sql);
        $s->bindValue(':userid', $_SESSION['userid']);
        $s->bindValue(':friendid', $_POST['requestorid']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Error adding friend : ' . $e->getMessage();
        include 'error.html.php';
        exit();
    }

    //now delete friend request
    try {
        $sql = 'DELETE FROM friendrequests WHERE requesteeid=:requesteeid and
userid=:userid';
        $s = $pdo->prepare($sql);
        $s->bindValue(':requesteeid', $_SESSION['userid']);
        $s->bindValue(':userid', $_POST['requestorid']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Error deleting friend request: ' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
}

if (isset($_POST['chatFriend'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    $friendid = $_POST['chatFriend'];

    try {
        $sql = 'SELECT first_name FROM chatusers WHERE id=:id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $friendid);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Error retreiving friend name: ' . $e->getMessage();
        include 'error.html.php';
        exit();
    }

    $friendName = $s->fetchColumn(0);

    include 'chatwindow.html.php';
    exit();
}


include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

//prepare list of friends
/* chatfriends table has only 1 entry for a distinct pair of friends */
try {
    $sql = 'SELECT id,first_name,username,online FROM chatusers CU INNER JOIN chatfriends CF ON CU.id=CF.friendid WHERE userid="' . $_SESSION['userid'] . '"';
    $s = $pdo->prepare($sql);
    $s->execute();
} catch (PDOException $e) {
    $error = 'Error fetching friends details: ' . $e->getMessage();
    include 'error.html.php';
    exit();
}

$chatFriends1 = $s->fetchAll();

unset($s);

try {
    $sql = 'SELECT id,first_name,username,online FROM chatusers CU INNER JOIN chatfriends CF ON CU.id=CF.userid WHERE friendid="' . $_SESSION['userid'] . '"';
    $s = $pdo->prepare($sql);
    $s->execute();
} catch (PDOException $e) {
    $error = 'Error fetching friends details: ' . $e->getMessage();
    include 'error.html.php';
    exit();
}

$chatFriends2 = $s->fetchAll();

//combine in one array
$chatFriends = array_merge($chatFriends1, $chatFriends2);

//sort all friends based on ID
usort($chatFriends, function ($a, $b) {
    return $a['id'] - $b['id'];
});

try {
    $sql = 'SELECT userid,first_name FROM friendrequests FR INNER JOIN chatusers CU ON FR.userid=CU.id WHERE requesteeid="' . $_SESSION['userid'] . '"';
    $result = $pdo->query($sql);
} catch (PDOException $e) {
    $error = 'Error searching friend requests: ' . $e->getMessage();
    include 'error.html.php';
    exit();
}

$friendRequests = $result->fetchAll();


include 'friendForm.html.php';



//include 'chatwindow.html.php';

?>