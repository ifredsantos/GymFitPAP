<?php
namespace Vojtys\Forms\Croppie;

use Nette;

/**
 * Class Image
 * @package Vojtys\Forms\Croppie
 */
class Image
{
	/** @var array */
	protected $data;

	/** @var Nette\Utils\Image */
	protected $image;

	/**
	 * Image constructor.
	 * @param $data
	 */
	public function __construct($data)
	{
		$this->data = $this->jsonDecode($data);
		$this->image = $this->createImage();
	}

	/**
	 * @return null|Image
	 */
	public function getValue()
	{
		return empty($this->getNetteImage()) ? null : $this;
	}

	/**
	 * @return Nette\Utils\Image
	 */
	public function getNetteImage()
	{
		return $this->image;
	}

	/**
	 * @return null|string
	 */
	public function getName()
	{
		return isset($this->data['fileinfo']['name']) ?
			$this->data['fileinfo']['name'] :
			null;
	}

	/**
	 * @return null|string
	 */
	public function getType()
	{
		return isset($this->data['fileinfo']['type']) ?
			$this->data['fileinfo']['type'] :
			null;
	}

	/**
	 * @return null|Nette\Utils\Image
	 */
	private function createImage()
	{
		if (empty($this->data)) {
			return null;
		}

		try {
			$imageData = $this->data['image'];
			list($type, $imageData) = explode(';', $imageData);
			list(, $imageData) = explode(',', $imageData);
			$image = Nette\Utils\Image::fromString(base64_decode($imageData));
		} catch (Nette\Utils\ImageException $e) {
			return null;
		}

		return $image;
	}

	/**
	 * @param $rawData
	 * @return array|null
	 */
	private function jsonDecode($rawData)
	{
		try {
			$data = Nette\Utils\Json::decode($rawData, \Nette\Utils\Json::FORCE_ARRAY);
		} catch (Nette\Utils\JsonException $e) {
			return null;
		}

		return $data;
	}
}