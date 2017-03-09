<?php

namespace Vamsi\HTMLToBBCode\Converter;

use Vamsi\HTMLToBBCode\ElementInterface;

class StrongConverter implements ConverterInterface
{
    public function convert(ElementInterface $element)
    {
        $text = $element->getValue();

        $bbcode = '[b]' . $text . '[/b]';

        return $bbcode;
    }

    public function getSupportedTags()
    {
        return array('strong');
    }
}
