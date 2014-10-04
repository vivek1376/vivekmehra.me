<?php
/**
 * Created by PhpStorm.
 * User: vivek
 * Date: 28/5/14
 * Time: 3:16 AM
 */

include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';

$sql = 'SELECT MAX(id) FROM messages';
$s = $pdo->query($sql);
$val = $s->fetch();
//echo $val[0];
$cc[] = array();
//echo json_encode($cc);

$tx = '<<<3.*';
echo $tx;
//htmlout($tx);

//$dd=json_encode($cc);

//for(var i in )
?>