<?php

namespace kabayaki\PHPNekonium;

include_once __DIR__.'\NekConnectionException.php';
include_once __DIR__ . '\NekServerSideException.php';
include_once __DIR__.'\NekMethodCallResult.php';

abstract class NekClient
{
    private $nonce = 0;

    public function getNonce()
    {
        return $this->nonce++;
    }

    /**
     * Send raw message to server. internal function
     *
     * @param string $rawData
     * @return string
     * @throws NekConnectionException When connection error occurred
     */
    protected abstract function _sendRaw(string $rawData): string;

    /**
     * Call Nekonium method, internal function.
     *
     * @param string $methodName method name
     * @param array $paramArray methods parameter
     * @return NekMethodCallResult Result of method call
     * @throws NekConnectionException When connection error occurred
     * @throws NekServerSideException When server side error occurred
     */
    protected function _callNamed(string $methodName, array $paramArray): NekMethodCallResult
    {
        $nonce = $this->getNonce();

        $dataArray = array();
        $dataArray['jsonrpc'] = '2.0';
        $dataArray['method'] = $methodName;
        $dataArray['params'] = $paramArray;
        $dataArray['id'] = $nonce;

        $callData = json_encode($dataArray);

        // Send server method call
        $result = $this->sendRaw($callData);

        // Now conversion

        $encoded = json_decode($result);

        // Id returned from server has to be same as id sent
        if ($encoded->id !== $nonce)
            throw new NekConnectionException(
                "Id server returned is not same as id sent, bad server behavior");

        if (array_key_exists('error', $encoded)) {
            // Server side error
            // TODO Server may close connection immediately after returning an error, should we detect that? (For IPC)

            // Throwing an error
            throw new NekServerSideException($encoded->error->message, $encoded->error->code);
        }

        // No error, successfully called method

        return new NekmethodCallResult($encoded->id, (array) $encoded->result);
    }

    /**
     * Call Nekonium API method.
     * @link NekMethods List of method
     *
     * @param NekMethod $method
     * @return NekMethodCallResult Result of method call
     * @throws NekConnectionException If exception occurred when calling method
     * @throws NekServerSideException If error occurred when server processing your call
     * @throws \InvalidArgumentException If $method was null
     */
    public function call(NekMethod $method): NekMethodCallResult
    {
        if ($method === null)
            throw new \InvalidArgumentException('$method cannot be null');

        return $this->_callNamed($method->getName(), $method->getParam());
    }

    /**
     * Call Nekonium API method with name and its parameter.
     *
     * @param string $methodName Nekonium API method name
     * @param array $paramArray Method parameter
     * @return NekMethodCallResult Result of method call
     * @throws NekConnectionException If exception occurred when calling method
     * @throws NekServerSideException If error occurred when server processing your call
     * @throws \InvalidArgumentException If one of function parameter was null
     */
    public function callNamed(string $methodName, array $paramArray): NekMethodCallResult
    {
        if ($methodName === null)
            throw new \InvalidArgumentException('$method cannot be null');
        if ($paramArray === null)
            throw new \InvalidArgumentException('$paramArray cannot be null');

        return $this->_callNamed($methodName, $paramArray);
    }

    /**
     * Send Nekonium a raw string data.
     * No exception occurs for server side error.
     *
     * @param string $rawData Raw data to be sent
     * @return string String result returned from server
     * @throws NekConnectionException If exception occurred when sending raw data
     * @throws \InvalidArgumentException If $rawData was null
     */
    public function sendRaw(string $rawData): string
    {
        return $this->_sendRaw($rawData);
    }
}