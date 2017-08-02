<?php

include_once 'util\data.php';
include_once 'util\NekUtility.php';
include_once 'NekoniumRPC.php';

use kabayaki\PHPNekonium as Gnek;

$nek = new Gnek\NekoniumRPC('localhost', 8293);

var_dump($nek->eth_getBlockByNumber(Gnek\blockParameter::latest(), false));
