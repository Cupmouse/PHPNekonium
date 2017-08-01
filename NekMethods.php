<?php

namespace kabayaki\PHPNekonium;

include_once __DIR__.'\NekMethod.php';

/**
 * Lists of Nekonium API method.
 *
 * For detailed information of the methods are found {@link https://github.com/ethereum/wiki/wiki/JSON-RPC here}.
 * And for management methods, {@link https://github.com/ethereum/go-ethereum/wiki/Management-APIs here}.
 *
 * @package kabayaki\PHPNekonium
 */
class NekMethods
{
    // To prevent creating instance
    private function __construct() {}

    public static function web3_clientVersion() {
        return new NekMethod(__FUNCTION__, array());
    }
}