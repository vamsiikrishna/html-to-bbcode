<?php

namespace Vamsi\HTMLToBBCode;

use Vamsi\HTMLToBBCode\Converter\BreakConverter;
use Vamsi\HTMLToBBCode\Converter\DefaultConverter;
use Vamsi\HTMLToBBCode\Converter\FontConverter;
use Vamsi\HTMLToBBCode\Converter\HeadConverter;
use Vamsi\HTMLToBBCode\Converter\ImageConverter;
use Vamsi\HTMLToBBCode\Converter\LinkConverter;
use Vamsi\HTMLToBBCode\Converter\ConverterInterface;
use Vamsi\HTMLToBBCode\Converter\ParagraphConverter;
use Vamsi\HTMLToBBCode\Converter\TextStyleConverter;
use Vamsi\HTMLToBBCode\Converter\ListConverter;

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
        $environment->addConverter(new ParagraphConverter());
        $environment->addConverter(new TextStyleConverter());
        $environment->addConverter(new HeadConverter());
        $environment->addConverter(new BreakConverter());
        $environment->addConverter(new ListConverter());
        $environment->addConverter(new FontConverter());
        $environment->addConverter(new ImageConverter());

        return $environment;
    }
}