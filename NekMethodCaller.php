<?php

namespace kabayaki\PHPNekonium;

include_once __DIR__.'\NekClient.php';

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
    public function web3_sha3(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function net_version(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function net_peerCount(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function net_listening(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_protocolVersion(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_syncing(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_coinbase(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_mining(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_hashrate(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_gasPrice(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_accounts(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_blockNumber(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_getBalance(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_getStorageAt(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_getTransactionCount(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_getBlockTransactionCountByHash(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_getBlockTransactionCountByNumber(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_getUncleCountByBlockHash(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_getUncleCountByBlockNumber(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_getCode(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_sign(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_sendTransaction(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_sendRawTransaction(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_call(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_estimateGas(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_getBlockByHash(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_getBlockByNumber(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_getTransactionByHash(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_getTransactionByBlockHashAndIndex(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_getTransactionByBlockNumberAndIndex(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_getTransactionReceipt(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_getUncleByBlockHashAndIndex(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_getUncleByBlockNumberAndIndex(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_getCompilers(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_compileLLL(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_compileSolidity(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_compileSerpent(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
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
    public function eth_getWork(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_submitWork(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function eth_submitHashrate(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function db_putString(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function db_getString(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function db_putHex(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function db_getHex(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
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
    public function personal_ecRecover(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function personal_importRawKey(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function personal_listAccounts(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function personal_lockAccount(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function personal_newAccount(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function personal_unlockAccount(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function personal_sendTransaction(): string
    {
        return $this->callNamed(__FUNCTION__, array());
    }
    public function personal_sign(): string
    {
        return $this->callNamed(__FUNCTION__, array());
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