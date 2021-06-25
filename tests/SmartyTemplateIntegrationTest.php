<?php

namespace Like\NomeDaLib\Tests;

use PHPUnit\Framework\TestCase;
use Smarty;
use WebpackEncore\ReadEntrypoints;
use WebpackEncore\SmartyTemplateIntegration;

class SmartyTemplateIntegrationTest extends TestCase {
	public function testUseTemplate() {
		$readEntrypoints = ReadEntrypoints::get('tests/valid');
		$smarty = new Smarty();
		SmartyTemplateIntegration::addFunctions($smarty, $readEntrypoints);

		$smarty->addTemplateDir(__DIR__ . '/./template/');
		$smarty->compile_dir = __DIR__ . '/./template-compile/';
		$this->assertEquals('<html>
<head>
    <title>Teste</title>
    <link href="/build/app.css" rel="stylesheet">
</head>
<body>
    <script type="text/javascript" src="/build/runtime.js"></script><script type="text/javascript" src="/build/app.js"></script>
</body>
</html>', $smarty->fetch('index.tpl'));
	}
}
