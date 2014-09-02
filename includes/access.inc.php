<?php
/**
 * Created by PhpStorm.
 * User: vivek
 * Date: 20/5/14
 * Time: 11:45 PM
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/magicquotes.inc.php';

function userIsLoggedIn()
{
    if(isset($_POST['action']) and $_POST['action']=='login')
    {
        if(!isset($_POST['email']) or $_POST['email']=='' or !isset($_POST['password']) or $_POST['password']=='')
        {
            $GLOBALS['loginError']='Please fill in both fields';
            return false;
        }

        $password=hash('sha256',$_POST['password']);

        if(databaseContainsAuthor($_POST['email'],$password))
        {
            session_start();
            $_SESSION['loggedIn']=true;
            $_SESSION['email']=$_POST['email'];
            $_SESSION['password']=$password;
            return true;
        }
        else
        {
            session_start();
            unset($_SESSION['loggedIn']);
            unset($_SESSION['email']);
            unset($_SESSION['password']);
            $GLOBALS['loginError']='The specified email address or password was incorrect';
            return false;
        }
    }

    if(isset($_POST['action']) and $_POST['action']=='logout')
    {
        session_start();
        unset($_SESSION['loggedIn']);
        unset($_SESSION['email']);
        unset($_SESSION['password']);
        header('Location: '.$_POST['goto']);
        exit();
    }

    session_start();
    if(isset($_SESSION['loggedIn']))
    {
        //echo '$_SESSION[\'email\']'.$_SESSION['email'].'<br>';
        return databaseContainsAuthor($_SESSION['email'],$_SESSION['password']);
    }
}

function databaseContainsAuthor($email,$password)
{
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    try
    {
        //echo '$email: '.$email.'<br>';
        $sql='SELECT COUNT(*) FROM authors WHERE email=:email AND password=:password';
        $s=$pdo->prepare($sql);
        $s->bindValue(':email',$email);
        $s->bindValue(':password',$password);
        $s->execute();
    }
    catch(PDOException $e)
    {
        $error='Error searching for author: '.$e->getMessage();
        include 'error.html.php';
        exit();
    }

    $row=$s->fetch();

    if($row[0]>0)
    {
        return true;
        //echo 'access granted';
        //exit();
    }
    else
    {
        return false;
        //echo 'access denied';
        //exit();
    }
}

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
}



