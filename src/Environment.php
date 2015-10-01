<?php

namespace Vamsi\HTMLToBBCode;

use Vamsi\HTMLToBBCode\Converter\DefaultConverter;
use Vamsi\HTMLToBBCode\Converter\LinkConverter;
use Vamsi\HTMLToBBCode\Converter\ConverterInterface;

final class Environment
{
    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var ConverterInterface[]
     */
    protected $converters = array();

    public function __construct(array $config = array())
    {
        $this->config = new Configuration($config);
        $this->addConverter(new DefaultConverter());
    }

    /**
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param ConverterInterface $converter
     */
    public function addConverter(ConverterInterface $converter)
    {
        if ($converter instanceof ConfigurationAwareInterface) {
            $converter->setConfig($this->config);
        }

        foreach ($converter->getSupportedTags() as $tag) {
            $this->converters[$tag] = $converter;
        }
    }

    /**
     * @param string $tag
     *
     * @return ConverterInterface
     */
    public function getConverterByTag($tag)
    {
        if (isset($this->converters[$tag])) {
            return $this->converters[$tag];
        }

        return $this->converters[DefaultConverter::DEFAULT_CONVERTER];
    }

    /**
     * @param array $config
     *
     * @return Environment
     */
    public static function createDefaultEnvironment(array $config = array())
    {
        $environment = new static($config);
        $environment->addConverter(new LinkConverter());

        return $environment;
    }
}