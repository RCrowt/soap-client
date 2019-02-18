<?php namespace App\Component\SoapClient;

use Illuminate\Contracts\Support\Arrayable;
use App\Component\SoapClient\Concerns\HasOptions;
use App\Component\SoapClient\Concerns\HasXml;
use App\Component\SoapClient\Concerns\HasData;

class SoapResponse implements Arrayable
{
	use HasData, HasXml, HasOptions;

	/**
	 * @var SoapRequest
	 */
	protected $request;

	/**
	 * SoapResponse constructor.
	 *
	 * @param array|object $data
	 * @param string       $xml
	 * @param SoapRequest  $request
	 */
	public function __construct($data = null, string $xml = null, SoapRequest $request)
	{
		$this->data($data);
		$this->setXml($xml);
		$this->request = $request;
	}

	/**
	 * @return SoapRequest
	 */
	public function getRequest(): SoapRequest
	{
		return $this->request;
	}

	/**
	 * Get the instance as an array.
	 *
	 * @return array
	 */
	public function toArray()
	{
		return json_decode(json_encode($this->data()), true);
	}
}