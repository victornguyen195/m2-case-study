<?php

namespace Amasty\CustomTabs\Test\Unit\Plugin\Cms\Model\Wysiwyg;

use Amasty\CustomTabs\Test\Unit\Traits;
use Amasty\CustomTabs\Plugin\Cms\Model\Wysiwyg\ConfigPlugin;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class ConfigPluginTest
 *
 * @see ConfigPlugin
 */
class ConfigPluginTest extends \PHPUnit\Framework\TestCase
{
    use Traits\ObjectManagerTrait;
    use Traits\ReflectionTrait;

    /**
     * @var ConfigPlugin|MockObject $plugin
     */
    private $plugin;

    /**
     * @covers ConfigPlugin::getWysiwygPluginSettings
     *
     */
    public function testGetWysiwygPluginSettings()
    {
        $config = $this->getObjectManager()->getObject(\Magento\Framework\DataObject::class);
        $this->plugin = $this->getMockBuilder(ConfigPlugin::class)
            ->disableOriginalConstructor()
            ->setMethods(
                [
                    'getAttributesWysiwygActionUrl',
                    'getWysiwygJsPluginSrc',
                    'getAttributesWysiwygData',
                    'isOldMagentoVersion'
                ]
            )
            ->getMock();

        $this->plugin->expects($this->any())->method('getAttributesWysiwygActionUrl')->willReturn('');
        $this->plugin->expects($this->any())->method('getWysiwygJsPluginSrc')->willReturn('');
        $this->plugin->expects($this->any())->method('getAttributesWysiwygData')->willReturn([]);
        $this->plugin->expects($this->any())->method('isOldMagentoVersion')->willReturn(false);

        $settings = $this->plugin->getWysiwygPluginSettings($config);
        $this->assertArrayHasKey('plugins', $settings);
        $this->assertTrue((bool)$settings['plugins'][0]['name'] == 'amcustomtabs_attribute');
    }
}
