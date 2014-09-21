<?php
/**
 * Created by PhpStorm.
 * User: vivek
 * Date: 20/5/14
 * Time: 11:45 PM
 */

//this file defines functions for login functionality
// remove magic quotes
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/magicquotes.inc.php';

//$GLOBALS[]
//$userid='';

function userIsLoggedIn()
{
    if (isset($_POST['action']) and $_POST['action'] == 'login') {
        // fields must not be empty
        if (!isset($_POST['username']) or $_POST['username'] == '' or !isset($_POST['password']) or $_POST['password'] == '') {
            $GLOBALS['chatLoginError'] = 'Please fill in both fields';
            return false;
        }

        $password = hash('sha256', $_POST['password']);

        if (databaseContainsUser($_POST['username'], $password)) {
            session_start();
            $_SESSION['chatLoggedIn'] = true;
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['password'] = $password;
            $_SESSION['userid'] = $GLOBALS['userid'];

            include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

            try {
                $sql = 'UPDATE chatusers SET online=1 WHERE username=:username';
                $s = $pdo->prepare($sql);
                $s->bindValue(':username', $_SESSION['username']);
                $s->execute();
            } catch (PDOException $e) {
                $error = 'Error updating user online status: ' . $e->getMessage();
                include 'error.html.php';
                exit();
            }

            return true;
        } else {
            session_start();
            unset($_SESSION['chatLoggedIn']);
            unset($_SESSION['username']);
            unset($_SESSION['password']);
            unset($_SESSION['userid']);
            $GLOBALS['chatLoginError'] = 'The specified username or password was incorrect';
            return false;
        }
    }

    if (isset($_POST['action']) and $_POST['action'] == 'logout') {

        session_start();

        include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

        try {
            $sql = 'UPDATE chatusers SET online=0 WHERE username=:username';
            $s = $pdo->prepare($sql);
            $s->bindValue(':username', $_SESSION['username']);
            $s->execute();
        } catch (PDOException $e) {
            $error = 'Error updating user online status: ' . $e->getMessage();
            include 'error.html.php';
            exit();
        }


        unset($_SESSION['chatLoggedIn']);
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        unset($_SESSION['userid']);


        header('Location: .');
        exit();
    }

    session_start();
    if (isset($_SESSION['chatLoggedIn'])) {
        //echo '$_SESSION[\'email\']'.$_SESSION['email'].'<br>';
        return databaseContainsUser($_SESSION['username'], $_SESSION['password']);
    }
    return false;
}

function databaseContainsUser($username, $password)
{
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
    try {
        //echo '$email: '.$email.'<br>';

        $sql = 'SELECT id FROM chatusers WHERE username=:username AND password=:password';
        //$sql='SELECT id FROM chatusers WHERE username="vivek" AND password="vvv"';
        $s = $pdo->prepare($sql);
        $s->bindValue(':username', $username);
        $s->bindValue(':password', $password);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Error searching for author: ' . $e->getMessage();
        include 'error.html.php';
        exit();
    }

    $row = $s->fetch();

    if ($row[0] == null) {
        $GLOBALS['userid'] = '';
        return false;
        //echo 'access denied';
        //exit();
    } else {
        $GLOBALS['userid'] = $row[0];
        return true;
        //echo 'access granted';
        //exit();
    }
}

/*
function userHasRole($role)
{
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    try
    {
        $sql="SELECT COUNT(*) FROM authors INNER JOIN
        authorrole ON authors.id=authorid INNER JOIN
        roles ON roles.id=roleid WHERE
        email=:email AND roles.id=:roleid";
        $s=$pdo->prepare($sql);
        $s->bindValue(':email',$_SESSION['email']);
        $s->bindValue(':roleid',$role);
        $s->execute();
    }
    catch(PDOException $e)
    {
        $error='Error searching for author roles: '.$e->getMessage();
        include 'error.html.php';
        exit();
    }

    $row=$s->fetch();

    if($row[0]>0)
        return true;
    else
        return false;
}*/



