<?php


namespace App\Component\SoapClient\Concerns;


trait HasXml
{
	protected $xml;

	/**
	 * @return null|string
	 */
	public function getXml():?string
	{
		return $this->xml;
	}

	/**
	 * @param string|null $xml
	 */
	public function setXml(string $xml = null)
	{
		$this->xml = $xml;
	}
}