<?php

namespace eWar\Framework\Utils;

/**
 * Class TextHelper
 * @package eWar\Framework\Utils
 */
class TextHelper
{
    /**
     * stringToUrl
     *
     * @param string $string
     *
     * @return string
     */
    public static function stringToUrl(string $string) : string
    {
        $output = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        $output = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $output);
        $output = strtolower(trim($output, '-'));
        $output = preg_replace("/[\/_|+ -]+/", '-', $output);

        return $output;
    }
}
