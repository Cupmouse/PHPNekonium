<?php

/**
 * Converts hex string with <b>no prefix</b> to BCMath compatible string.
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
 * Converts BCMath string to hex string with <b>no prefix</b>.
 *
 * @param $bcmath string BCMath string
 */
function bchex(string $bcmath): string
{
    $result = '';

    // Continues until remaining becomes 0
    $mod = '';
    for ($i = 0; ; $i++) {
        $mod = bcmod($bcmath, '16');

        switch ($mod) {
            case '10': $result = 'A' . $result; break;
            case '11': $result = 'B' . $result; break;
            case '12': $result = 'C' . $result; break;
            case '13': $result = 'D' . $result; break;
            case '14': $result = 'E' . $result; break;
            case '15': $result = 'F' . $result; break;
            default:
                // 0~9 in 10 base is same as 0~9 in 16 base
                // Append $mod on top of $result
                $result = $mod . $result;
                break;
        }

        // $bcmath is not reference so change in this function will not affect variable called from
        $bcmath = bcdiv($bcmath, '16');

        // If $bcmath is 0, ends conversion
        if (bccomp($bcmath, '0') === 0) {
            return $result;
        }
    }
}