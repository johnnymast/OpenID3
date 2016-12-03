<?php
namespace OpenID3\Tests\Reader;

use OpenID3\MediaFile;
use OpenID3\Reader as Reader;

class ReaderTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function setUp()
    {
        set_error_handler([$this, 'customErrorHandler']);
    }

    /**
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     */
    public function customErrorHandler($errno, $errstr, $errfile, $errline)
    {
        throw new \InvalidArgumentException(
            sprintf(
                'Missing argument. %s %s %s %s',
                $errno,
                $errstr,
                $errfile,
                $errline
            )
        );
    }

    /**
     * Test that Reader will throw an exception if no MediaFile
     * Object is being passed.
     *
     * @expectedException \InvalidArgumentException
     */
    public function testNoMediaFileNameShouldThrowException()
    {
        new Reader;
    }

    /**
     * Test that Reader will throw InvalidArgumentException if
     * no valid argument has been passed (Expecting MediaFile)
     *
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArgumentShouldThrowException()
    {
        new Reader(new \stdClass());
    }

    /**
     * Test that Reader::parse will throw MediaFileException if
     * the MediaFile is invalid.
     *
     * @expectedException OpenID3\Exceptions\MediaFileException
     * @covers Reader::parse
     */
    public function testParserWithInvalidMediaFileThrowsException()
    {
        $object = new Reader(new MediaFile(TEST_ASSETS_DIR . '/empty.mp3'));
        $class = new \ReflectionClass($object);
        $reflection_property = $class->getProperty('file');
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($object, null);

        $object->parse();
    }

    /**
     * Test that reader will throw MediaFileException if the
     * MediaFile is not readable.
     *
     * @expectedException OpenID3\Exceptions\MediaFileException
     * @covers Reader::parse
     */
    public function testParseWithNonReadableMediaFileShouldThrowException()
    {
        $stub = $this->getMockBuilder(MediaFile::class)
            ->setConstructorArgs([TEST_ASSETS_DIR . '//non_readable.mp3'])
            ->getMock();

        $stub->method('isReadable')
            ->willReturn(false);

        $stub->method('getFileName')
            ->willReturn(TEST_ASSETS_DIR . '//non_readable.mp3');

        $reader = new Reader($stub);

        $reader->parse();
    }

    /**
     * Test that if no parser could work with this MediaFile an
     * MediaFileException will be thrown.
     *
     * @expectedException OpenID3\Exceptions\MediaFileException
     * @covers Reader::parse
     */
    public function testParseWithoutNonParseableMediaFileThrowsAnException()
    {
        $reader = new Reader(
            new MediaFile(TEST_ASSETS_DIR.'/no_identifiable.mp3')
        );
        $reader->parse();
    }
}
