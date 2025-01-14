<?php

/*
 * This file is part of the composer package buepro/typo3-pizpalue.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die('Access denied.');

(static function (): void {
    /**
     * Add content element group to content element selector
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItemGroup(
        'tt_content',
        'CType',
        'pizpalue',
        'Pizpalue'
    );

    /**
     * Add `tx_pizpalue_header_class`
     */
    $items = $GLOBALS['TCA']['tt_content']['columns']['tx_pizpalue_header_class'] = [
        'exclude' => true,
        'label' => 'LLL:EXT:bootstrap_package/Resources/Private/Language/Backend.xlf:carousel_item.header_class',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['', 'none'],
                ['h1', 'h1'],
                ['h2', 'h2'],
                ['h3', 'h3'],
                ['h4', 'h4'],
                ['h5', 'h5']
            ]
        ],
        'l10n_mode' => 'exclude',
    ];
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
        'tt_content',
        'headers',
        'tx_pizpalue_header_class',
        'after:header_layout'
    );

    /**
     * Add `tx_pizpalue_subheader_class`
     */
    $items = $GLOBALS['TCA']['tt_content']['columns']['tx_pizpalue_subheader_class'] = [
        'exclude' => true,
        'label' => 'LLL:EXT:bootstrap_package/Resources/Private/Language/Backend.xlf:carousel_item.subheader_class',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['', 'none'],
                ['h1', 'h1'],
                ['h2', 'h2'],
                ['h3', 'h3'],
                ['h4', 'h4'],
                ['h5', 'h5']
            ]
        ],
        'l10n_mode' => 'exclude',
    ];
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
        'tt_content',
        'headers',
        'tx_pizpalue_subheader_class',
        'after:subheader'
    );

    /**
     * Add 'tile` layout items
     */
    $items = $GLOBALS['TCA']['tt_content']['columns']['layout']['config']['items'];
    $items[] = [
        'LLL:EXT:pizpalue/Resources/Private/Language/locallang.xlf:tt_content.layout.tile21',
        'pp-tile-21'
    ];
    $items[] = [
        'LLL:EXT:pizpalue/Resources/Private/Language/locallang.xlf:tt_content.layout.tile11',
        'pp-tile-11'
    ];
    $items[] = [
        'LLL:EXT:pizpalue/Resources/Private/Language/locallang.xlf:tt_content.layout.tile12',
        'pp-tile-12'
    ];
    $GLOBALS['TCA']['tt_content']['columns']['layout']['config']['items'] = $items;
})();
