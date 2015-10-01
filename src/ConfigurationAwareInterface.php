<?php

namespace Vamsi\HTMLToBBCode;


interface ConfigurationAwareInterface
{
    /**
     * @param Configuration $config
     */
    public function setConfig(Configuration $config);
}