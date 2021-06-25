<?php

namespace WebpackEncore;

use Like\Json\Decode;

class ReadEntrypoints {
	
	/**
	 * @var string
	 */
	private $path;

	/**
	 * @var array
	 */
	private $entrypoints = [];

	const PUBLIC_ASSETS = 'public/build';
	const ENTRYPOINTS = 'entrypoints.json';
	const SCRIPT_TAG = '<script type="text/javascript" src="%s"></script>';
	const STYLE_TAG = '<link href="%s" rel="stylesheet">';

	private function __construct($path) {
		$this->path = $path;
	}

	public function read() {
		$file = $this->getRaiz() . '/../' . $this->path . '/' . self::ENTRYPOINTS;
		if (! file_exists($file)) {
			return;
		}

		$json = file_get_contents($file);
		$this->entrypoints = Decode::decode($json);
	}

	private function getRaiz() {
		$reflection = new \ReflectionClass(\Composer\Autoload\ClassLoader::class);
		return dirname(dirname($reflection->getFileName()));
	}

	public function getEntrypoint($type, $name='app') {
		if (! isset($this->entrypoints['entrypoints'])) {
			return [];
		}

		if (! isset($this->entrypoints['entrypoints'][$name])) {
			return [];
		}

		return $this->entrypoints['entrypoints'][$name][$type];
	}

	public function getCss($name='app') {
		return $this->getEntrypoint('css', $name);
	}

	public function getJs($name='app') {
		return $this->getEntrypoint('js', $name);
	}

	public function getJsTags($name='app', $template=self::SCRIPT_TAG) {
		$jsFiles = $this->getJs($name);
		if (! $jsFiles) {
			return null;
		}

		return array_reduce($jsFiles, function ($tags, $url) use ($template) {
			return $tags . sprintf($template, $url);
		}, '');
	}

	public function getCssTags($name='app', $template=self::STYLE_TAG) {
		$cssFiles = $this->getCss($name);
		if (! $cssFiles) {
			return null;
		}

		return array_reduce($cssFiles, function ($tags, $url) use ($template) {
			return $tags . sprintf($template, $url);
		}, '');
	}

	public static function get($publicAssets=self::PUBLIC_ASSETS) {
		static $entrypoints;

		if (! isset($entrypoints)) {
			$entrypoints = new ReadEntrypoints($publicAssets);
			$entrypoints->read();
		}

		return $entrypoints;
	}
}
