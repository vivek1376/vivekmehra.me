<?php
/**
 * Created by PhpStorm.
 * User: vivek
 * Date: 12/6/14
 * Time: 3:02 PM
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/magicquotes.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';

if (isset($_POST['msg'])) {
    if ($_POST['msg'] != '') {
        include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

        try {
            //$msgtimestamp = date("Y-m-d H:i:s");
            $sql = 'INSERT INTO messages SET
        message=:msg';
            $s = $pdo->prepare($sql);
            $s->bindValue(':msg', $_POST['msg']);
            $s->execute();
        } catch (PDOException $e) {
            $error = 'Error inserting message into table: ' . $e->getMessage();
            include 'error.html.php';
            exit();
        }
        echo 'x'; //json_encode($msgarr);
    }
} elseif (isset($_POST['latestMsgID'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
    //echo 'xyz';

    if ($_POST['latestMsgID'] == '') {
        $sql = 'SELECT MAX(id) FROM messages';
        $s = $pdo->query($sql);
        $val = $s->fetch();

        if ($val[0] == null)
            $msgs[] = array('id' => '0', 'bd' => 'fIrSt');
        else
            $msgs[] = array('id' => $val[0], 'bd' => 'fIrSt');

        echo json_encode($msgs);
        unset ($msgs);
    } else {
        $timeWasted = 0;
        while ($timeWasted < 35) {
            try {
                $sql = 'SELECT COUNT(id) FROM messages WHERE id > :latestmsgid';
                $s = $pdo->prepare($sql);
                $s->bindValue(':latestmsgid', $_POST['latestMsgID']);
                $s->execute();
            } catch (PDOException $e) {
                $error = 'Error counting number of rows: ' . $e->getMessage();
                include 'error.html.php';
                exit();
            }

            $msgs = array();

            $cnt = $s->fetch();
            if ($cnt[0] > 0) {
                try {
                    $tt = '';
                    $sql = 'SELECT id,message FROM messages WHERE id > :latestmsgid';
                    $s = $pdo->prepare($sql);
                    $s->bindValue(':latestmsgid', $_POST['latestMsgID']);
                    $s->execute();
                } catch (PDOException $e) {
                    $error = 'Error retrieving message: ' . $e->getMessage();
                    include 'error.html.php';
                    exit();
                }

                $result = $s->fetchAll();

                $msgs = array();
                foreach ($result as $row) {
                    $msgs[] = array('id' => $row['id'], 'bd' => $row['message']);
                }
                //echo json_encode($msgs);
                //exit();
                break;
            }
            usleep(800000);
            //sleep(1);
            $timeWasted += 1;
        }
        //$msgs=array();
        echo json_encode($msgs);
        //unset($msgs);
    }
    //exit();
}