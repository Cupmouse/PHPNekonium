<?php

include_once 'util\data.php';
include_once 'util\NekUtility.php';
include_once 'NekoniumRPC.php';

use kabayaki\PHPNekonium as Gnek;

$nek = new Gnek\NekoniumRPC('localhost', 8293);

$block = $nek->eth_getBlockByNumber(Gnek\blockParameter::blockNumber(	Gnek\quantity::fromBCMath('153924')), true);

echo $block->getGasUsed()->asBCMath();
echo $block->getGasUsed()->asBCMath();