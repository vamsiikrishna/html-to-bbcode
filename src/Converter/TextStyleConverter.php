<?php

namespace Vamsi\HTMLToBBCode\Converter;

use Vamsi\HTMLToBBCode\ElementInterface;

class TextStyleConverter implements ConverterInterface
{
    public function convert(ElementInterface $element)
    {
        $text = $element->getValue();
        $tag = $element->getTagName();

        $bbcode = '[' . $tag . ']'.$text.'[/' . $tag . ']';

        return $bbcode;
    }

    public function getSupportedTags()
    {
       return array('b', 'i', 's', 'u');
    }
}