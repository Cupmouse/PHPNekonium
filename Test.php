<?php

include_once 'util\data.php';
include_once 'util\NekUtility.php';
include_once 'NekoniumRPC.php';

use kabayaki\PHPNekonium as Gnek;

$nek = new Gnek\NekoniumRPC('localhost', 8293);

var_dump($nek->eth_getBlockByNumber(Gnek\blockParameter::pending(), true));

$receipt = $nek->eth_getTransactionReceipt(Gnek\data::fromHex('0x4dcc0395628e9263d7c44bbf6e9338b54eac970ad253a24d815388dfac6f2013'));

var_dump($receipt);