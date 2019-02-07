<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel\Inline\Parser;

use League\CommonMark\InlineParserContext;
use JohnnyHuy\Laravel\Inline\Element\Vimeo;
use League\CommonMark\Inline\Parser\AbstractInlineParser;

class VimeoParser extends AbstractInlineParser
{
    /**
     * @param InlineParserContext $inlineContext
     * @return bool
     */
    public function parse(InlineParserContext $inlineContext)
    {
        $cursor = $inlineContext->getCursor();
        $savedState = $cursor->saveState();

        $cursor->advance();

        // Regex to ensure that we got a valid YouTube url
        // and the required `:vimeo` prefix exists
        $regex = '/^(?:vimeo)\s(?:https?\:\/\/)?(?:www\.)?(?:vimeo\.com\/)([^&#\s\?]+)(?:\?.[^\s]+)?/';
        $validate = $cursor->match($regex);

        // The computer says no
        if (!$validate) {
            $cursor->restoreState($savedState);

            return false;
        }

        $matches = [];
        preg_match($regex, $validate, $matches);
        $videoId = $matches[1];

        // Generates a valid YouTube embed url with the parsed video id from the given url
        $inlineContext->getContainer()->appendChild(new Vimeo("https://player.vimeo.com/video/$videoId"));

        return true;
    }

    /**
     * @return string[]
     */
    public function getCharacters()
    {
        return [':'];
    }
}
