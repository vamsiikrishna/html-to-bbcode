<?php

namespace Vamsi\HTMLToBBCode\Converter;

use Vamsi\HTMLToBBCode\ElementInterface;

interface ConverterInterface
{
    /**
     * @param ElementInterface $element
     *
     * @return string
     */
    public function convert(ElementInterface $element);

    /**
     * @return string[]
     */
    public function getSupportedTags();
}