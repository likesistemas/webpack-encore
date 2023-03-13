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

	public function getEntrypoints() {
		if (! isset($this->entrypoints['entrypoints']) || ! is_array($this->entrypoints['entrypoints'])) {
			return [];
		}

		return array_keys($this->entrypoints['entrypoints']);
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

	public function getCss($name=null) {
		if ($name) {
			return $this->getEntrypoint('css', $name);
		}

		return $this->getAllCss();
	}

	public function getAllCss() {
		return $this->getAll('css');
	}

	public function getAllJs() {
		return $this->getAll('js');
	}

	public function getAll($type) {
		$css = [];

		foreach ($this->getEntrypoints() as $entrypoint) {
			$css = array_merge($css, $this->getEntrypoint($type, $entrypoint));
		}

		return $css;
	}

	public function getJs($name=null) {
		if ($name) {
			return $this->getEntrypoint('js', $name);
		}

		return $this->getAllJs();
	}

	public function getJsTags($name=null, $template=self::SCRIPT_TAG) {
		$jsFiles = $this->getJs($name);
		if (! $jsFiles) {
			return null;
		}

		return array_reduce($jsFiles, function ($tags, $url) use ($template) {
			return $tags . sprintf($template, $url);
		}, '');
	}

	public function getCssTags($name=null, $template=self::STYLE_TAG) {
		$cssFiles = $this->getCss($name);
		if (! $cssFiles) {
			return null;
		}

		return array_reduce($cssFiles, function ($tags, $url) use ($template) {
			return $tags . sprintf($template, $url);
		}, '');
	}

	public static function get($publicAssets=self::PUBLIC_ASSETS, $cached=true) {
		if (! $cached) {
			$e = new ReadEntrypoints($publicAssets);
			$e->read();
			return $e;
		}

		static $entrypoints;

		if (! isset($entrypoints)) {
			$entrypoints = new ReadEntrypoints($publicAssets);
			$entrypoints->read();
		}

		return $entrypoints;
	}
}
