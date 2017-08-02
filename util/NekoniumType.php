<?php

namespace kabayaki\PHPNekonium;


/**
 * Interface NekoniumType represents Nekonium type.
 *
 * @package kabayaki\PHPNekonium
 */
interface NekoniumType
{
    /**
     * Convert this type to string or other json_decode friendly type
     *
     * @return mixed Converted value
     */
    public function toJsonCompatible();
}