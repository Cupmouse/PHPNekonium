<?php

namespace kabayaki\PHPNekonium;

require_once 'NekUtility.php';

/**
 * This class represents quantity.
 * Usually used in big number like balances and peer-counts.
 *
 * @package kabayaki\PHPNekonium
 */
class quantity
{
    /**
     * @var string Always prefixed with '0x'
     */
    private $hex;
    private $bc;

    /**
     * quantity constructor.
     * Does not check whether $hexQuantity is valid hex or not!
     * If it does not, {@link asBCMath} throws {@link \InvalidArgumentException}.
     *
     * @param string $hexQuantity Quantity in hex string
     */
    public function __construct(string $hexQuantity)
    {
        if ($hexQuantity === null)
            throw new \InvalidArgumentException('$hexQuantity cannot be null');

        // Checks whether $hexQuantity is prefixed with '0x'

        $this->hex = $hexQuantity;
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
}