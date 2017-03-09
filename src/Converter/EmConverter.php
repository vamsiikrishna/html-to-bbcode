<?php

namespace Vamsi\HTMLToBBCode\Converter;

use Vamsi\HTMLToBBCode\ElementInterface;

class EmConverter implements ConverterInterface
{
    public function convert(ElementInterface $element)
    {
        $text = $element->getValue();

        $bbcode = '[i]' . $text . '[/i]';

        return $bbcode;
    }

    public function getSupportedTags()
    {
        return array('em');
    }
}
