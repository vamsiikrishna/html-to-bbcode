<?php

namespace Vamsi\HTMLToBBCode\Converter;

use Vamsi\HTMLToBBCode\ElementInterface;

class BreakConverter implements ConverterInterface
{
    public function convert(ElementInterface $element)
    {
         return '[br]';
    }

    public function getSupportedTags()
    {
       return array('br');
    }
}