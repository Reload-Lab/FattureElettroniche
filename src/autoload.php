<?php
/***
 * F5 - Fatture elettroniche
 * 
 * Copyright © 2023
 * Reload - Laboratorio Multimediale
 * (https://www.reloadlab.it - info@reloadlab.it)
 * 
 * authors: Domenico Gigante (domenico.gigante@reloadlab.it)
 ***/

function f5app_autoload($classname){

	if(preg_match('/^F5/i', $classname)){

		$classname = str_replace('F5\\', '', $classname);
		$classpath = str_replace("\\", DIRECTORY_SEPARATOR, $classname);
		$filename = __DIR__.DIRECTORY_SEPARATOR.$classpath.'.php';
		if(file_exists($filename)){

			require_once($filename);
		}
	}
}

spl_autoload_register('f5app_autoload');