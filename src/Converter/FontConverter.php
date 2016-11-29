<?php

namespace Vamsi\HTMLToBBCode\Converter;

use Vamsi\HTMLToBBCode\ElementInterface;

class FontConverter implements ConverterInterface
{
    public function convert(ElementInterface $element)
    {
        $text = $element->getValue();
        $size = $element->getAttribute('size');
        $color = $element->getAttribute('color');

        $bbcode = $text;

        if ($size) {
            $bbcode = "[size=$size]{$bbcode}[/size]";
        }

        if ($color) {
            $bbcode = "[color=$color]{$bbcode}[/color]";
        }

        return $bbcode;
    }

    public function getSupportedTags()
    {
       return array('font');
    }
}