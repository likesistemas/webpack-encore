<?php

namespace Like\NomeDaLib\Tests;

use Smarty;
use WebpackEncore\ReadEntrypoints;
use WebpackEncore\SmartyTemplateIntegration;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

class SmartyTemplateIntegrationTest extends TestCase {
	public function testUseTemplate() {
		$readEntrypoints = ReadEntrypoints::get('tests/valid', false);

		$smarty = new Smarty();
		SmartyTemplateIntegration::addFunctions($smarty, $readEntrypoints);

		$smarty->addTemplateDir(__DIR__ . '/./template/');
		$smarty->setCompileDir(__DIR__ . '/./template-compile/');

		$html = $smarty->fetch('index.tpl');
		$this->assertStringContainsString('<link href="/build/app.css" rel="stylesheet">', $html);
		$this->assertStringContainsString('<script type="text/javascript" src="/build/runtime.js"></script><script type="text/javascript" src="/build/app.js"></script>', $html);
	}
}
