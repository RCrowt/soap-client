<?php namespace App\Component\SoapClient\Request;

use Illuminate\View\View;
use App\Component\SoapClient\SoapRequest;

class ViewSoapRequest extends SoapRequest
{
	/**
	 * Get the soap XML Body.
	 *
	 * @return string|array
	 */
	public function getSoapBody(): array
	{
		return [new \SoapVar($this->getBodyView()->render(), XSD_ANYXML)];
	}

	/**
	 * Get the XML View name.
	 *
	 * @return mixed
	 */
	protected function getBodyViewName(): string
	{
		return $this->getOption('body_view');
	}

	/**
	 * Get the XML view data.
	 *
	 * @return array
	 */
	protected function getBodyViewData(): array
	{
		return [
			'request' => $this,
		];
	}

	/**
	 * Get the XML View instance.
	 *
	 * @return View
	 */
	protected function getBodyView(): View
	{
		return view($this->getBodyViewName(), $this->getBodyViewData());
	}

}