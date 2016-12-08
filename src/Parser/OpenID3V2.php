<?php
namespace OpenID3\Parser;

use OpenID3\BinaryReader;
use OpenID3\Frame;
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

    protected $header = [];

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
        /*
          ** ID3v2/file identifier   "ID3"
          ** ID3v2 version           $03 00
          ** ID3v2 flags             %abc00000
          ** ID3v2 size              4 * %0xxxxxxx
          */
        $this->file->rewind();
        $this->file->clearMap()
            ->addMap('TAG', BinaryReader::TEXT, 3)
            ->addMap('VERSION', BinaryReader::TEXT, 2)
            ->addMap('FLAGS', BinaryReader::TEXT, 1)
            ->addMap('SIZE', BinaryReader::INT, 4);

        $this->file->setMaxPos(10);
        $header= $this->file->read();
        if (isset($header['TAG']) == true) {
            if ($header['TAG'] == 'ID3') {
                $this->header = $header;
                return true;
            }
        }
        return false;
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

    private function getTags()
    {
        return ['TALB', 'TBPM', 'TCOM', 'TCON', 'TCOP', 'TDAT', 'TDLY', 'TENC',
            'TEXT', 'TFLT', 'TIME', 'TIT1', 'TIT2', 'TIT3', 'TKEY', 'TLAN',
            'TLEN', 'TMED', 'TOAL', 'TOFN', 'TOLY', 'TOPE', 'TORY', 'TOWN',
            'TPE1', 'TPE2', 'TPE3', 'TPE4', 'TPOS', 'TPUB', 'TRCK', 'TRDA',
            'TRSN', 'TRSO', 'TSIZ', 'TSRC', 'TSSE', 'TYER', 'TDRC'];
    }

    public function parse()
    {

        // TODO extended header
        // TODO handle corrupt headers

        $this->file->clearMap()
            ->addMap('FRAMEID', BinaryReader::TEXT, 4)
            ->addMap('SIZE', BinaryReader::INT, 4)
            ->addMap('FLAGS', BinaryReader::TEXT, 2)
            ->addMap('BODY', BinaryReader::VALUE_OF, 'SIZE');


        $this->file->setMaxPos($this->header['SIZE']);

        $alltags = $this->getTags();
        $frames = [];
        while (($tag = $this->file->read())) {
            if (!in_array($tag['FRAMEID'], $alltags)) {
                continue;
            }

            if ($tag['FRAMEID'][0] === "T") {
                if (intval(bin2hex($tag['BODY']), 16) === 1) {
                    $tag['BODY'] = mb_convert_encoding(substr($tag['BODY'], 1), 'UTF-8', 'UTF-16');
                }
            }

            if ($tag['FRAMEID'] == 'APIC') {
                $type = 'png';
              //  $tag['BODY'] = $base64 = 'data:image/' . $type . ';base64,' . base64_encode($tag['BODY']);
            }

            $frames[] = $tag;
        };


        $ident = 'id3v2' . ord($this->header['VERSION'][0]);//.ord($info['VERSION'][1]);

        $tags = [];
        $header = [];
        $header['majorversion'] = ord($this->header['VERSION'][0]);
        $header['minorversion'] = isset($this->header['VERSION'][1]) ? ord($this->header['VERSION'][1]) : 0;
        $header['tags'] = $frames;

        $tags[$ident] = $tags[$ident . '_raw'] = $header;
        return $tags;
    }
}
