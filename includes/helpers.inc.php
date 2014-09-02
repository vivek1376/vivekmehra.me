<?php
/**
 * Created by PhpStorm.
 * User: vivek
 * Date: 4/5/14
 * Time: 3:40 PM
 */

function htmlout($text)
{
    echo htmlspecialchars($text,ENT_QUOTES,'UTF-8');
}