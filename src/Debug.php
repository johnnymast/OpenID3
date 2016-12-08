<?php
namespace OpenID3;


class Debug
{

    /**
     * @param string $string
     * @return array
     */
    public static function hexDump($string = '')
    {
        $spacing = 10;
        $maxwidth = 10;

        $sets = $lines = [];

        for ($i = 0; $i < strlen($string); $i += $maxwidth+1) {
            $sets[] = substr($string, $i, $maxwidth);
        }

        foreach ($sets as $set) {
            $line = '';

            for ($i = 0; $i < strlen($set); $i++) {
                $line .= bin2hex($set[$i]) . ' ';
            }
            $line .= str_repeat(' ', $spacing);

            for ($i = 0; $i < strlen($set); $i++) {
                $line .= $set[$i] ;
            }
            $lines[] = $line;
        }
        return implode("\n", $lines);
    }

}