<?php

namespace WebpackEncore;

use Smarty;

class SmartyTemplateIntegration {
	public static function addFunctions(Smarty $smarty, ReadEntrypoints $readEntrypoints) {
		$smarty->registerPlugin('function', 'webpack_encore_css', function ($params) use ($readEntrypoints) {
			return $readEntrypoints->getCssTags($params['name'] ?: 'app');
		});
		$smarty->registerPlugin('function', 'webpack_encore_js', function ($params) use ($readEntrypoints) {
			return $readEntrypoints->getJsTags($params['name'] ?: 'app');
		});
	}
}
