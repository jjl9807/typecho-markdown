<?php
namespace MarkdownParse\ParserExtension;

use League\CommonMark\Parser\Inline\InlineParserInterface;
use League\CommonMark\Parser\Inline\InlineParserMatch;
use League\CommonMark\Parser\InlineParserContext;
use League\CommonMark\Inline\Element\Text;

class LatexInlineParser implements InlineParserInterface
{
    public function getMatchDefinition(): InlineParserMatch
    {
        return InlineParserMatch::string('$'); 
    }


    public function parse(InlineParserContext $inlineContext): bool
    {
        $cursor = $inlineContext->getCursor();
        $startingPosition = $cursor->getPosition();

        if ($cursor->getCharacter() !== '$' || !$cursor->match('/(?<!\\)(\$)([\s\S]+?)(?<!\\)(\$)/')) {
            return false;
        }

        $latexContent = $cursor->getMatchedText();
        $inlineContext->getContainer()->appendChild(new Text($latexContent));

        return true;
    }
}
