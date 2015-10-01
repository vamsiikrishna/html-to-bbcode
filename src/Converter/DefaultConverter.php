<?php

namespace Vamsi\HTMLToBBCode\Converter;

use Vamsi\HTMLToBBCode\Configuration;
use Vamsi\HTMLToBBCode\ConfigurationAwareInterface;
use Vamsi\HTMLToBBCode\ElementInterface;

class DefaultConverter implements ConverterInterface, ConfigurationAwareInterface
{
    const DEFAULT_CONVERTER = '_default';

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @param Configuration $config
     */
    public function setConfig(Configuration $config)
    {
        $this->config = $config;
    }

    /**
     * @param ElementInterface $element
     *
     * @return string
     */
    public function convert(ElementInterface $element)
    {
        // If strip_tags is false (the default), preserve tags that don't have BBCode equivalents,
        // such as <span> nodes on their own. C14N() canonicalizes the node to a string.
        // See: http://www.php.net/manual/en/domnode.c14n.php
        if ($this->config->getOption('strip_tags', false)) {
            return $element->getValue();
        }

        return html_entity_decode($element->getChildrenAsString());
    }

    /**
     * @return string[]
     */
    public function getSupportedTags()
    {
        return array(self::DEFAULT_CONVERTER);
    }
}