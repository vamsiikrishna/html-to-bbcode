<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Vamsi\HTMLToBBCode\HtmlConverter;

$converter = new HtmlConverter();

$html = '<a href="http://www.w3schools.com">Visit W3Schools</a>
<a href="https://www.github.com">Visit Github</a>
<a href="http://www.google.com">Visit Google</a>
<a href="http://www.google.com"></a>';

$bbcode = $converter->convert($html);
echo $bbcode;