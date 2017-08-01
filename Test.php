<?php

include_once 'NekoniumRPC.php';

use kabayaki\PHPNekonium as Gnek;
use kabayaki\PHPNekonium\NekMethods as Methods;

$nek = new Gnek\NekoniumRPC('localhost', 8293);
$result = $nek->call(Methods::web3_clientVersion());
var_dump($result);