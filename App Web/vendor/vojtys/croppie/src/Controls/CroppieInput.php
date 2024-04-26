<?php
namespace Vojtys\Forms\Croppie;

use Nette\Forms\Controls\BaseControl;
use Nette\Utils\Html;

/**
 * Class CroppieInput
 * @package Vojtys\Forms\Croppie
 */
class CroppieInput extends BaseControl
{
	/** @var Configuration */
	protected $configuration;

	/**
	 * CroppieInput constructor.
	 * @param null $caption
	 * @param Configuration $configuration
	 */
	public function __construct($caption = NULL, Configuration $configuration)
	{
		parent::__construct($caption);
		$this->configuration = $configuration;
	}

	/**
	 * @return Html|string|static
	 */
	public function getControl()
	{
		$control = Html::el('div');
		$control->addAttributes([
			'class' => 'croppie-wrapper',
		]);
		$preview = Html::el('div');
		$preview->addAttributes([
			'class' => 'croppie-preview',
			'data-vojtys-forms-croppie' => '',
			'data-settings' => $this->configuration->getConfiguration(),
			'data-result-size' => $this->configuration->getResultSize(),
		]);
		$hidden = Html::el('input');
		$hidden->addAttributes([
			'class' => 'croppie-value',
			'value' => '',
			'type' => 'hidden',
			'name' => $this->getHtmlName(),
			'id' => $this->getHtmlId(),
			'required' => $this->isRequired(),
			'disabled' => $this->isDisabled(),
		]);
		$input = Html::el('input');
		$input->addAttributes([
			'class' => 'croppie-upload-btn form-control',
			'type' => 'file',
			'accept' => 'image/*',
			'value' => $this->caption
		]);
		$btn = Html::el('label');
		$btn->addAttributes([
			'class' => 'btn btn-primary btn-croppie mb-0',
			'for' => $this->getHtmlId()
		]);
		$btn->add(Html::el('span')->setText($this->caption));
		$btn->add($input);

		$control->add($preview);
		$control->add($btn);
		$control->add($hidden);

		return $control;
	}

	/**
	 * @return mixed|null|Image
	 */
	public function getValue()
	{
		$image = new Image($this->value);
		return $image->getValue();
	}
}