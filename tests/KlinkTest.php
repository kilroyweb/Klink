<?php

class KlinkTest extends TestCase
{

    public function testToStringFormatsOutput(){
        $klink = new \KilroyWeb\Klink\Klink();
        $this->assertEquals('<li><a href="#">Link</a></li>',(string)$klink);
    }

    public function testURLSetsKlinkURL()
    {
        $klink = new \KilroyWeb\Klink\Klink();
        $html = (string) $klink->url('my-account');
        $this->assertEquals('<li><a href="http://localhost/my-account">Link</a></li>',$html);
    }

    public function testURLShowsActive(){
        $this->visit('my-account');
        $klink = new \KilroyWeb\Klink\Klink();
        $html = (string) $klink->url('my-account');
        $this->assertEquals('<li class="active"><a href="http://localhost/my-account">Link</a></li>',$html);
    }

    public function testShowClassReturnsEmptyOnInactiveLink(){
        $klink = new \KilroyWeb\Klink\Klink();
        $html = (string) $klink->url('my-account')->showClass();
        $this->assertEquals('',$html);
    }

    public function testShowClassReturnsActiveOnActiveLink(){
        $this->visit('my-account');
        $klink = new \KilroyWeb\Klink\Klink();
        $html = (string) $klink->url('my-account')->showClass();
        $this->assertEquals('active',$html);
    }

}