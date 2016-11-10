<?php
namespace OpenID3;
use OpenID3\Adapter\AdapterInterface;

class Reader
{

    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * @var ParserInterface
     */
    protected $parser = null;

    /**
     * Reader constructor.
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    public function parse()
    {
        if ($this->getAdapter()->initialize()) {
            echo 'ja';
            if (($parserClass = $this->getAdapter()->identifyParser())) {
                $this->parser = new $parserClass($this->getAdapter());
                echo '-->'.$parserClass;
            } else {
                // Unknown ID3 ... Throw exception
            }
            $this->getAdapter()->terminate();
        }

    }

}