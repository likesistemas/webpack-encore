<?php

namespace Like\NomeDaLib\Tests;

use WebpackEncore\ReadEntrypoints;
use PHPUnit\Framework\TestCase;

class ReadEntrypointsErrorsTest extends TestCase {
	public function testFileNotFound() {
		$readEntrypoints = ReadEntrypoints::get('inexistent-folder');
		$this->assertEquals([], $readEntrypoints->getCss());
		$this->assertEquals([], $readEntrypoints->getJs());
	}

	public function testEmpty() {
		$readEntrypoints = ReadEntrypoints::get('tests/empty');
		$this->assertEquals([], $readEntrypoints->getCss());
		$this->assertEquals([], $readEntrypoints->getJs());
	}

	public function testEmpty2() {
		$readEntrypoints = ReadEntrypoints::get('tests/empty2');
		$this->assertEquals([], $readEntrypoints->getCss());
		$this->assertEquals([], $readEntrypoints->getJs());
	}
}
