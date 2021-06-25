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
		$this->instance = ReadEntrypoints::get('tests');
	}

	public function testInstance() {
		$this->assertInstanceOf(ReadEntrypoints::class, $this->instance);
	}

	public function testJs() {
		$this->assertEquals(['/build/runtime.js', '/build/app.js'], $this->instance->getJs());
	}

	public function testCss() {
		$this->assertEquals(['/build/app.css'], $this->instance->getCss());
	}

	public function testCssTag() {
		$this->assertEquals(
			'<link href="/build/app.css" rel="stylesheet">',
			$this->instance->getCssTags()
		);
	}

	public function testJsTag() {
		$this->assertEquals(
			'<script type="text/javascript" src="/build/runtime.js"></script>' .
			'<script type="text/javascript" src="/build/app.js"></script>',
			$this->instance->getJsTags()
		);
	}
}
