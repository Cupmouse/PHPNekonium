<?php

namespace kabayaki\PHPNekonium;

include_once __DIR__.'\NekoniumType.php';

class block implements NekoniumType
{
    private $number;
    private $hash;
    private $parentHash;
    private $nonce;
    private $sha3Uncles;
    private $logsBloom;
    private $transactionsRoot;
    private $stateRoot;
    private $receiptsRoot;
    private $miner;
    private $difficulty;
    private $totalDifficulty;
    private $extraData;
    private $size;
    private $gasLimit;
    private $gasUsed;
    private $timestamp;
    private $transactions;
    private $uncles;


    /**
     * block constructor.
     * @param quantity $number The block number of the block
     * @param data $hash The data object of the block hash
     * @param data $parentHash The data object of the parent block's hash
     * @param data $nonce The data object of hash of the generated proof-of-work result
     * @param data $sha3Uncles The data object of SHA3 uncles data in the block
     * @param data $logsBloom The data object of
     * @param data $transactionsRoot
     * @param data $stateRoot
     * @param data $receiptsRoot
     * @param data $miner
     * @param quantity $difficulty
     * @param quantity $totalDifficulty
     * @param data $extraData
     * @param quantity $size
     * @param quantity $gasLimit
     * @param quantity $gasUsed
     * @param quantity $timestamp
     * @param transactions $transactions
     * @param array $uncles
     */
    private function __construct(quantity $number,
                                data $hash,
                                data $parentHash,
                                data $nonce,
                                data $sha3Uncles,
                                data $logsBloom,
                                data $transactionsRoot,
                                data $stateRoot,
                                data $receiptsRoot,
                                data $miner,
                                quantity $difficulty,
                                quantity $totalDifficulty,
                                data $extraData,
                                quantity $size,
                                quantity $gasLimit,
                                quantity $gasUsed,
                                quantity $timestamp,
                                transactions $transactions,
                                array $uncles)
    {
        $this->number = $number;
        $this->hash = $hash;
        $this->parentHash = $parentHash;
        $this->nonce = $nonce;
        $this->sha3Uncles = $sha3Uncles;
        $this->logsBloom = $logsBloom;
        $this->transactionsRoot = $transactionsRoot;
        $this->stateRoot = $stateRoot;
        $this->receiptsRoot = $receiptsRoot;
        $this->miner = $miner;
        $this->difficulty = $difficulty;
        $this->totalDifficulty = $totalDifficulty;
        $this->extraData = $extraData;
        $this->size = $size;
        $this->gasLimit = $gasLimit;
        $this->gasUsed = $gasUsed;
        $this->timestamp = $timestamp;
        $this->transactions = $transactions;
        $this->uncles = $uncles;
    }

    // TODO block uncle or not
    public static function fromASSOC(array $assoc, bool $fullTransaction, bool $isUncle): block
    {
        if (!$isUncle) {
            $transactions = [];
            if ($fullTransaction) {
                // Convert transaction array to array of transactions objects
                for ($i = 0; $i < count($assoc['transactions']); $i++) {
                    $transactions[$i] = transaction::fromASSOC($assoc['transactions'][$i]);
                }

                // Then wrap it with transactions
                $transactions = transactions::transactionArray($transactions);
            } else {
                // Convert transaction hash string array to array of data objects
                for ($i = 0; $i < count($assoc['transactions']); $i++) {
                    $transactions[$i] = data::fromHex($assoc['transactions'][$i]);
                }

                // Then wrap it with transactions
                $transactions = transactions::hashArray($transactions);
            }

            // Convert hex string array to data object array
            $uncles = [];
            for ($i = 0; $i < count($assoc['uncles']); $i++) {
                $uncles[$i] = data::fromHex($assoc['uncles'][$i]);
            }
        }

        return new block(
            quantity::fromHexNullable($assoc['number']),
            data::fromHexNullable($assoc['hash']),
            data::fromHex($assoc['parentHash']),
            data::fromHexNullable($assoc['nonce']),
            data::fromHex($assoc['sha3Uncles']),
            data::fromHexNullable($assoc['logsBloom']),
            data::fromHex($assoc['transactionsRoot']),
            data::fromHex($assoc['stateRoot']),
            data::fromHex($assoc['receiptsRoot']),
            data::fromHex($assoc['miner']),
            quantity::fromHex($assoc['difficulty']),
            quantity::fromHex($assoc['totalDifficulty']),
            data::fromHex($assoc['extraData']),
            quantity::fromHex($assoc['size']),
            quantity::fromHex($assoc['gasLimit']),
            quantity::fromHex($assoc['gasUsed']),
            quantity::fromHex($assoc['timestamp']),
            $transactions,
            $uncles
        );
    }

    /**
     * @return quantity
     */
    public function getNumber(): quantity
    {
        return $this->number;
    }

    /**
     * @return data
     */
    public function getHash(): data
    {
        return $this->hash;
    }

    /**
     * @return data
     */
    public function getParentHash(): data
    {
        return $this->parentHash;
    }

    /**
     * @return data
     */
    public function getNonce(): data
    {
        return $this->nonce;
    }

    /**
     * @return data
     */
    public function getSha3Uncles(): data
    {
        return $this->sha3Uncles;
    }

    /**
     * @return data
     */
    public function getLogsBloom(): data
    {
        return $this->logsBloom;
    }

    /**
     * @return data
     */
    public function getTransactionsRoot(): data
    {
        return $this->transactionsRoot;
    }

    /**
     * @return data
     */
    public function getStateRoot(): data
    {
        return $this->stateRoot;
    }

    /**
     * @return data
     */
    public function getReceiptsRoot(): data
    {
        return $this->receiptsRoot;
    }

    /**
     * @return data
     */
    public function getMiner(): data
    {
        return $this->miner;
    }

    /**
     * @return quantity
     */
    public function getDifficulty(): quantity
    {
        return $this->difficulty;
    }

    /**
     * @return quantity
     */
    public function getTotalDifficulty(): quantity
    {
        return $this->totalDifficulty;
    }

    /**
     * @return data
     */
    public function getExtraData(): data
    {
        return $this->extraData;
    }

    /**
     * @return quantity
     */
    public function getSize(): quantity
    {
        return $this->size;
    }

    /**
     * @return quantity
     */
    public function getGasLimit(): quantity
    {
        return $this->gasLimit;
    }

    /**
     * @return quantity
     */
    public function getGasUsed(): quantity
    {
        return $this->gasUsed;
    }

    /**
     * @return quantity
     */
    public function getTimestamp(): quantity
    {
        return $this->timestamp;
    }

    /**
     * @return transactions
     */
    public function getTransactions(): transactions
    {
        return $this->transactions;
    }

    /**
     * @return array
     */
    public function getUncles(): array
    {
        return $this->uncles;
    }

    /**
     * {@inheritdoc}
     */
    public function toJsonCompatible(): mixed
    {
        throw new \RuntimeException('Not implemented and we are not looking forward to implement it');
        // TODO: Implement toJsonCompatible() method.
    }
}