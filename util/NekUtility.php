<?php

/**
 * Converts hex string to BCMath compatible string.
 *
 * @param $hex string Hex data
 * @return string BCMath compatible string of $hex
 */
function hexbc($hex): string
{
    // TODO exception on invalid hex, just use ascii code to calc

    if (is_null($hex)) {
        return null;
    }

    $result = '0';
    $digits = strlen($hex);

    for ($i = 0; $i < $digits; $i++) {
        switch ($hex{$i}) {
            case 'A':
            case 'a': $num = 10; break;
            case 'B':
            case 'b': $num = 11; break;
            case 'C':
            case 'c': $num = 12; break;
            case 'D':
            case 'd': $num = 13; break;
            case 'E':
            case 'e': $num = 14; break;
            case 'F':
            case 'f': $num = 15; break;
            default:
                // 0~9 are 10 base number, so ignore
                $num = $hex{$i};
                break;
        }

        $result = bcadd($result, bcmul($num, bcpow(16, $digits - $i - 1)));
    }

    return $result;
}

/**
 * Converts BCMath string to hex string
 *
 * @param $bcmath string BCMath string
 */
function bchex(string $bcmath) {

}