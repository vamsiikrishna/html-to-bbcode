<?php

namespace Vamsi\HTMLToBBCode\Converter;

use Vamsi\HTMLToBBCode\ElementInterface;

class TableConverter implements ConverterInterface
{
    public function convert(ElementInterface $element)
    {
        $text = $element->getValue();
        $tag = $element->getTagName();

        if ($tag == "table") {
            $bbcode = "[table]{$text}[/table]";
        } elseif ($tag == "tr") {
            $bbcode = "[tr]{$text}[/tr]";
        } elseif ($tag == "td") {
            $bbcode = "[td]{$text}[/td]";
        }
        return $bbcode;
    }

    public function getSupportedTags()
    {
        return array('table', 'tr', 'td');
    }

}