<?php namespace GreyDev\ConfigExtension;

use Illuminate\Support\ServiceProvider;

class ConfigExtensionProvider extends ServiceProvider{
	public function register(){
		$this->app->singleton('config.extended', function(){
			return new Config($this->app['config']);
		});
	}
}