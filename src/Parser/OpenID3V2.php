<?php
namespace OpenID3\Parser;

use OpenID3\Debug;
use OpenID3\MediaFile;

class OpenID3V2 implements ParserInterface
{
    const TAG22 = '2.2';
    const TAG23 = '2.3';
    const TAG24 = '2.4';
    const TAG_UNKNOWN = 'Unknown';

    /**
     * @var MediaFile
     */
    protected $file = null;

    /**
     * @var string
     */
    protected $tag_version = self::TAG_UNKNOWN;

    /**
     * OpenID3V23 constructor.
     * @param MediaFile $file
     */
    public function __construct(MediaFile $file)
    {
        $this->file = $file;
    }

    /**
     * @return bool
     */
    public function hasTag()
    {
        $result = false;
        if ($this->file) {
            $this->file->fseek(0, SEEK_SET);
            $tag = $this->file->fread(10);
            if (substr($tag, 0, 3) == 'ID3') {
                $result = true;
            }
        }
        return $result;
    }

    /**
     * Return the tag version.
     *
     * @return string
     */
    public function version()
    {
        return $this->tag_version;
    }

    public function parse()
    {
        $this->file->fseek(0, SEEK_SET);
        $header = $this->file->fread(10);

        /*
        ** ID3v2/file identifier   "ID3"
        ** ID3v2 version           $03 00
        ** ID3v2 flags             %abc00000
        ** ID3v2 size              4 * %0xxxxxxx
        */
        $header_info = [
            'TAG' => [0, 3], // string
            'VERSION' => [3, 2], // $ =  hex
            'FLAGS' => [5, 1], // %x is used to indicate a bit with unknown content.
            'SIZE' => [6, 4]  // dec
        ];

        $info = [];
        foreach ($header_info as $key => $positions) {
            $length = $positions[1];
            $info[$key] = trim(substr($header, $positions[0], $length));
            $info[$key] = trim($info[$key]);

            echo "$key => " . (strlen($info[$key]) + 1) . "\n";
            if ($key == 'VERSION') {
                /**
                 * echo 'Major: '.Debug::hexDump($info['VERSION'][0]);
                 * echo 'Minor: '.Debug::hexDump($info['VERSION'][1]);
                 */

                $info[$key] = $info[$key];
            } elseif ($key == 'SIZE') {
              $info[$key] = intval(bin2hex($info[$key]), 16);
            } elseif ($key == 'FLAGS') {
                $info[$key] = $info[$key];
            } elseif ($key == 'TAG') {
                continue;
            }
        }

        $ident = 'id3v2'.ord($info['VERSION'][0]);//.ord($info['VERSION'][1]);

        $tags = [];
        $header = [] ;
        $header['majorversion'] = ord($info['VERSION'][0]);
        $header['minorversion'] = isset($info['VERSION'][1]) ?  ord($info['VERSION'][1]) : 0;


        $tags[$ident] = $tags[$ident.'_raw'] = $header;
       // $tags[$ident]['Genre'] = Genres::getGenre($info['Genre']);


     //   echo '>'.Debug::hexDump($info['SIZE']).'<';
        //rint_r($info['VERSION'][1]);
        print_r($tags);
    }
}
