<?php
namespace OpenID3;
use OpenID3\exceptions\OpenID3FileException;
use OpenID3\Parser\OpenID3V1 as OpenID3V1;
use OpenID3\Parser\OpenID3V23 as OpenID3V23;

class Reader
{

    /**
     * @var SplFileObject
     */
    protected $file;

    /**
     * @var string
     */
    protected $filename = '';

    /**
     * @var ParserInterface
     */
    protected $parser = null;

    /**
     * Reader constructor.
     * @param string $filename
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return bool
     * @throws OpenID3FileException
     */
    public function parse()
    {
        $this->file = new \SplFileObject($this->filename);

        if ($this->file->isReadable() == false)
            throw new OpenID3FileException($this->filename.' is not readable');

        $found = false;

        foreach(['OpenID3\Parser\OpenID3V2', 'OpenID3\Parser\OpenID3V1'] as $class) {
            $parser = new $class($this->file);
            if ($parser->has_tag() == true) {
                $this->parser = $parser;
                $found = true;
                break;
            }
        }
        if ($found == true) {
           $info = $parser->parse();
           return $info;
        } else {
            throw new OpenID3FileException('We could not identify '.$this->filename);
        }
        return false;
    }

}