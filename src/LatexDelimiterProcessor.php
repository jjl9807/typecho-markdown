<?php
namespace MarkdownParse\ParserExtension;

use League\CommonMark\Delimiter\Delimiter;
use League\CommonMark\Delimiter\Processor\DelimiterProcessorInterface;
use League\CommonMark\Node\Inline\Text;

class LatexDelimiterProcessor implements DelimiterProcessorInterface
{
    public function getOpeningCharacter(): string
    {
        return '$';
    }

    public function getClosingCharacter(): string
    {
        return '$';
    }

    public function getMinLength(): int
    {
        return 1;
    }

    public function processDelimiter(Delimiter $opener, Delimiter $closer): void
    {
        // 检查开头 $ 前是否有 \ 转义符
        $prevCharOpener = $opener->getInlineNode()->previous() ? $opener->getInlineNode()->previous()->getLiteral() : null;
        if ($prevCharOpener === '\\') {
            return;
        }

        // 检查结尾 $ 前是否有 \ 转义符
        $prevCharCloser = $closer->getInlineNode()->previous() ? $closer->getInlineNode()->previous()->getLiteral() : null;
        if ($prevCharCloser === '\\') {
            return;
        }

        // 获取公式内容
        $latexContent = $opener->next()->getLiteral();

        // 创建一个新的 Text 节点，包含原始 LaTeX 内容
        $latexNode = new Text('$' . $latexContent . '$');
        $opener->getInlineNode()->insertAfter($latexNode);

        // 清除已处理的节点
        $opener->detach();
        $closer->detach();
    }
}
