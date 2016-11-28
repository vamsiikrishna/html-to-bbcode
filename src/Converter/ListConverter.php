<?php

namespace Vamsi\HTMLToBBCode\Converter;

use Vamsi\HTMLToBBCode\ElementInterface;

class ListConverter implements ConverterInterface
{
    public function convert(ElementInterface $element)
    {
        $text = $element->getValue();
        $tag = $element->getTagName();

        if ($tag == 'ul' || $tag == 'ol') {
            $bbcode = "[list]{$text}[/list]";
        } else {
            $bbcode = "[*]{$text}";
        }

        return $bbcode;
    }

    public function getSupportedTags()
    {
       return array('ul', 'ol', 'li');
    }
}