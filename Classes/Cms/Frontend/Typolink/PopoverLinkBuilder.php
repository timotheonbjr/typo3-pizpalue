<?php

declare(strict_types=1);

namespace Buepro\Pizpalue\Cms\Frontend\Typolink;

use TYPO3\CMS\Frontend\Typolink\AbstractTypolinkBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * PopoverLinkBuilder
 *
 * Hint: Is used from FE.
 *
 * @see \Buepro\Pizpalue\Cms\Recordlist\LinkHandler\PopoverLinkHandler
 */
class PopoverLinkBuilder extends AbstractTypolinkBuilder
{
    /**
     * Modifies the content from the href attribute.
     *
     * @see \Buepro\Pizpalue\Cms\Recordlist\LinkHandler\PopoverLinkHandler
     * @inheritdoc
     */
    public function build(array &$linkDetails, string $linkText, string $target, array $conf): array
    {
        if (isset($linkDetails['href'])) {
            if ($linkDetails['href'] === 'void') {
                return ['javascript:void(0);', $linkText];
            }
            $urlConf = [
                'typolink.' => [
                    'parameter' => $linkDetails['href'],
                    'returnLast' => 'url'
                ]
            ];
            /** @var ContentObjectRenderer $cObjRenderer (new instance to avoid overriding data from parent) */
            $cObjRenderer = GeneralUtility::makeInstance(ContentObjectRenderer::class);
            $url = $cObjRenderer->stdWrap('', $urlConf);
            return [$url, $linkText];
        }
        return ['', $linkText];
    }
}
