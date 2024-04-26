<?php
namespace Vojtys\Forms\Croppie;

use Nette;
use Nette\Forms\Container;

/**
 * Class CroppieExtension
 * @package Vojtys\Forms\Croppie
 */
class CroppieExtension extends Nette\DI\CompilerExtension
{
	protected $defaults = [
		Configuration::CONF_VIEWPORT_WIDTH => 300,
		Configuration::CONF_VIEWPORT_HEIGHT => 300,
		Configuration::CONF_EXIF => true,
		Configuration::CONF_TYPE => Configuration::TYPE_SQUARE,
		Configuration::CONF_RESULT_SIZE => Configuration::TYPE_SIZE_VIEWPORT,
	];

	public function loadConfiguration()
	{
		$this->validateConfig($this->defaults);
	}

	/**
	 * @param Nette\PhpGenerator\ClassType $classType
	 */
	public function afterCompile(Nette\PhpGenerator\ClassType $classType)
	{
		$configuration =  new Configuration($this->getConfig($this->config));
		$initialize = $classType->getMethod('initialize');
		$initialize->addBody('Vojtys\Forms\Croppie\CroppieExtension::bind(?);', [$configuration]);
	}

	/**
	 * @param Configuration $configuration
	 */
	public static function bind(Configuration $configuration)
	{
		Container::extensionMethod('addCroppie', function($container, $name, $label = NULL) use ($configuration) {
			return $container[ $name ] = new CroppieInput($label, $configuration);
		});
	}
}