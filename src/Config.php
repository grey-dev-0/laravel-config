<?php namespace GreyDev\ConfigExtension;

use Illuminate\Config\Repository;
use Illuminate\Support\Arr;

class Config extends Repository{
	/**
	 * Config extension constructor, referring to the original repository's data.
	 *
	 * @param Repository $config original configuration Repository object.
	 */
	public function __construct($config){
		$this->items = &$config->items;
	}

	/**
	 * Create a new config file in the default configuration directory.
	 *
	 * @param string $filename Filename of the config file to be created.
	 * @param array $data Array of data to be saved in the config file.
	 */
	public function create($filename, $data){
		$configFile = fopen(config_path()."/$filename.php", 'w');
		fwrite($configFile, "<?php\nreturn ".$this->process($data).';');
	}

	/**
	 * Save a configuration parameter to an existing config file.
	 *
	 * @param string $key Dont notation key of the setting to be saved.
	 * @param mixed $value Data to be set for the selected key.
	 */
	public function save($key, $value){
		$filename = explode('.', $key)[0];
		$configFile = config_path()."/$filename.php";
		$configData = require $configFile;
		if(!is_array($value)){
			if(!is_numeric($value))
				$value = (!is_bool($value))? str_replace('\'', '\\\'', $value) : $value;
		}
		Arr::set($configData, preg_replace("#^$filename.#", '', $key), $value);
		$configFileHandle = fopen($configFile, 'w');
		fwrite($configFileHandle, "<?php\nreturn ".$this->process($configData).';');
	}

	/**
	 * Process and format data to be saved to the config file.
	 *
	 * @param array $data Array of data to be processed and formatted.
	 * @param int $indentation Tab indentations count to be prefixed for the saved data.
	 * @return string Data stringified and processed to be saved.
	 */
	private function process($data, $indentation = 0){
		$tabs = '';
		for($i=0; $i < $indentation; $i++)
			$tabs .= "\t";
		$configString = "[\n";
		foreach($data as $key => $value){
			if(!is_array($value)){
				if(!is_numeric($value))
					$value = (!is_bool($value))? '\''.str_replace('\'', '\\\'', $value).'\'' : (($value == true)? 'true' : 'false');
				$configString .= "$tabs\t'$key' => $value,\n";
			} else
				$configString .= "$tabs\t'$key' => ".$this->process($value, $indentation+1).",\n";
		}
		return $configString."$tabs]";
	}
}