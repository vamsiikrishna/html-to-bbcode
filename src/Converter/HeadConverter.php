<?php

namespace Vamsi\HTMLToBBCode\Converter;

use Vamsi\HTMLToBBCode\ElementInterface;

class HeadConverter implements ConverterInterface
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
       return array('h1', 'h2', 'h3', 'h4', 'h5', 'h6');
    }
}