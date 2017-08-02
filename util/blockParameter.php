<?php

namespace kabayaki\PHPNekonium;

include_once __DIR__.'\NekoniumType.php';

class blockParameter implements NekoniumType
{
    private static $LATEST;
    private static $EARLIEST;
    private static $PENDING;

    private $blockParameter;

    /**
     * blockParameter constructor.
     * Zero and positive value to set block number or negative value to set latest, earliest, pending.
     * Latter three are defined int -1, -2, -3 accordingly.
     *
     * @param quantity|int $blockParameter quantity of block number or int value latest, earliest, pending
     */
    private function __construct($blockParameter)
    {
        $this->blockParameter = $blockParameter;
    }

    /**
     * Create blockParameter instance represents block number.
     *
     * @param quantity $blockNumber A quantity object contains block number
     * @return blockParameter A new blockParameter
     */
    public static function blockNumber(quantity $blockNumber)
    {
        return new blockParameter($blockNumber);
    }

    /**
     * Return blockParameter instance represents 'latest'
     *
     * @return blockParameter A blockParameter represents 'latest'
     */
    public static function latest()
    {
        if (self::$LATEST === null) {
            self::$LATEST = new blockParameter(-1);
        }

        return self::$LATEST;
    }

    /**
     * Return blockParameter instance represents 'earliest'
     *
     * @return blockParameter A blockParameter represents 'earliest'
     */
    public static function earliest()
    {
        if (self::$EARLIEST === null) {
            self::$EARLIEST = new blockParameter(-2);
        }

        return self::$EARLIEST;
    }

    /**
     * Return blockParameter instance represents 'pending'
     *
     * @return blockParameter A blockParameter represents 'pending'
     */
    public static function pending()
    {
        if (self::$PENDING === null) {
            self::$PENDING = new blockParameter(-3);
        }

        return self::$PENDING;
    }

    /**
     * {@inheritdoc}
     */
    public function toJsonCompatible()
    {
        // Check if blockParameter is quantity then it is block number
        if (is_a($this->blockParameter, 'kabayaki\PHPNekonium\quantity')) {
            // It is block number

            return $this->blockParameter;
        } else {
            // It is tag

            switch ($this->blockParameter) {
                case -1:
                    return 'latest';
                case -2:
                    return 'earliest';
                case -3:
                    return 'pending';
                default:
                    throw new \InvalidArgumentException("Unknown tag : $this->blockParameter");
            }
        }
    }
}