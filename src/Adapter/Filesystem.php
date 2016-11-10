<?php
namespace OpenID3\Adapter;

class Filesystem extends AdapterAbstract implements AdapterInterface
{
    /**
     * @var string
     */
    protected $filename;

    /**
     * @var mixed
     */
    protected $file_pointer;

    /**
     * @var bool
     */
    protected $did_initialize = false;

    /**
     * Filesystem constructor.
     * @param string $filename
     */
    public function __construct($filename = '')
    {
        $this->filename = $filename;
    }

    /**
     * @return bool
     */
    public function did_initialize()
    {
        return $this->did_initialize;
    }

    /**
     * Initialize the file
     * @return bool
     */
    public function initialize()
    {
        $this->file_pointer = fopen($this->filename, "rb+");

        if ($this->file_pointer) {
            $this->did_initialize = true;
        }
        return ($this->file_pointer !== false);
    }

    /**
     *
     */
    public function terminate()
    {
        if ($this->file_pointer) {
            fclose($this->file_pointer);
        }
        $this->did_initialize = false;
    }

    /**
     * @param int $size
     * @return string
     */
    public function read($size = 0)
    {
        if ($size > 0) {
            return fread($this->file_pointer, $size);
        }
    }
}