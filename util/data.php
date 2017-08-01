<?php

namespace kabayaki\PHPNekonium;


class data
{
    private $data;

    /**
     * data constructor.
     * Does not check whether $data is valid hex or not!
     *
     * @param $data string Data hex string
     */
    public function __construct($data)
    {
        if ($data === null)
            throw new \InvalidArgumentException('$data cannot be null');
        if ($data{0} === '0' && $data{1} === 'x') {
            // It's prefixed
        } else {
            throw new \InvalidArgumentException('$data is not prefixed with \'0x\'');
        }

        $this->data = $data;
    }

    /**
     * Returns data in hex string prefixed with '0x'.
     *
     * @return string Data hex string
     */
    public function asHex(): string
    {
        return $this->data;
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
}