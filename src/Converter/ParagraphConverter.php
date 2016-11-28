<?php

namespace Vamsi\HTMLToBBCode\Converter;

use Vamsi\HTMLToBBCode\ElementInterface;

class ParagraphConverter implements ConverterInterface
{
    public function convert(ElementInterface $element)
    {
        $text = $element->getValue();

        $bbcode = '[p]'.$text.'[/p]';

        return $bbcode;
    }

    public function getSupportedTags()
    {
       return array('p');
    }
}