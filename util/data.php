<?php

namespace kabayaki\PHPNekonium;

include_once __DIR__.'\NekoniumType.php';
include_once __DIR__.'\NekUtility.php';

/**
 * This class represents Nekonium data type and is immutable.
 *
 * @package kabayaki\PHPNekonium
 */
class data implements NekoniumType
{
    // In some reason, you cannot set field a instance, it will filled with '0x' data when self::nothing() is called
    private static $nothing;
    private $hex;
    private $bc;

    /**
     * data constructor.
     *
     * $hexData must starts with '0x'.
     * Does not check whether $data is valid hex or not!
     *
     * @param $hexData string Data hex string
     */
    private function __construct(string $hexData)
    {
        if ($hexData === null)
            throw new \InvalidArgumentException('$data cannot be null');

        // Checks whether $data is prefixed with '0x'
        if (strlen($hexData) >= 2 && $hexData[0] === '0' && $hexData[1] === 'x') {
            // It's prefixed
        } else {
            throw new \InvalidArgumentException('$data is not prefixed with \'0x\'');
        }

        $this->hex = $hexData;
    }

    /**
     * Alias for creating a new instance from '0x' prefixed hex string.
     * if '0x' string was given, it will return the data same as {@link nothing()}.
     *
     * @param $hex string A hex string that will be stored on new data as exactly the same
     * @return data New data
     */
    public static function fromHex(string $hex): data
    {
        // It does not check whether $hex starts with '0x' just check if it's length is 2, then return nothing().
        if (strlen($hex) === 2) {
            return self::nothing();
        } else {
            return new data($hex);
        }
    }

    /**
     * Create new data with BCMath string.
     * BCMath string will be converted into hex string and stored on new data.
     * If null is given as $bcmath, it returns the data same as {@link nothing()}.
     *
     * @param string $bcmath An BCMath string that will be converted and stored on new data, set it null to get the same as {@link nothing()}
     * @return data Created data
     */
    public static function fromBCMath(string $bcmath): data
    {
        // Returns nothing = '0x' if $bcmath is null
        if ($bcmath === null) {
            return self::nothing();
        } else {
            return new data('0x' . bchex($bcmath));
        }
    }

    /**
     * Returns data in hex string prefixed with '0x'. In other words, native Nekonium representation of quantity.
     *
     * @return string Data hex string
     */
    public function asHex(): string
    {
        return $this->hex;
    }

    /**
     * Get BCMath equivalent of the data.
     *
     * Since BCMath uses string to perform big integer calculation, this function returns string.
     * This is for php calculation. If you pass this string to Nekonium, it will make exception.
     *
     * If you want to convert BCMath string to data, use {@link fromBCMath()}.
     *
     * @return string An BCMath string of the data
     */
    public function asBCMath(): string
    {
        if ($this->bc === null) {
            $this->bc = hexbc(substr($this->hex, 2));
        }

        return $this->bc;
    }

    /**
     * Just returns {@link asHex()}
     *
     * @return string Data hex string
     */
    public function __toString()
    {
        return $this->asHex();
    }

    /**
     * {@inheritdoc}
     */
    public function toJsonCompatible(): string
    {
        return $this->asHex();
    }

    /**
     * Returns '0x' data. It means there is no data.
     *
     * @return data Returns data contains nothing
     */
    public static function nothing(): data
    {
        if (self::$nothing === null) {
            self::$nothing = self::fromHex('0x');
        }

        return self::$nothing;
    }
}