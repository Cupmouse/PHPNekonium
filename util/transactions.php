<?php

namespace kabayaki\PHPNekonium;

include_once __DIR__.'\NekoniumType.php';

/**
 * transactions object holds list of {@link transaction} or {@link data} of hash of transaction.
 * That means if {@link isHashOnly()} returns true, {@link get()} returns an array of data objects,
 * and the otherwise an array of transaction objects.
 *
 * @package kabayaki\PHPNekonium
 */
class transactions
{
    private $hashOnly;
    private $transactions;

    /**
     * transactions constructor.
     * @param $hashOnly
     * @param $transactions
     */
    private function __construct(bool $hashOnly, array $transactions)
    {
        $this->hashOnly = $hashOnly;
        $this->transactions = $transactions;
    }

    /**
     * Create new transactions instance with specified data object of hash array.
     *
     * @param array $hashes An array of data object of hash that will be contained in the new transactions object
     * @return transactions A transactions object contains list of the data objects of hashes
     */
    public static function hashArray(array $hashes): transactions
    {
        // Each element of $hashes must be data object
        foreach ($hashes as $hash) {
            if (!is_a($hash, 'kabayaki\PHPNekonium\data')) {
                throw new \InvalidArgumentException('$hashes must be array of kabayaki\PHPNekonium\data object');
            }
        }

        return new transactions(true, $hashes);
    }

    /**
     * Create new transactions instance with specified data objects of hashes.
     *
     * @param data[] ...$hashes data objects of hashes that will be contained in the new transactions object
     * @return transactions A transactions object contains list of the data objects of hashes
     */
    public static function hashes(data... $hashes): transactions
    {
        return new transactions(true, $hashes);
    }

    /**
     * Create new transactions instance with specified transaction object array.
     *
     * @param array $transactions An array of transaction objects that will be in new transactions object
     * @return transactions A transactions object contains list of the transaction objects
     * @throws \InvalidArgumentException If $transactions contains non transaction object
     */
    public static function transactionArray(array $transactions): transactions
    {
        // $transactions must contain transaction objects, check if it does.
        foreach ($transactions as $transaction) {
            if (!is_a($transaction, 'kabayaki\PHPNekonium\transaction')) {
                throw new \InvalidArgumentException('$transactions must be array of kabayaki\PHPNekonium\transaction object');
            }
        }

        return new transactions(false, $transactions);
    }

    /**
     * Create new transactions instance with specified transaction objects.
     *
     * @param transaction[] ...$transactions transaction objects that will be contained in the new transaction object
     * @return transactions A transaction object contains list of the transaction objects
     */
    public static function transactions(transaction... $transactions): transactions
    {
        return new transactions(false, $transactions);
    }

    /**
     * @return bool Do this transactions contains just hash only or not, true when data objects of hash, false on transaction objects.
     */
    public function isHashOnly(): bool
    {
        return $this->hashOnly;
    }

    /**
     * @return array An array of data objects if {@link isHashOnly()} is true, array of transaction objects on false.
     */
    public function get(): array
    {
        return $this->transactions;
    }
}