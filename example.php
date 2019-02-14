<?php
/**
 * @author Tommy A. Surbakti <tommy@surbakti.net>
* */

include 'icecast.php';

$ices = new Surbakti\IceCast();
$ices->setUrl('http://git.ndikkar.com:8000');
echo "<pre>";
var_dump($ices->getStatus());
