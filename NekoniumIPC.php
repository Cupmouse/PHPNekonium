<?php

namespace kabayaki\PHPNekonium;

include_once __DIR__ . '\NekMethods.php'; // For library user
include_once __DIR__.'\NekClient.php';
include_once __DIR__.'\NekMethod.php';
include_once __DIR__.'\NekConnectionException.php';
include_once __DIR__ . '\NekServerSideException.php';
include_once __DIR__.'\NekMethodCallResult.php';

/**
 * YOU NEED TO CALL close() AFTER COMMUNICATING.
 *
 * Handling Nekonium IPC connection.
 * To connect to Nekonium via ipc, create instance of this class.
 * Unlike the RPC client, you need to call {@link connect} before calling a method,
 * and call {@link close} after doing stuff.
 * You can {@link connect()} again after {@link close()}.
 *
 * @package kabayaki\PHPNekonium
 */
class NekoniumIPC extends NekMethodCaller
{
    private $ipcpath;

    private $socket;

    /**
     * NekoniumIPC constructor.
     *
     * @param $ipcpath string Path to Nekonium IPC file.
     */
    public function __construct($ipcpath)
    {
        $this->ipcpath = $ipcpath;
    }

    /**
     * Attempts to connect Nekonium using ipc.
     *
     * @return void Nothing to return.
     * @throws NekConnectionException If error occurred while opening a connection.
     */
    public function connect()
    {
        $socket = @socket_create(AF_UNIX, SOCK_STREAM, 0);

        if ($socket === false) {
            $errmsg = socket_strerror(socket_last_error());
            throw new NekConnectionException('Unable to open a connection to nekonium, maybe Socket is not supported? : ' . htmlspecialchars($errmsg));
        }

        $result = @socket_connect($socket, $this->ipcpath);

        if ($result === false) {
            $errmsg = socket_strerror(socket_last_error($socket));
            throw new NekConnectionException('Unable to open a connection to nekonium : ' . htmlspecialchars($errmsg));
        }

        $this->socket = $socket;
    }

    /**
     * Closing current Nekonium connection
     *
     * @return void No return value.
     */
    public function close()
    {
        @socket_close($this->socket);
        $this->socket = null;
    }

    /**
     * {@inheritdoc}
     */
    protected function _sendRaw(string $rawData): string
    {
        if ((@socket_send($this->socket, $rawData, strlen($rawData), MSG_EOF)) === false) {
            // socket_send failed

            $errmsg = htmlspecialchars(socket_strerror(socket_last_error($this->socket)));
            throw new NekConnectionException(
                "socket_send() failed, maybe server have already closed connection? : $errmsg");
        }

        $lbc = 0;
        $rbc = 0;
        $nextcheck = 0;
        $buf = '';
        $instrflag = false;
        // TODO maybe catching exception on json_decode() are better?
        // TODO maybe variable len
        // Count left bracket and right bracket.
        // If left bracket === right bracket, it means we received whole json then leave while.
        while (($bytesrecvd = @socket_recv($this->socket, $buf, 32 * 1024, MSG_PEEK))) {
            // Counting starts from the point where next position (+1) it previously checked
            for ($i = $nextcheck; $i < $bytesrecvd; $i++) {

                // Check if we are in string, if then ignores all brackets, but check for string end.
                if ($instrflag) {
                    // Check if string ends
                    if ($buf{$i} === '"') {
                        // String ended
                        $instrflag = false;
                    }
                } else {
                    // Check if string starts
                    if ($buf{$i} === '"') {
                        // String started
                        $instrflag = true;
                    } else {
                        // Count brackets
                        if ($buf{$i} === '{') {
                            $lbc++;
                        } else if ($buf{$i} === '}') {
                            $rbc++;
                        }
                    }
                }
            }

            if ($lbc === $rbc) {
                // We have received whole json. leave while
                break;
            }

            // Next position will be bytes received (because it is checked pos + 1).
            $nextcheck = $bytesrecvd;
        }

        // socket_recv() returned with error, handle that
        if ($bytesrecvd === false) {
            $errmsg = htmlspecialchars(socket_strerror(socket_last_error($this->socket)));
            throw new NekConnectionException(
                "socket_recv() failed, maybe server have already closed connection? : $errmsg");
        }

        // Successfully received json!

        return $buf;
    }

    /**
     * {@inheritdoc}
     */
    public function call(NekMethod $method)
    {
        if ($this->socket === null)
            throw new NekConnectionException('Not connected to Nekonium IPC yet');

        return parent::call($method);
    }

    /**
     * {@inheritdoc}
     */
    public function callNamed(string $methodName, array $paramArray)
    {
        if ($this->socket === null)
            throw new NekConnectionException('Not connected to Nekonium IPC yet');

        return parent::callNamed($methodName, $paramArray);
    }

    /**
     * {@inheritdoc}
     */
    public function sendRaw(string $rawData): string
    {
        if ($this->socket === null)
            throw new NekConnectionException('Not connected to Nekonium IPC yet');

        return parent::sendRaw($rawData);
    }


}