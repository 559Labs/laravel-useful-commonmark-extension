<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel;

use Illuminate\Container\Container;
use JohnnyHuy\Laravel\Block\Element\Color;
use JohnnyHuy\Laravel\Block\Parser\ColorParser;
use JohnnyHuy\Laravel\Block\Renderer\ColorRenderer;
use JohnnyHuy\Laravel\Block\Element\TextAlignment;
use JohnnyHuy\Laravel\Block\Parser\TextAlignmentParser;
use JohnnyHuy\Laravel\Block\Renderer\TextAlignmentRenderer;
use JohnnyHuy\Laravel\Inline\Element\YouTube;
use JohnnyHuy\Laravel\Inline\Parser\YouTubeParser;
use JohnnyHuy\Laravel\Inline\Renderer\YouTubeRenderer;
use JohnnyHuy\Laravel\Inline\Element\Vimeo;
use JohnnyHuy\Laravel\Inline\Parser\VimeoParser;
use JohnnyHuy\Laravel\Inline\Renderer\VimeoRenderer;
use JohnnyHuy\Laravel\Inline\Element\SoundCloud;
use JohnnyHuy\Laravel\Inline\Parser\SoundCloudParser;
use JohnnyHuy\Laravel\Inline\Renderer\SoundCloudRenderer;
use JohnnyHuy\Laravel\Inline\Element\Gist;
use JohnnyHuy\Laravel\Inline\Parser\GistParser;
use JohnnyHuy\Laravel\Inline\Renderer\GistRenderer;
use JohnnyHuy\Laravel\Inline\Element\Codepen;
use JohnnyHuy\Laravel\Inline\Parser\CodepenParser;
use JohnnyHuy\Laravel\Inline\Renderer\CodepenRenderer;
use League\CommonMark\Extension\Extension;

/**
 * This is the useful CommonMark extension class.
 *
 * @author Johnny Huynh <info@johnnyhuy.com>
 */
class UsefulCommonMarkExtension extends Extension
{
    /**
     * @var array
     */
    protected $inlineParsers;

    /**
     * @var array
     */
    protected $inlineRenderers;

    /**
     * @var array
     */
    protected $blockParsers;

    /**
     * @var array
     */
    protected $blockRenderers;

    /**
     * Use an IoC container to inject dependencies.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->inlineParsers = [
            $container->make(GistParser::class),
            $container->make(CodepenParser::class),
            $container->make(YouTubeParser::class),
            $container->make(Vimeo::class),
            $container->make(SoundCloudParser::class),
        ];

        $this->inlineRenderers = [
            Gist::class => $container->make(GistRenderer::class),
            Codepen::class => $container->make(CodepenRenderer::class),
            YouTube::class => $container->make(YouTubeRenderer::class),
            Vimeo::class => $container->make(VimeoRenderer::class),
            SoundCloud::class => $container->make(SoundCloudRenderer::class),
        ];

        $this->blockParsers = [
            $container->make(TextAlignmentParser::class),
            $container->make(ColorParser::class),
        ];

        $this->blockRenderers = [
            TextAlignment::class => $container->make(TextAlignmentRenderer::class),
            Color::class => $container->make(ColorRenderer::class),
        ];
    }

    /**
     * @return array|\League\CommonMark\Inline\Renderer\InlineRendererInterface[]
     */
    public function getInlineRenderers()
    {
        return $this->inlineRenderers;
    }

    /**
     * @return \League\CommonMark\Block\Renderer\BlockRendererInterface[]
     */
    public function getBlockRenderers()
    {
        return $this->blockRenderers;
    }

    /**
     * @return \League\CommonMark\Inline\Parser\InlineParserInterface[]
     */
    public function getInlineParsers()
    {
        return $this->inlineParsers;
    }

    /**
     * @return array|\League\CommonMark\Block\Parser\BlockParserInterface[]
     */
    public function getBlockParsers()
    {
        return $this->blockParsers;
    }
}
