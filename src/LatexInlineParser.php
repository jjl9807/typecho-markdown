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
        return InlineParserMatch::regex('(?<!\\)(\$)([\s\S]+?)(?<!\\)(\$)');
    }


    public function parse(InlineParserContext $inlineContext): bool
    {
        $cursor = $inlineContext->getCursor();
        $cursor->advanceBy($inlineContext->getFullMatchLength());
        $inlineContext->getContainer()->appendChild(new Text("LaTeX formula"));
        // $inlineContext->getContainer()->appendChild(new Text($inlineContext->getFullMatch()));

        return true;
    }
}
