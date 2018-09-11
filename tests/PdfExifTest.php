<?php

use komatsu98\PdfExif\PdfExif;

class PdfExifTest extends PHPUnit_Framework_TestCase
{
    public function testOpenPdfFile()
    {
        $p = new PdfExif('tests/yo');
        $this->assertSame(true, method_exists($p, 'get_all'));
    }

    public function testGetAllInfo()
    {
        $p = new PdfExif('tests/yo');
        $this->assertSame(['Title' => "Hello world (PHP)!",
            'Author' => "Rainer Schaaf",
            'Creator' => "Yo",
            'CreationDate' => "D:20180911141636+07'00'",
            'Producer' => "PDFlib Personalization Server 9.1.2p1 (PHP7/Linux-x86_64) unlicensed"
        ], $p->get_all());
    }

    public function testGetInfoByKey()
    {
        $p = new PdfExif('tests/yo');
        $this->assertTrue("Hello world (PHP)!" == $p->get_by_key('Title'));
        $this->assertTrue("Rainer Schaaf" == $p->get_by_key('Author'));
        $this->assertTrue("Yo" == $p->get_by_key('Creator'));
        $this->assertTrue("D:20180911141636+07'00'" == $p->get_by_key('CreationDate'));
        $this->assertTrue("PDFlib Personalization Server 9.1.2p1 (PHP7/Linux-x86_64) unlicensed" == $p->get_by_key('Producer'));
    }

}

