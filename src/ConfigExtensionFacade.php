<?php namespace GreyDev\ConfigExtension;

use Illuminate\Support\Facades\Facade;

class ConfigExtensionFacade extends Facade{
	protected static function getFacadeAccessor(){
		return 'config.extended';
	}

}