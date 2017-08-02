<?php

namespace kabayaki\PHPNekonium;

include_once __DIR__.'\NekoniumType.php';
// TODO php doc
class transaction implements NekoniumType
{
    private $hash;
    private $nonce;
    private $blockHash;
    private $blockNumber;
    private $transactionIndex;
    private $from;
    private $to;
    private $value;
    private $gasPrice;
    private $gas;
    private $input;

    /**
     * transaction constructor. Use static functions to avoid mistake like, not input $to with nuko sending transaction.
     * It will not check parameter validness.
     *
     * @param data|null $hash The data object of the transaction hash
     * @param $nonce quantity For detecting multiple transactions with the same nonce and drop it
     * @param data|null $blockHash The data object of the hash of the block in which the transaction included
     * @param quantity|null $blockNumber The quantity object of the block number of the block in which the transaction included
     * @param quantity|null $transactionIndex The quantity object of the transaction index
     * @param $from data An address value send from
     * @param $to data An address value send to
     * @param $value quantity Value sent in the transaction
     * @param $gasPrice quantity How much nuko costs per gas
     * @param $gas quantity How much gas is provided for the transaction
     * @param data|null $input Contract or contract method call data
     */
    private function __construct(data $hash = null,
                                 quantity $nonce = null,
                                 data $blockHash = null,
                                 quantity $blockNumber = null,
                                 quantity $transactionIndex = null,
                                 data $from,
                                 data $to = null,
                                 quantity $value = null,
                                 quantity $gasPrice = null,
                                 quantity $gas = null,
                                 data $input = null)
    {
        // No validation for now
        $this->hash = $hash;
        $this->nonce = $nonce;
        $this->blockHash = $blockHash;
        $this->blockNumber = $blockNumber;
        $this->transactionIndex = $transactionIndex;
        $this->from = $from;
        $this->to = $to;
        $this->value = $value;
        $this->gasPrice = $gasPrice;
        $this->gas = $gas;
        $this->input = $input;
    }

    /**
     * Creates new nuko sending transaction. <b>$from, $to and $value cannot be null</b>.
     *
     * @param data $from An address value send from
     * @param data $to An address value send to
     * @param quantity $value Value sent in the transaction
     * @param quantity|null $gas How much gas is provided for the transaction
     * @param quantity|null $gasPrice How much nuko costs per gas
     * @param data|null $input Maybe message or some identifier, can be null
     * @param quantity|null $nonce For detecting multiple transactions with the same nonce and drop it
     * @return transaction A new transaction instance of provided parameters which represents nuko sending
     */
    public static function nukoSending(data $from,
                                          data $to,
                                          quantity $value,
                                          quantity $gas = null,
                                          quantity $gasPrice = null,
                                          data $input = null,
                                          quantity $nonce = null)
    {
        if ($from === null) throw new \InvalidArgumentException('$from cannot be null');
        if ($to === null) throw new \InvalidArgumentException('$to cannot be null');
        if ($value === null) throw new \InvalidArgumentException('$value cannot be null');

        return new transaction(null, $nonce, null, null, null, $from, $to, $value, $gasPrice, $gas, $input);
    }

    /**
     * Creates new contract creation transaction. <b>$from and $data cannot be null</b>.
     *
     * @param data $from An address contract creation executed by
     * @param data $input Contract data to be created
     * @param quantity|null $gas How much gas is provided for the transaction
     * @param quantity|null $gasPrice How much nuko costs per gas
     * @param quantity|null $value Value sent in the transaction, it will be sent to the created new contract address // TODO is it?
     * @param quantity|null $nonce For detecting multiple transactions with the same nonce and drop it
     * @return transaction A new transaction instance of provided parameters which represents contract creation
     */
    public static function contractCreation(data $from,
                                            data $input,
                                            quantity $gas = null,
                                            quantity $gasPrice = null,
                                            quantity $value = null,
                                            quantity $nonce = null)
    {
        if ($from === null) throw new \InvalidArgumentException('$from cannot be null');
        if ($input === null) throw new \InvalidArgumentException('$data cannot be null');

        return new transaction(null, $nonce, null, null, null, $from, null, $value, $gasPrice, $gas, $input);
    }

    /**
     * @param data $from An address contract the method call executed from
     * @param data $to An contract address which the method will be executed
     * @param data $input An contract method call data
     * @param quantity|null $gas How much gas is provided for the transaction
     * @param quantity|null $gasPrice How much nuko costs per gas
     * @param quantity|null $value Value send in the transaction, it will be send to the contract address
     * @param quantity|null $nonce For detecting multiple transactions with the same nonce and drop it
     * @return transaction A new transaction instance of provided parameters which represents the contract method call
     */
    public static function contractMethodCall(data $from,
                                              data $to,
                                              data $input,
                                              quantity $gas = null,
                                              quantity $gasPrice = null,
                                              quantity $value = null,
                                              quantity $nonce = null)
    {
        if ($from === null) throw new \InvalidArgumentException('$from cannot be null');
        if ($to === null) throw new \InvalidArgumentException('$to cannot be null');
        if ($input === null) throw new \InvalidArgumentException('$data cannot be null');

        return new transaction(null, $nonce, null, null, null, $from, $to, $value, $gasPrice, $gas, $input);
    }

    public static function fromASSOC($assoc)
    {
        return new transaction(
            data::fromHex($assoc['hash']),
            quantity::fromHex($assoc['nonce']),
            data::fromHex($assoc['blockHash']),
            quantity::fromHex($assoc['blockNumber']),
            quantity::fromHex($assoc['transactionIndex']),
            data::fromHex($assoc['from']),
            data::fromHex($assoc['to']),
            quantity::fromHex($assoc['value']),
            quantity::fromHex($assoc['gasPrice']),
            quantity::fromHex($assoc['gas']),
            data::fromHex($assoc['input'])
        );
    }

    /**
     * @return data An address the transaction sent from
     */
    public function getFrom(): data
    {
        return $this->from;
    }

    /**
     * @return data An address the transaction sent to
     */
    public function getTo(): data
    {
        return $this->to;
    }

    /**
     * @return quantity How much gas is provided for the transaction
     */
    public function getGas(): quantity
    {
        return $this->gas;
    }

    /**
     * @return quantity How much nuko costs per gas
     */
    public function getGasPrice(): quantity
    {
        return $this->gasPrice;
    }

    /**
     * @return quantity Value sent in the transaction
     */
    public function getValue(): quantity
    {
        return $this->value;
    }

    /**
     * @return data Data in the transaction
     */
    public function getData(): data
    {
        return $this->data;
    }

    /**
     * @return quantity Number used once, for detecting multiple transactions with the same nonce,
     *          so server can drop duplicating transactions
     */
    public function getNonce(): quantity
    {
        return $this->nonce;
    }

    /**
     * {@inheritdoc}
     */
    public function toJsonCompatible(): array
    {
        $rtn = array(
            'from'=>$this->from->toJsonCompatible(),
        );

        if ($this->to !== null) $rtn['to'] = $this->to->toJsonCompatible();
        if ($this->gas !== null) $rtn['gas'] = $this->gas->toJsonCompatible();
        if ($this->gasPrice !== null) $rtn['gasPrice'] = $this->gasPrice->toJsonCompatible();
        if ($this->value !== null) $rtn['value'] = $this->value->toJsonCompatible();
        if ($this->data !== null) $rtn['data'] = $this->data->toJsonCompatible();
        if ($this->nonce !== null) $rtn['nonce'] = $this->nonce->toJsonCompatible();

        return $rtn;
    }
}