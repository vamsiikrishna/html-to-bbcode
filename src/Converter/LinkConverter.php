<?php

namespace Vamsi\HTMLToBBCode\Converter;

use Vamsi\HTMLToBBCode\ElementInterface;

class LinkConverter implements ConverterInterface
{
    public function convert(ElementInterface $element)
    {
        $href = $element->getAttribute('href');
        $text = $element->getValue();

        $bbcode = '[url='.$href.']'.$text.'[/url]';

        return $bbcode;
    }

    public function getSupportedTags()
    {
       return array('a');
    }
}