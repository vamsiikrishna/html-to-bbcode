<?php

namespace Vamsi\HTMLToBBCode\Converter;

use Vamsi\HTMLToBBCode\ElementInterface;

class ImageConverter implements ConverterInterface
{
    public function convert(ElementInterface $element)
    {
        $src = $element->getAttribute('src');

        $bbcode = "[img]{$src}[/img]";

        return $bbcode;
    }

    public function getSupportedTags()
    {
       return array('img');
    }
}