<?php

/*
 * This file is part of the composer package buepro/typo3-pizpalue.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Buepro\Pizpalue\Tests\Functional\ViewHelpers;

use TYPO3\CMS\Core\Page\AssetCollector;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class PizpalueFrameViewHelperTest extends FunctionalTestCase
{
    private const TEMPLATE_PATH = 'EXT:pizpalue/Tests/Functional/ViewHelpers/Fixtures/PizpalueFrame.html';

    /**
     * @var bool Speed up this test case, it needs no database
     */
    protected $initializeDatabase = false;

    /**
     * @var StandaloneView
     */
    protected $view;

    /**
     * @var AssetCollector
     */
    protected $assetCollector;

    /**
     * @var array
     */
    protected $contentData = [
        'uid' => 1,
        'layout' => 0,
        'tx_pizpalue_layout_breakpoint' => '',
        'tx_pizpalue_animation' => 0,
        'tx_pizpalue_classes' => 'test-1636104021 test-1636104031',
        'tx_pizpalue_style' => 'border-left-color: blue; border-right-color: green;',
        'tx_pizpalue_attributes' => 'data-1636104078="1" data-1636104091="2"',
    ];

    /**
     * @var array
     */
    protected $pizpalueConstants = [
        'seo' => [
            'optimizeLinkTargets' => 0,
        ],
        'animation' => [
            '1' => [
                'classes' => 'test-animation-1636113235',
                'styles' => 'border: red;',
                'attributes' => 'data-josh-anim-name="fadeInBottomLeft"',
            ],
            'aos' => [
                'initParams' => 'easing: \'ease-in-out-sine\', once: true, disable: \'mobile\'',
            ],
            'josh' => [
                'initParams' => 'animateInMobile: false',
            ],
        ],
    ];

    /**
     * @var array
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/bootstrap_package',
        'typo3conf/ext/pizpalue',
    ];

    private function getDefaultExpected(): array
    {
        return [
            'classes' => ['test-1636104021', 'test-1636104031'],
            'styles' => ['border-left-color: blue', 'border-right-color: green'],
            'attributes' => ['data-1636104078="1"', 'data-1636104091="2"'],
            'isTile' => (bool)$this->contentData['layout'],
            'hasCssAnimation' => false,
            'hasScrollAnimation' => false,
            'optimizeLinkTargets' => (bool) $this->pizpalueConstants['seo']['optimizeLinkTargets'],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->view = GeneralUtility::makeInstance(StandaloneView::class);
        $this->view->setTemplatePathAndFilename(self::TEMPLATE_PATH);
        $this->assetCollector = GeneralUtility::makeInstance(AssetCollector::class);
    }

    private function testViewHelperData(array $data, array $pizpalueConstants, array $expected): void
    {
        $this->view->assignMultiple([
            'data' => $data,
            'pizpalueConstants' => $pizpalueConstants,
        ]);
        $html = $this->view->render();
        $xml = new \SimpleXMLElement($html);
        [$node] = $xml->xpath('//div[@id="inline"]');
        $actual = json_decode(trim((string)$node), true);
        self::assertSame($expected, $actual);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function tagOrInlineModeCanBeUsed(): void
    {
        $this->view->setTemplatePathAndFilename(self::TEMPLATE_PATH);
        $this->view->assignMultiple([
            'data' => $this->contentData,
            'pizpalueConstants' => $this->pizpalueConstants,
        ]);
        $html = $this->view->render();
        $xml = new \SimpleXMLElement($html);
        foreach (['tag', 'inline'] as $id) {
            [$node] = $xml->xpath('//div[@id="' . $id . '"]');
            $actual = trim((string)$node);
            self::assertSame(json_encode($this->getDefaultExpected()), $actual);
        }
    }

    public function propertiesAreFormattedDataProvider(): array
    {
        $expected = $this->getDefaultExpected();
        $classesData = $this->contentData;
        $classesData['tx_pizpalue_classes'] = ' test-1636104021  test-1636104031 ';
        $styleData = $this->contentData;
        $styleData['tx_pizpalue_style'] = ' border-left-color:blue ;border-right-color:  green; ';
        $attributesData = $this->contentData;
        $attributesData['tx_pizpalue_attributes'] = ' data-1636104078 ="1"   data-1636104091= "2" ';
        return [
            'classes spaces' => [$classesData, $this->pizpalueConstants, $expected],
            'style spaces' => [$styleData, $this->pizpalueConstants, $expected],
            'attributes spaces' => [$attributesData, $this->pizpalueConstants, $expected],
        ];
    }

    /**
     * @dataProvider propertiesAreFormattedDataProvider
     * @test
     */
    public function propertiesAreFormatted(array $data, array $pizpalueConstants, array $expected): void
    {
        $this->testViewHelperData($data, $pizpalueConstants, $expected);
    }

    /**
     * @test
     */
    public function styleIsIncludedInAssets(): void
    {
        $data = $this->contentData;
        $data['tx_pizpalue_style'] = '#self .frame-inner { border: green 1px solid; }';
        $expected = $this->getDefaultExpected();
        $expected['styles'] = [];
        $this->testViewHelperData($data, $this->pizpalueConstants, $expected);
        self::assertArrayHasKey(
            'ppCe' . $data['uid'],
            $this->assetCollector->getInlineStyleSheets()
        );
    }

    public function animationsSetPropertiesAndIncludeAssetsDataProvider(): array
    {
        // Animation preset with josh
        $joshData = $this->contentData;
        $joshData['tx_pizpalue_animation'] = 1;
        $joshExpected = $this->getDefaultExpected();
        $joshExpected['hasScrollAnimation'] = true;
        $joshExpected['classes'][] = 'test-animation-1636113235';
        $joshExpected['classes'][] = 'josh-js';
        $joshExpected['styles'][] = 'border: red';
        $joshExpected['attributes'][] = 'data-josh-anim-name="fadeInBottomLeft"';

        // Animation with twikito
        $twikitoData = $this->contentData;
        $twikitoData['tx_pizpalue_attributes'] = 'data-scroll="animate__pulse"';
        $twikitoExpected = $this->getDefaultExpected();
        $twikitoExpected['hasScrollAnimation'] = true;
        $twikitoExpected['attributes'] = ['data-scroll="animate__animated animate__pulse"'];
        $twikitoExpected['attributes'][] = 'data-scroll-reverse="true"';
        return [
            'animation preset with josh' => [
                $joshData,
                $this->pizpalueConstants,
                $joshExpected,
                [
                    ['type' => 'JavaScript', 'id' => 'ppJosh'],
                    ['type' => 'InlineJavaScript', 'id' => 'ppJoshInit']
                ]
            ],
            'animation with twikito' => [
                $twikitoData,
                $this->pizpalueConstants,
                $twikitoExpected,
                [
                    ['type' => 'JavaScript', 'id' => 'ppTwikitoOnscroll'],
                    ['type' => 'InlineStyleSheet', 'id' => 'twikitoOnscroll']
                ]
            ],
        ];
    }

    /**
     * @dataProvider animationsSetPropertiesAndIncludeAssetsDataProvider
     * @test
     */
    public function animationsSetPropertiesAndIncludeAssets(
        array $data,
        array $pizpalueConstants,
        array $expectedData,
        array $expectedAnimationAssets
    ): void {
        $this->testViewHelperData($data, $pizpalueConstants, $expectedData);
        foreach ($expectedAnimationAssets as $animationAsset) {
            $assets = $this->assetCollector->{'get' . $animationAsset['type'] . 's'}();
            self::assertArrayHasKey($animationAsset['id'], $assets);
        }
    }

    /**
     * @deprecated will be removed in 13.0
     */
    public function testPropertySubstitutionInJoshAnimation(): void
    {
        $data = $this->contentData;
        $data['tx_pizpalue_animation'] = 1;
        $data['tx_pizpalue_attributes'] .= ' data-josh-delay="1s"';
        $expected = array_merge_recursive($this->getDefaultExpected(), [
            'styles' => ['border: red'],
            'classes' => ['test-animation-1636113235', 'josh-js'],
            'attributes' => [ 'data-josh-anim-delay="1s"', 'data-josh-anim-name="fadeInBottomLeft"'],
        ]);
        $expected['hasScrollAnimation'] = true;
        $this->testViewHelperData($data, $this->pizpalueConstants, $expected);
    }
}
