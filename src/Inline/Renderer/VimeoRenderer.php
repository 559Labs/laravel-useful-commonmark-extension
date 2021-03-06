<?php

namespace JohnnyHuy\Laravel\Inline\Renderer;

use League\CommonMark\HtmlElement;
use League\CommonMark\Util\Configuration;
use JohnnyHuy\Laravel\Inline\Element\Vimeo;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Util\ConfigurationAwareInterface;
use League\CommonMark\Inline\Element\AbstractWebResource;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class VimeoRenderer implements InlineRendererInterface, ConfigurationAwareInterface
{
    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @param AbstractInline|AbstractWebResource $inline
     * @param \League\CommonMark\ElementRendererInterface $htmlRenderer
     *
     * @return \League\CommonMark\HtmlElement|string
     */
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (!($inline instanceof Vimeo)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }

        //create a new iframe with the given Vimeo url
        $iframe = new HtmlElement(
            'iframe', 
            [
                'width' => 640,
                'height' => 360,
                'src' => $inline->getUrl(),
                'webkitallowfullscreen' => true,
                'mozallowfullscreen' => true,
                'allowfullscreen' => true,
                'type' => "text/html",
                'frameborder' => 0,
            ]
        );

        //return the iframe with a span as wrapper element
        return new HtmlElement('span', ['class' => 'vimeo-video'], $iframe);
    }

    /**
     * @param Configuration $configuration
     */
    public function setConfiguration(Configuration $configuration)
    {
        $this->config = $configuration;
    }
}
