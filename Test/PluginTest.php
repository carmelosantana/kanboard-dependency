<?php

require_once 'tests/units/Base.php';

use Kanboard\Plugin\DependencyPlugin\Plugin;
use KanboardTests\units\Base;

class PluginTest extends Base
{
    public function testPluginNameValue()
    {
        $plugin = new Plugin($this->container);
        $this->assertSame('DependencyPlugin', $plugin->getPluginName());
    }

    public function testPluginVersionComesFromPluginJson()
    {
        $plugin = new Plugin($this->container);
        $json = json_decode(file_get_contents(dirname(__DIR__) . '/plugin.json'), true);
        $this->assertSame($json['version'], $plugin->getPluginVersion());
        $this->assertDoesNotMatchRegularExpression(
            "/function getPluginVersion\\(\\)[^{]*\\{[^}]*'\\d+\\.\\d+/",
            file_get_contents(dirname(__DIR__) . '/Plugin.php'),
            'getPluginVersion() reads plugin.json; the version lives only there'
        );
    }

    public function testPluginCompatibleVersionValue()
    {
        $plugin = new Plugin($this->container);
        $this->assertSame('>=1.2.47', $plugin->getCompatibleVersion());
    }

    public function testPluginMetadataNotEmpty()
    {
        $plugin = new Plugin($this->container);
        $this->assertNotEmpty($plugin->getPluginAuthor());
        $this->assertNotEmpty($plugin->getPluginDescription());
        $this->assertSame('MIT', $plugin->getPluginLicense());
    }
}
