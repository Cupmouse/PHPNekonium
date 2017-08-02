<?php

namespace kabayaki\PHPNekonium;

include_once __DIR__.'\NekoniumType.php';
require_once __DIR__.'\NekUtility.php';

/**
 * This class represents Nekonium quantity type and is immutable.
 * Usually used in big number like balances and peer-counts.
 *
 * @package kabayaki\PHPNekonium
 */
class quantity implements NekoniumType
{
    /**
     * @var string Always prefixed with '0x'
     */
    private $hex;
    private $bc;

    /**
     * quantity constructor.
     *
     * $hexQuantity must starts with '0x'.
     * Does not check whether $hexQuantity is valid hex or not (0xHEYHEYITSINVALID will pass)!
     * If it does not, {@link asBCMath} throws {@link \InvalidArgumentException}.
     * '0x' string will cause exception. quantity always need to be a 'value'.
     *
     * @param string $hexQuantity Quantity in hex string
     * @throws \InvalidArgumentException If $hexQuantity is not prefixed with '0x' or just '0x' (data object permits but quantity does not)
     */
    private function __construct(string $hexQuantity)
    {
        if ($hexQuantity === null)
            throw new \InvalidArgumentException('$hexQuantity cannot be null');

        $len = strlen($hexQuantity);

        // Checks whether $hexQuantity is prefixed with '0x'
        if ($len >= 2 && $hexQuantity{0} === '0' && $hexQuantity{1} === 'x') {
            // It's prefixed

            if ($len == 2) {
                throw new \InvalidArgumentException('Quantity does not allow \'0x\'');
            }
        } else {
            throw new \InvalidArgumentException('$hexQuantity is not prefixed with \'0x\'');
        }

        $this->hex = $hexQuantity;
    }

    /**
     * Alias for creating a new instance from '0x' prefixed hex string.
     * Does not check whether $hex is valid hex or not (0xHEYHEYITSINVALID will pass)!
     * Just '0x' string will cause exception. unlike {@link data} object, quantity always need to have a 'value'.
     *
     * @param $hex string A hex string that will be stored on new quantity as exactly the same
     * @return quantity New quantity
     * @throws \InvalidArgumentException If $hex is not prefixed with '0x' or just '0x' (data object permits but quantity does not)
     */
    public static function fromHex(string $hex): quantity
    {
        return new quantity($hex);
    }

    /**
     * Create new quantity with BCMath string.
     * BCMath string will be converted into hex string and stored on new quantity.
     *
     * @param string $bcmath An BCMath string that will be converted and stored on new quantity
     * @return quantity Created quantity
     */
    public static function fromBCMath(string $bcmath): quantity
    {
        return new quantity('0x' . bchex($bcmath));
    }

    /**
     * Get hex string representation of the quantity.
     * Prefixed with '0x'. In other words, native Nekonium representation of quantity.
     *
     * @return string Hex string representation of the quantity
     */
    public function asHex(): string
    {
        return $this->hex;
    }

    /**
     * Get BCMath equivalent of the quantity.
     *
     * Since BCMath uses string to perform big integer calculation, this function returns string.
     * This is for php calculation. If you pass this string to Nekonium, it will make exception.
     *
     * If you want to convert BCMath string to quantity, use {@link fromBCMath()}.
     *
     * @return string BCMath string of the quantity
     */
    public function asBCMath(): string
    {
        if ($this->bc === null) {
            $this->bc = hexbc(substr($this->hex, 2));
        }

        return $this->bc;
    }

    /**
     * toString just returns {@link asHex}.
     *
     * @return string string representation of this quantity
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
}