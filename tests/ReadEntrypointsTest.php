<?php

namespace Like\NomeDaLib\Tests;

use WebpackEncore\ReadEntrypoints;
use PHPUnit\Framework\TestCase;

class ReadEntrypointsTest extends TestCase {
	
	/**
	 * @var ReadEntrypoints
	 */
	private $instance;

	public function setUp() {
		$this->instance = ReadEntrypoints::get('tests/valid', false);
	}

	public function testInstance() {
		$this->assertInstanceOf(ReadEntrypoints::class, $this->instance);
	}

	public function testJs() {
		$this->assertEquals(['/build/runtime.js', '/build/app.js'], $this->instance->getJs('app'));
	}

	public function testAllJs() {
		$this->assertEquals(['/build/runtime.js', '/build/app.js', '/build/app2.js'], $this->instance->getJs());
		$this->assertEquals(['/build/runtime.js', '/build/app.js', '/build/app2.js'], $this->instance->getAllJs());
	}

	public function testGetEntrypoints() {
		$this->assertEquals(['app','app2'], $this->instance->getEntrypoints());
	}

	public function testCss() {
		$this->assertEquals(['/build/app.css'], $this->instance->getCss('app'));
	}

	public function testAllCss() {
		$this->assertEquals(['/build/app.css','/build/app2.css'], $this->instance->getCss());
		$this->assertEquals(['/build/app.css','/build/app2.css'], $this->instance->getAllCss());
	}

	public function testCssTag() {
		$this->assertEquals(
			'<link href="/build/app.css" rel="stylesheet">',
			$this->instance->getCssTags('app')
		);
		$this->assertEquals(
			'<link href="/build/app2.css" rel="stylesheet">',
			$this->instance->getCssTags('app2')
		);
		$this->assertEquals(
			'<link href="/build/app.css" rel="stylesheet">' .
			'<link href="/build/app2.css" rel="stylesheet">',
			$this->instance->getCssTags()
		);
	}

	public function testJsTag() {
		$this->assertEquals(
			'<script type="text/javascript" src="/build/runtime.js"></script>' .
			'<script type="text/javascript" src="/build/app.js"></script>',
			$this->instance->getJsTags('app')
		);
		$this->assertEquals(
			'<script type="text/javascript" src="/build/app2.js"></script>',
			$this->instance->getJsTags('app2')
		);
		$this->assertEquals(
			'<script type="text/javascript" src="/build/runtime.js"></script>' .
			'<script type="text/javascript" src="/build/app.js"></script>' .
			'<script type="text/javascript" src="/build/app2.js"></script>',
			$this->instance->getJsTags()
		);
	}
}
