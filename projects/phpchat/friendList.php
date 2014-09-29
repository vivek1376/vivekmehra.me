<?php
/**
 * Created by PhpStorm.
 * User: vivek
 * Date: 29/9/14
 * Time: 1:23 AM
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/magicquotes.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';

//echo json_encode('OK');
//return;

if (isset($_POST['frHash'])) {
//echo 'aaa';
    //connect to DB
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

//prepare list of friends
    /* chatfriends table has only 1 entry for a distinct pair of friends */
    try {
        $sql = 'SELECT id,first_name,username,online FROM chatusers CU INNER JOIN chatfriends CF ON CU.id=CF.friendid WHERE userid=:uid'; // . $_SESSION['userid'] . '"';
        $s = $pdo->prepare($sql);
        $s->bindValue(':uid', $_POST['uid']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Error fetching friends details: ' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    $chatFriends1 = $s->fetchAll();

    unset($s);

    try {
        $sql = 'SELECT id,first_name,username,online FROM chatusers CU INNER JOIN chatfriends CF ON CU.id=CF.userid WHERE friendid=:uid'; // . $_SESSION['userid'] . '"';
        $s = $pdo->prepare($sql);
        $s->bindValue(':uid', $_POST['uid']);
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

    //prepare string
    $frStrNew = implode("_", array_map(function ($entry) {
        return $entry['id'] . '.' . $entry['online'];
    }, $chatFriends));

    $frHashNew = sha1($frStrNew);

    if ($frHashNew == $_POST['frHash'])



        //echo 'OK';
        //$fr=$chatFriends[0];
        echo json_encode(array('OK',$frHashNew));

    //echo '<text>OK</text>';
    else
    {
        $tb =
            '<tr class="top">' .
            '<th class="name">Name</th>' .
            '<th>status</th>' .
            '<th>click to chat</th>' .
            '</tr>';
        foreach ($chatFriends as $friend):
            $tb .= ('<tr>' .
                '<td class="name ' . $friend['id'] . '">' . $friend['first_name'] . '</td>' .
                '<td class="status ' . $friend['id'] . '">');
            if ($friend['online'] == 1)
                $tb .= 'online';
            else
                $tb .= 'offline';
            $tb .= ('</td>' .
                '<td class="chat ' . $friend['id'] . '">');
            if ($friend['online'] == 1)
                $tb .= ('<form action="" method="post">' .
                    '<input type="hidden" name="chatFriend" value="' . $friend['id'] . '">' .
                    '<input type="submit" value="Chat">' .
                    '</form>');

            $tb .= ('</td>' .
                '</tr>');
        endforeach;

        echo json_encode(array($tb,$frHashNew));
    }
}
?>
