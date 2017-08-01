<?php

include_once 'NekoniumRPC.php';

use kabayaki\PHPNekonium as Gnek;

$nek = new Gnek\NekoniumRPC('localhost', 8293);
$result = $nek->eth_blockNumber();
var_dump($result);