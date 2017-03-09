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

    public function test_paragraph()
    {
        $this->html_gives_bbcode('<p>read the <a href="http://blog.codinghorror.com/">Coding Horror</a></p>', '[p]read the [url=http://blog.codinghorror.com/]Coding Horror[/url][/p]');
    }

    public function test_text_style()
    {
        $this->html_gives_bbcode('<b>general</b> public', '[b]general[/b] public');
        $this->html_gives_bbcode('<i>general</i> public', '[i]general[/i] public');
        $this->html_gives_bbcode('<u>general</u> public', '[u]general[/u] public');
        $this->html_gives_bbcode('<s>general</s> public', '[s]general[/s] public');
    }

    public function test_head()
    {
        $this->html_gives_bbcode('<h2>general</h2> public', '[h2]general[/h2] public');
    }

    public function test_break()
    {
        $this->html_gives_bbcode('general<br> public', '[p]general[br] public[/p]');
    }

    public function test_list()
    {
        $this->html_gives_bbcode('<ul><li>1</li><li>2</li></ul>', '[list][*]1[*]2[/list]');
    }

    public function test_font()
    {
        $this->html_gives_bbcode('<font face="verdana" color="green">This is some text!</font>', '[color=green]This is some text![/color]');
        $this->html_gives_bbcode('<font face="verdana" size="13">This is another text!</font>', '[size=13]This is another text![/size]');
    }

    public function test_image()
    {
        $this->html_gives_bbcode('<img src="http://lorempixel.com/g/400/200/" alt="lorem ipsum" />', '[img]http://lorempixel.com/g/400/200/[/img]');
    }

    public function test_strong()
    {
        $this->html_gives_bbcode('<strong>some strong text</strong>', '[b]some strong text[/b]');
    }

    public function test_em()
    {
        $this->html_gives_bbcode('<em>some em text</em>', '[i]some em text[/i]');
    }
}