<?php
namespace OpenID3;

use OpenID3\Parser\ParserInterface;
use OpenID3\Exceptions\MediaFileException;

class Reader
{

    /**
     * @var MediaFile
     */
    protected $file;

    /**
     * @var ParserInterface
     */
    protected $parser = null;

    /**
     * Reader constructor.
     * @param MediaFile $mediaFile
     */
    public function __construct(MediaFile $mediaFile)
    {
        $this->file = $mediaFile;
        $this->filename = $mediaFile->getFilename();
    }

    /**
     * @return mixed
     * @throws MediaFileException
     */
    public function parse()
    {
        if (!$this->file) {
            throw new MediaFileException('invalid media file');
        }

        if ($this->file == false) {
            throw new MediaFileException($this->file->getFilename() . ' is not readable');
        }

        $found = false;

        foreach (['OpenID3\Parser\OpenID3V2', 'OpenID3\Parser\OpenID3V1'] as $class) {
            /** @var ParserInterface $parser */
            $parser = new $class($this->file);
            if ($parser->hasTag() == true) {
                $this->parser = $parser;
                $found = true;
                break;
            }
        }
        if ($found == true) {
            /** @var ParserInterface $parser */
            $tags = $parser->parse();
            $this->file->setTags($tags);
            $this->file->setParsed(true);
            return $this->file;
        }
        throw new MediaFileException('We could not identify ' . $this->file->getFilename());
    }
}
