<?php
namespace Vojtys\Forms\Croppie;

/**
 * Class Configuration
 * @package Vojtys\Forms\Croppie
 */
class Configuration
{
	const TYPE_CIRCLE = 'circle';
	const TYPE_SQUARE = 'square';
	const TYPE_SIZE_VIEWPORT = 'viewport';
	const TYPE_SIZE_ORIGINAL = 'original';
	const BOUNDARY = 100;

	const CONF_EXIF = 'enableExif';
	const CONF_VIEWPORT_WIDTH = 'width';
	const CONF_VIEWPORT_HEIGHT = 'height';
	const CONF_TYPE = 'type';
	const CONF_RESULT_SIZE = 'size';

	/** array $params */
	protected $params;

	/**
	 * Configuration constructor.
	 * @param array $params
	 */
	public function __construct(array $params = [])
	{
		$this->params = $params;
	}

	public function getConfiguration()
	{
		return [
			'viewport' => [
				self::CONF_VIEWPORT_WIDTH => $this->getWidth(),
				self::CONF_VIEWPORT_HEIGHT => $this->getHeight(),
				self::CONF_TYPE => $this->getType()
			],
			'boundary' => [
				self::CONF_VIEWPORT_WIDTH => ($this->getWidth() + self::BOUNDARY),
				self::CONF_VIEWPORT_HEIGHT => ($this->getHeight() + self::BOUNDARY)
			]
		];
	}

	public function getWidth()
	{
		return $this->params[ self::CONF_VIEWPORT_WIDTH ];
	}

	public function getHeight()
	{
		return $this->params[ self::CONF_VIEWPORT_HEIGHT ];
	}

	public function getExif()
	{
		return $this->params[ self::CONF_EXIF ];
	}

	public function getType()
	{
		return $this->params[ self::CONF_TYPE ];
	}

	public function getResultSize()
	{
		return $this->params[ self::CONF_RESULT_SIZE ];
	}
}