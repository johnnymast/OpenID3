<?php
namespace OpenID3\Adapter;


class AdapterAbstract
{
    const ID3v1   = "TAG";
    const ID3v23  = "ID3";
    const ID3vUnk = "Unknown";

    /**
     * Identify the parse we will need for this file.
     * If no valid ID3 header was found false will be returned.
     *
     * @return bool|string
     */
    public function identifyParser() {
        if ($this->did_initialize() == true) {
            $header = $this->read(10);
            if ($header) {
                if (substr($header, 0, 3) == self::ID3v1) {
                    return 'OpenID3\Parser\OpenID3V1';
                } elseif (substr($header, 0, 3) == self::ID3v23){
                    return 'OpenID3\Parser\OpenID3V23';
                }
            }
        }
        return false;
    }
}