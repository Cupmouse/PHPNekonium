<?php

namespace kabayaki\PHPNekonium;

include_once __DIR__.'\NekClient.php';
include_once __DIR__.'\util\block.php';
include_once __DIR__.'\util\blockParameter.php';
include_once __DIR__.'\util\quantity.php';
include_once __DIR__.'\util\transaction.php';
include_once __DIR__.'\util\transactions.php';
include_once __DIR__.'\util\transactionReceipt.php';

/**
 * Nekonium API method caller.
 *
 * For detailed information of the methods are found {@link https://github.com/ethereum/wiki/wiki/JSON-RPC here}.
 *
 * And for management methods, {@link https://github.com/ethereum/go-ethereum/wiki/Management-APIs here}.
 *
 * @package kabayaki\PHPNekonium
 */
abstract class NekMethodCaller extends NekClient
{
    public function web3_clientVersion(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function web3_sha3(data $data): data
    {
        return data::fromHex($this->callNamed(__FUNCTION__, array($data)));
    }
    public function net_version(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function net_peerCount(): quantity
    {
        return quantity::fromHex($this->callNamed(__FUNCTION__, array()));
    }
    public function net_listening(): bool
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_protocolVersion(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }

    /**
     * @return mixed bool <b>false</b> on NOT syncing, when syncing,
     *          <b>array('startingBlock'=>quantity, 'currentBlock'=>quantity, 'highestBlock'=>quantity)</b> will be return.
     */
    public function eth_syncing(): mixed
    {
        $result = $this->callNamed(__FUNCTION__, array());

        // On false, server is not syncing, on assoc array, server is syncing.
        if ($result === false) {
            return false;
        } else {
            $rtn = array(
                'startingBlock'=>quantity::fromHex($result['startingBlock']),
                'currentBlock'=>quantity::fromHex($result['currentBlock']),
                'highestBlock'=>quantity::fromHex($result['highestBlock']),
            );

            return $rtn;
        }
    }
    public function eth_coinbase(): data
    {
        return data::fromHex($this->callNamed(__FUNCTION__, array()));
    }
    public function eth_mining(): bool
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_hashrate(): quantity
    {
        return quantity::fromHex($this->callNamed(__FUNCTION__, array()));
    }
    public function eth_gasPrice(): quantity
    {
        return quantity::fromHex($this->callNamed(__FUNCTION__, array()));
    }

    /**
     * @return array Array of data
     */
    public function eth_accounts(): array
    {
        $result = $this->callNamed(__FUNCTION__, array());
        $rtn = [];

        for ($i = 0; $i < count($result); $i++)
            $rtn[$i] = data::fromHex($result[$i]);

        return $rtn;
    }
    public function eth_blockNumber(): quantity
    {
        return quantity::fromHex($this->callNamed(__FUNCTION__, array()));
    }

    public function eth_getBalance(data $address): quantity
    {
        return quantity::fromHex($this->callNamed(__FUNCTION__,
            array($address->toJsonCompatible())
        ));
    }

    /**
     * @param data $address Address data
     * @param quantity $position Storage position
     * @param $blockParameter blockParameter Block parameter
     * @return data Value at storage position
     */
    public function eth_getStorageAt(data $address, quantity $position, blockParameter $blockParameter): data
    {
        return data::fromHex($this->callNamed(__FUNCTION__,
            array(
                $address->toJsonCompatible(),
                $position->toJsonCompatible(),
                $blockParameter->toJsonCompatible()
            )
        ));
    }
    public function eth_getTransactionCount(data $address, blockParameter $blockParameter): quantity
    {
        return quantity::fromHex($this->callNamed(__FUNCTION__,
            array(
                $address->toJsonCompatible(),
                $blockParameter->toJsonCompatible()
            )
        ));
    }
    public function eth_getBlockTransactionCountByHash(data $blockHash): quantity
    {
        return quantity::fromHex($this->callNamed(__FUNCTION__,
            array($blockHash->toJsonCompatible())
        ));
    }
    public function eth_getBlockTransactionCountByNumber(blockParameter $blockParameter): quantity
    {
        return quantity::fromHex($this->callNamed(__FUNCTION__,
            array($blockParameter->toJsonCompatible())
        ));
    }
    public function eth_getUncleCountByBlockHash(data $blockHash): quantity
    {
        return quantity::fromHex($this->callNamed(__FUNCTION__,
            array($blockHash->toJsonCompatible())
        ));
    }
    // FIXME json RPC api web page suspicious / they say parameter is block parameter but showing quantity
    public function eth_getUncleCountByBlockNumber(blockParameter $blockParameter): quantity
    {
        return quantity::fromHex($this->callNamed(__FUNCTION__,
            array($blockParameter->toJsonCompatible())
        ));
    }
    public function eth_getCode(data $address, blockParameter $blockParameter): data
    {
        return data::fromHex($this->callNamed(__FUNCTION__,
            array(
                $address->toJsonCompatible(),
                $blockParameter->toJsonCompatible()
            )
        ));
    }
    public function eth_sign(data $address, data $message): data
    {
        return data::fromHex($this->callNamed(__FUNCTION__,
            array(
                $address->toJsonCompatible(),
                $message->toJsonCompatible()
            )
        ));
    }
    public function eth_sendTransaction(transaction $transaction): data
    {
        return data::fromHex($this->callNamed(__FUNCTION__,
            array($transaction->toJsonCompatible())
        ));
    }
    public function eth_sendRawTransaction(data $signedTransactionData): data
    {
        return data::fromHex($this->callNamed(__FUNCTION__,
            array($signedTransactionData->toJsonCompatible())
        ));
    }
    public function eth_call(data $transaction, blockParameter $blockParameter): data
    {
        return data::fromHex($this->callNamed(__FUNCTION__,
            array(
                $transaction->toJsonCompatible(),
                $blockParameter->toJsonCompatible()
            )
        ));
    }
    public function eth_estimateGas(transaction $transaction, blockParameter $blockParameter): quantity
    {
        return quantity::fromHex($this->callNamed(__FUNCTION__,
            array(
                $transaction->toJsonCompatible(),
                $blockParameter->toJsonCompatible()
            )
        ));
    }

    /**
     * @param data $blockHash The data object of hash of the block to get
     * @param bool $fullTransaction Set this true to include the full transaction objects,
     *              false to only hashes of the transactions.
     * @return block|null Null when no block was found, block object if block was found
     */
    public function eth_getBlockByHash(data $blockHash, bool $fullTransaction): block
    {
        $result = $this->callNamed(__FUNCTION__,
            array(
                $blockHash->toJsonCompatible(),
                $fullTransaction
            )
        );

        if ($result === null)
            return null;

        return block::fromASSOC($result, $fullTransaction, false);
    }
    /**
     * @param blockParameter $blockParameter blockParameter of the block to get
     * @param bool $fullTransaction Set this true to include the full transaction objects,
     *              false to only hashes of the transactions.
     * @return block|null Null when no block was found, block object if block was found
     */
    public function eth_getBlockByNumber(blockParameter $blockParameter, bool $fullTransaction): block
    {
        $result = $this->callNamed(__FUNCTION__,
            array(
                $blockParameter->toJsonCompatible(),
                $fullTransaction
            )
        );

        if ($result === null)
            return null;

        return block::fromASSOC($result, $fullTransaction, false);
    }

    /**
     * @param data $transactionHash The data object of hash of transaction to find
     * @return transaction|null Null when no transaction was found, transaction object if transaction was found
     */
    public function eth_getTransactionByHash(data $transactionHash): transaction
    {
        $result = $this->callNamed(__FUNCTION__,
            array($transactionHash->toJsonCompatible())
        );

        if ($result === null)
            return null;

        return transaction::fromASSOC($result);
    }
    public function eth_getTransactionByBlockHashAndIndex(data $blockHash, quantity $transactionIndex): transaction
    {
        $result = $this->callNamed(__FUNCTION__,
            array(
                $blockHash->toJsonCompatible(),
                $transactionIndex->toJsonCompatible()
            )
        );

        if ($result === null)
            return null;

        return transaction::fromASSOC($result);
    }
    public function eth_getTransactionByBlockNumberAndIndex(blockParameter $blockParameter, quantity $transactionIndex): transaction
    {
        $result = $this->callNamed(__FUNCTION__,
            array(
                $blockParameter->toJsonCompatible(),
                $transactionIndex->toJsonCompatible()
            )
        );

        if ($result === null)
            return null;

        return transaction::fromASSOC($result);
    }
    public function eth_getTransactionReceipt(data $transactionHash): transactionReceipt
    {
        $result = $this->callNamed(__FUNCTION__,
            array($transactionHash->toJsonCompatible())
        );

        if ($result === null)
            return null;

        return transactionReceipt::fromASSOC($result);
    }
    public function eth_getUncleByBlockHashAndIndex(data $blockHash, quantity $uncleIndex): block
    {
        $result = $this->callNamed(__FUNCTION__,
            array(
                $blockHash->toJsonCompatible(),
                $uncleIndex->toJsonCompatible()
            )
        );

        return block::fromASSOC($result, false, true);
    }
    public function eth_getUncleByBlockNumberAndIndex(blockParameter $blockParameter, quantity $uncleIndex): block
    {
        $result = $this->callNamed(__FUNCTION__,
            array(
                $blockParameter->toJsonCompatible(),
                $uncleIndex->toJsonCompatible()
            )
        );

        return block::fromASSOC($result, false, true);
    }

    /**
     * @return array Array of string
     */
    public function eth_getCompilers(): array
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_compileLLL(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    // TODO I guess they removed compiling thing
    public function eth_compileSolidity(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_compileSerpent(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    // TODO Filter
    public function eth_newFilter(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_newBlockFilter(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_newPendingTransactionFilter(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_uninstallFilter(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_getFilterChanges(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_getFilterLogs(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_getLogs(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }

    /**
     * @return array An array of data object contains three element
     */
    public function eth_getWork(): array
    {
        $result = $this->callNamed(__FUNCTION__, array());

        return array(
            data::fromHex($result[0]),
            data::fromHex($result[1]),
            data::fromHex($result[2])
        );
    }
    public function eth_submitWork(data $nonce, data $powHash, data $mixDigest): bool
    {
        return $this->callNamed(__FUNCTION__,
            array(
                $nonce->toJsonCompatible(),
                $powHash->toJsonCompatible(),
                $mixDigest->toJsonCompatible()
            )
        );
    }
    // TODO They did not specify type of parameters, i assumed it's data type
    public function eth_submitHashrate(data $hashRate, data $id): bool
    {
        return $this->callNamed(__FUNCTION__, array(
            $hashRate->toJsonCompatible(),
            $id->toJsonCompatible()
        ));
    }

    /**
     * @deprecated Will be removed in the future
     * @param string $databaseName
     * @param string $keyName
     * @param string $string
     * @return bool
     */
    public function db_putString(string $databaseName, string $keyName, string $string): bool
    {
        return $this->callNamed(__FUNCTION__,
            array(
                $databaseName,
                $keyName,
                $string
            )
        );
    }
    /**
     * @deprecated Will be removed in the future
     * @param string $databaseName
     * @param string $keyName
     * @return string
     */
    public function db_getString(string $databaseName, string $keyName): string
    {
        return $this->callNamed(__FUNCTION__,
            array(
                $databaseName,
                $keyName
            )
        );
    }

    /**
     * @deprecated Will be removed in the future
     * @param string $databaseName
     * @param string $keyName
     * @param data $data
     * @return bool
     */
    public function db_putHex(string $databaseName, string $keyName, data $data): bool
    {
        return $this->callNamed(__FUNCTION__,
            array(
                $databaseName,
                $keyName,
                $data->toJsonCompatible()
            )
        );
    }
    /**
     * @deprecated Will be removed in the future
     * @param string $databaseName
     * @param string $keyName
     * @return data
     */
    public function db_getHex(string $databaseName, string $keyName): data
    {
        return data::fromHex($this->callNamed(__FUNCTION__,
            array(
                $databaseName,
                $keyName
            )
        ));
    }
    // TODO do it later
    public function shh_post(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function shh_version(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function shh_newIdentity(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function shh_hasIdentity(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function shh_newGroup(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function shh_addToGroup(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function shh_newFilter(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function shh_uninstallFilter(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function shh_getFilterChanges(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function shh_getMessages(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }

    # Management API
    # Admin
    public function admin_addPeer(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function admin_datadir(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function admin_nodeInfo(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function admin_peers(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function admin_setSolc(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function admin_startRPC(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function admin_startWS(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function admin_stopRPC(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function admin_stopWS(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }

    # Debug
    public function debug_backtraceAt(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function debug_blockProfile(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function debug_cpuProfile(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function debug_dumpBlock(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function debug_gcStats(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function debug_getBlockRlp(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function debug_goTrace(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function debug_memStats(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function debug_seedHashsign(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function debug_setBlockProfileRate(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function debug_setHead(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function debug_stacks(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function debug_startCPUProfile(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function debug_startGoTrace(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function debug_stopCPUProfile(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function debug_stopGoTrace(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function debug_traceBlock(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function debug_traceBlockByNumber(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function debug_traceBlockByHash(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function debug_traceBlockFromFile(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function debug_traceTransaction(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function debug_verbosity(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function debug_vmodule(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function debug_writeBlockProfile(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function debug_writeMemProfile(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }

    # Miner
    public function miner_makeDAG(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function miner_setExtra(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function miner_setGasPrice(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function miner_start(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function miner_startAutoDAG(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function miner_stop(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function miner_stopAutoDAG(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }

    # Personal
    // todo where is this method
    public function personal_ecRecover(data $message, data $signature): data
    {
        return data::fromHex($this->callNamed(__FUNCTION__,
            array(
                $message->toJsonCompatible(),
                $signature->toJsonCompatible()
            )
        ));
    }
    public function personal_importRawKey(data $privateKey, string $passPhrase): data
    {
        return data::fromHex($this->callNamed(__FUNCTION__,
            array(
                $privateKey->toJsonCompatible(),
                $passPhrase
            )
        ));
    }
    public function personal_listAccounts(): array
    {
        $result = $this->callNamed(__FUNCTION__, array());

        $rtn = [];
        for ($i = 0; $i < count($result); $i++) {
            $rtn[$i] = data::fromHex($result[$i]);
        }

        return $rtn;
    }
    public function personal_lockAccount(data $account): bool
    {
        return $this->callNamed(__FUNCTION__,
            array($account->toJsonCompatible())
        );
    }
    public function personal_newAccount(string $passPhrase): bool
    {
        return $this->callNamed(__FUNCTION__, array(
            $passPhrase
        ));
    }
    public function personal_unlockAccount(data $account, string $passPhrase, $duration): bool
    {
        if (gettype($duration) !== 'int')
            throw new \InvalidArgumentException('$duration must be int');

        return $this->callNamed(__FUNCTION__,
            array(
                $account->toJsonCompatible(),
                $passPhrase,
                $duration
            )
        );
    }
    public function personal_sendTransaction(transaction $transaction, string $passPhrase): data
    {
        return data::fromHex($this->callNamed(__FUNCTION__,
            array(
                $transaction->toJsonCompatible(),
                $passPhrase
            )
        ));
    }
    public function personal_sign(data $message, data $account, string $passPhrase): data
    {
        return data::fromHex($this->callNamed(__FUNCTION__,
            array(
                $message->toJsonCompatible(),
                $account->toJsonCompatible(),
                $passPhrase
            )
        ));
    }

    # Txpool
    public function txpool_content(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function txpool_inspect(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function txpool_status(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
}