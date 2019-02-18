<?php namespace App\Component\SoapClient;

use Illuminate\Http\Request;

class SoapRuntimeException extends \RuntimeException
{
	/**
	 * @var SoapResponse
	 */
	protected $response;

	/**
	 * @param string          $message [optional] The Exception message to throw.
	 * @param int             $code    [optional] The Exception code.
	 * @param \SoapFault|null $fault
	 * @param SoapResponse    $response
	 */
	public function __construct($message = "", $code = 0, \SoapFault $fault = null, SoapResponse $response)
	{
		$this->response = $response;

		parent::__construct($message, $code, $fault);
	}

	/**
	 * Get the actual soap response.
	 *
	 * @return SoapResponse
	 */
	public function getResponse(): SoapResponse
	{
		return $this->response;
	}
	/**
	 * Get the SoapFault if available.
	 *
	 * @return \SoapFault|null|\Exception
	 */
	public function getFault(): ?\SoapFault
	{
		return $this->getPrevious();
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function render(Request $request)
	{
		return response()->json(['message' => $this->getMessage()]);
	}
}