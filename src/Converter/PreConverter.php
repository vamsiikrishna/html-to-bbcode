<?php

namespace Vamsi\HTMLToBBCode\Converter;

use Vamsi\HTMLToBBCode\ElementInterface;

class PreConverter implements ConverterInterface
{
    public function convert(ElementInterface $element)
    {
        $text = $element->getValue();

        $bbcode = '[code]' . $text . '[/code]';

        return $bbcode;
    }

    public function getSupportedTags()
    {
        return array('pre');
    }

}