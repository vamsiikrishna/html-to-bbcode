<?php

namespace Vamsi\HTMLToBBCode;


class HtmlConverter
{
    /**
     * @var Environment
     */
    protected $environment;

    /**
     * Constructor
     *
     * @param array $options Configuration options
     */
    public function __construct(array $options = array())
    {
        $defaults = array(
            'header_style'    => 'setext', // Set to 'atx' to output H1 and H2 headers as # Header1 and ## Header2
            'suppress_errors' => true, // Set to false to show warnings when loading malformed HTML
            'strip_tags'      => false, // Set to true to strip tags that don't have bbcode equivalents. N.B. Strips tags, not their content. Useful to clean MS Word HTML output.
            'bold_style'      => '**', // Set to '__' if you prefer the underlined style
            'italic_style'    => '*', // Set to '_' if you prefer the underlined style
            'remove_nodes'    => '', // space-separated list of dom nodes that should be removed. example: 'meta style script'
        );

        $this->environment = Environment::createDefaultEnvironment($defaults);

        $this->environment->getConfig()->merge($options);
    }

    /**
     * @return Environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->environment->getConfig();
    }

    /**
     * Convert
     *
     * Loads HTML and passes to getBBCode()
     *
     * @param $html
     *
     * @return string The BBCode version of the html
     */
    public function convert($html)
    {
        if (trim($html) === '') {
            return '';
        }

        $document = $this->createDOMDocument($html);

        // Work on the entire DOM tree (including head and body)
        if (!($root = $document->getElementsByTagName('html')->item(0))) {
            throw new \InvalidArgumentException('Invalid HTML was provided');
        }

        $rootElement = new Element($root);
        $this->convertChildren($rootElement);

        // Store the now-modified DOMDocument as a string
        $bbcode = $document->saveHTML();

        $bbcode = $this->sanitize($bbcode);

        return $bbcode;
    }

    /**
     * @param string $html
     *
     * @return \DOMDocument
     */
    private function createDOMDocument($html)
    {
        $document = new \DOMDocument();

        if ($this->getConfig()->getOption('suppress_errors')) {
            // Suppress conversion errors (from http://bit.ly/pCCRSX)
            libxml_use_internal_errors(true);
        }

        // Hack to load utf-8 HTML (from http://bit.ly/pVDyCt)
        $document->loadHTML('<?xml encoding="UTF-8">' . $html);
        $document->encoding = 'UTF-8';

        if ($this->getConfig()->getOption('suppress_errors')) {
            libxml_clear_errors();
        }

        return $document;
    }

    /**
     * Convert Children
     *
     * Recursive function to drill into the DOM and convert each node into BBCode from the inside out.
     *
     * Finds children of each node and convert those to #text nodes containing their BBCode equivalent,
     * starting with the innermost element and working up to the outermost element.
     *
     * @param ElementInterface $element
     */
    private function convertChildren(ElementInterface $element)
    {
        // Don't convert HTML code inside <code> and <pre> blocks to BBCode - that should stay as HTML
        if ($element->isDescendantOf(array('pre', 'code'))) {
            return;
        }

        // If the node has children, convert those to BBCode first
        if ($element->hasChildren()) {
            foreach ($element->getChildren() as $child) {
                $this->convertChildren($child);
            }
        }

        // Now that child nodes have been converted, convert the original node
        $bbcode = $this->convertToBBCode($element);

        // Create a DOM text node containing the BBCode equivalent of the original node

        // Replace the old $node e.g. '<h3>Title</h3>' with the new $bbcode_node e.g. '### Title'
        $element->setFinalBBCode($bbcode);
    }

    /**
     * Convert to BBCode
     *
     * Converts an individual node into a #text node containing a string of its BBCode equivalent.
     *
     * Example: An <h3> node with text content of 'Title' becomes a text node with content of '### Title'
     *
     * @param ElementInterface $element
     *
     * @return string The converted HTML as BBCode
     */
    protected function convertToBBCode(ElementInterface $element)
    {
        $tag = $element->getTagName();

        // Strip nodes named in remove_nodes
        $tags_to_remove = explode(' ', $this->getConfig()->getOption('remove_nodes'));
        if (in_array($tag, $tags_to_remove)) {
            return false;
        }

        $converter = $this->environment->getConverterByTag($tag);

        return $converter->convert($element);
    }

    /**
     * @param string $bbcode
     *
     * @return string
     */
    protected function sanitize($bbcode)
    {
        $bbcode = html_entity_decode($bbcode, ENT_QUOTES, 'UTF-8');
        $bbcode = html_entity_decode($bbcode, ENT_QUOTES, 'UTF-8'); // Double decode to cover cases like &amp;nbsp; http://www.php.net/manual/en/function.htmlentities.php#99984
        $bbcode = preg_replace('/<!DOCTYPE [^>]+>/', '', $bbcode); // Strip doctype declaration
        $unwanted = array('<html>', '</html>', '<body>', '</body>', '<head>', '</head>', '<?xml encoding="UTF-8">', '&#xD;');
        $bbcode = str_replace($unwanted, '', $bbcode); // Strip unwanted tags
        $bbcode = trim($bbcode, "\n\r\0\x0B");

        return $bbcode;
    }
}