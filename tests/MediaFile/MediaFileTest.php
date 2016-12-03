<?php
namespace OpenID3\Tests\MediaFile;

use OpenID3\MediaFile;

class MediaFileTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test that a RuntimeException will be thrown if there
     * is no file passed to the MediaFile class.
     *
     * @expectedException \RuntimeException
     */
    public function testNoFilenameThrowsAnRuntimeException()
    {
        new MediaFile('');
    }

    /**
     * Test that a RuntimeException will be thrown if null
     * is passed to the constructor.
     *
     * @expectedException \RuntimeException
     */
    public function testNullFilenameThrowsAnRuntimeException()
    {
        new MediaFile(null);
    }

    /**
     * Test that false will be returned if MediaFile::isParsed will
     * be called after constructing the class.
     */
    public function testParseIsFalseAfterConstructing()
    {
        $mediafile = new MediaFile(TEST_ASSETS_DIR. '/empty.mp3');
        $this->assertFalse($expected = false, $mediafile->isParsed());
    }
}
