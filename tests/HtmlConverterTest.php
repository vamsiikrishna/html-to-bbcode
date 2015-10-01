<?php

namespace Vamsi\HTMLToBBCode\Test;

use Vamsi\HTMLToBBCode\HtmlConverter;

class HtmlConverterTest extends \PHPUnit_Framework_TestCase
{
    private function html_gives_bbcode($html, $expected_bb_code, array $options = array())
    {
        $bbcode = new HtmlConverter();
        $result = $bbcode->convert($html);
        $this->assertEquals($expected_bb_code, $result);
    }

    public function test_anchor()
    {
        $this->html_gives_bbcode('<a href="http://blog.codinghorror.com/">Coding Horror</a>', '[url=http://blog.codinghorror.com/]Coding Horror[/url]');
        $this->html_gives_bbcode('<a href="http://blog.codinghorror.com/"></a>', '[url=http://blog.codinghorror.com/][/url]');

    }
}