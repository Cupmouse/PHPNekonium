<?php

namespace kabayaki\PHPNekonium;

include_once __DIR__.'\NekMethods.php'; // For library user
include_once __DIR__.'\NekClient.php';
include_once __DIR__.'\NekMethod.php';
include_once __DIR__.'\NekConnectionException.php';
include_once __DIR__ . '\NekServerSideException.php';
include_once __DIR__.'\NekMethodCallResult.php';

/**
 * Despite IPC client, RPC client connect and send message EVERY TIME you issue a method call,
 * which takes more computation resource. And it's also lacks security and so by default, go-nekonium is not supporting
 * the use of 'personal' or 'admin' method call, just allowing 'eth' prefixed method call. Although you can change
 * go-nekonium settings to allow these, it's not recommended.
 *
 * So, if you want to send transaction or use functionality that needs to unlock a account,
 * you might not want to use RPC client, but use IPC client instead.
 *
 * @package kabayaki\PHPNekonium
 */
class NekoniumRPC extends NekClient
{
    private $host;
    private $port;

    /**
     * Create new RPC client for Nekonium.
     * In this class, you do not have to call connect() or close(),
     * but it automatically connects host when {@link NekClient::call}, {@link NekClient::callNamed} or
     * {@link NekClient::sendRaw} function is called.
     * For more information, see {@link NekoniumRPC}.
     *
     * @param $host string Nekonium RPC host address to connect
     * @param $port int Nekonium RPC port to connect
     */
    public function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
    }


    /**
     * {@inheritdoc}
     */
    protected function _sendRaw(string $rawData): string
    {
        // Request POST to server using curl
        $cu = curl_init();

        if ($cu === false) {
            throw new NekConnectionException(
                'curl_init() failed, maybe Curl is not supported?');
        }

        // Set host setting
        curl_setopt($cu, CURLOPT_URL, "localhost");
        curl_setopt($cu, CURLOPT_PORT, "8293");

        // Set POST setting
        curl_setopt($cu, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($cu, CURLOPT_POST, true);
        curl_setopt($cu, CURLOPT_POSTFIELDS, $rawData);

        // Instead of printing out result, we want result to be returned
        curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);

        // Execute, sending POST request to server
        $res = curl_exec($cu);

        // Check if request was success
        if ($res === false) {
            $errmsg = htmlspecialchars(curl_error($cu));
            throw new NekConnectionException("curl_exec() failed : $errmsg");
        }

        // Server successfully returned result

        return $res;
    }
}