<?php namespace App\Component\SoapClient;

use App\Component\SoapClient\Concerns\HasXml;
use App\Component\SoapClient\Concerns\HasData;
use App\Component\SoapClient\Concerns\HasOptions;

class SoapRequest
{
	use HasOptions, HasData, HasXml;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * ViewSoapRequest constructor.
	 *
	 * @param array $data
	 * @param array $options
	 */
	public function __construct(array $data = [], array $options = [])
	{
		$this->data($data);
		$this->options(array_merge($this->options, $options));
	}

	/**
	 * Get the soap function name.
	 *
	 * @return string
	 */
	public function getSoapFunction(): string
	{
		return $this->getOption('soap.function', $this->name);
	}

	/**
	 * Get the soap XML Body.
	 *
	 * @return string|array
	 */
	public function getSoapBody(): array
	{
		return (array)$this->data();
	}

	/**
	 * @return array
	 */
	public function getSoapOptions(): array
	{
		return $this->getOption('soap.options', []);
	}


	public function getSoapResponseHandler(): string
	{
		return $this->getOption('soap_response', SoapResponse::class);
	}
}