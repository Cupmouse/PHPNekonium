<?php

namespace kabayaki\PHPNekonium;



// javadoc
class transactionReceipt implements NekoniumType
{
    private $transactionHash;
    private $transactionIndex;
    private $blockHash;
    private $blockNumber;
    private $cumulativeGasUsed;
    private $gasUsed;
    private $contractAddress;
    private $logs;

    /**
     * transactionReceipt constructor.
     * @param $transactionHash
     * @param $transactionIndex
     * @param $blockHash
     * @param $blockNumber
     * @param $cumulativeGasUsed
     * @param $gasUsed
     * @param $contractAddress
     * @param $logs
     */
    private function __construct(data $transactionHash,
                                quantity $transactionIndex,
                                data $blockHash,
                                quantity $blockNumber,
                                quantity $cumulativeGasUsed,
                                quantity $gasUsed,
                                data $contractAddress,
                                array $logs) // TODO what is log array???
    {
        $this->transactionHash = $transactionHash;
        $this->transactionIndex = $transactionIndex;
        $this->blockHash = $blockHash;
        $this->blockNumber = $blockNumber;
        $this->cumulativeGasUsed = $cumulativeGasUsed;
        $this->gasUsed = $gasUsed;
        $this->contractAddress = $contractAddress;
        $this->logs = $logs;
    }

    /**
     * @return data
     */
    public function getTransactionHash(): data
    {
        return $this->transactionHash;
    }

    /**
     * @return quantity
     */
    public function getTransactionIndex(): quantity
    {
        return $this->transactionIndex;
    }

    /**
     * @return data
     */
    public function getBlockHash(): data
    {
        return $this->blockHash;
    }

    /**
     * @return quantity
     */
    public function getBlockNumber(): quantity
    {
        return $this->blockNumber;
    }

    /**
     * @return quantity
     */
    public function getCumulativeGasUsed(): quantity
    {
        return $this->cumulativeGasUsed;
    }

    /**
     * @return quantity
     */
    public function getGasUsed(): quantity
    {
        return $this->gasUsed;
    }

    /**
     * @return data
     */
    public function getContractAddress(): data
    {
        return $this->contractAddress;
    }

    /**
     * @return array
     */
    public function getLogs(): array
    {
        return $this->logs;
    }

    public static function fromASSOC(array $assoc): transactionReceipt
    {
        return new transactionReceipt(
            data::fromHex($assoc['transactionHash']),
            quantity::fromHex($assoc['transactionIndex']),
            data::fromHex($assoc['blockHash']),
            quantity::fromHex($assoc['blockNumber']),
            quantity::fromHex($assoc['cumulativeGasUsed']),
            quantity::fromHex($assoc['gasUsed']),
            data::fromHexNullable($assoc['contractAddress']),
            $assoc['logs']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function toJsonCompatible()
    {
        // TODO: Implement toJsonCompatible() method.
        // TODO SAME WITH Transactions
    }
}