<?php

namespace Vamsi\HTMLToBBCode\Converter;

use Vamsi\HTMLToBBCode\ElementInterface;

class QuoteConverter implements ConverterInterface
{
    public function convert(ElementInterface $element)
    {
        $text = $element->getValue();

        $bbcode = '[quote]' . $text . '[/quote]';

        return $bbcode;
    }

    public function getSupportedTags()
    {
        return array('blockquote');
    }
}
