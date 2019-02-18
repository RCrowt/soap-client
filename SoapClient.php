<?php namespace App\Component\SoapClient;

use App\Component\SoapClient\Concerns\HasOptions;
use Illuminate\Pipeline\Pipeline;

class SoapClient extends \SoapClient
{
	use HasOptions;

	/**
	 * @var array
	 */
	protected $requests;

	/**
	 * SoapClient constructor.
	 *
	 * @param array $options
	 */
	public function __construct(array $options = [])
	{
		$this->options($options);

		parent::__construct($this->getSoapWsdl(), $this->getSoapOptions());
		$this->__setSoapHeaders($this->getSoapHeaders());
	}

	/**
	 * Send a soap request and get a response.
	 *
	 * @param SoapRequest $request
	 *
	 * @return mixed
	 * @throws \Exception
	 * @internal param string $method
	 * @internal param array $parameters
	 */
	public function send(SoapRequest $request): SoapResponse
	{
		return (new Pipeline(app()))
			->send($request)
			->through($this->getMiddleware())
			->then(
				function (SoapRequest $request) {
					return $this->soapCall($request);
				}
			);
	}

	/**
	 * Get the response handler class.
	 *
	 * @return string
	 */
	protected function getResponseHandler(): string
	{
		return $this->getOption('response_handler', SoapResponse::class);
	}

	/**
	 * Get middleware to send the request/response through.
	 *
	 * @return array
	 */
	protected function getMiddleware(): array
	{
		return (array)$this->getOption('middleware', []);
	}

	/**
	 * Get the \SoapClient WSDL location.
	 *
	 * @return string
	 */
	protected function getSoapWsdl(): string
	{
		return $this->getOption('soap.wsdl');
	}

	/**
	 * Get the \SoapClient Options.
	 *
	 * @return array
	 */
	protected function getSoapOptions(): array
	{
		return $this->getOption('soap.options', []);
	}

	/**
	 * Get the \SoapClient Headers.
	 *
	 * @return mixed
	 */
	protected function getSoapHeaders(): array
	{
		return $this->getOption('soap_headers', []);
	}

	/**
	 * Send the soap request.
	 *
	 * @param SoapRequest $request
	 *
	 * @return SoapResponse
	 */
	protected function soapCall(SoapRequest $request): SoapResponse
	{
		try {
			$response = $this->makeResponse(
				$request,
				$this->__soapCall(
					$request->getSoapFunction(),
					$request->getSoapBody(),
					$request->getSoapOptions()
				)
			);
			$this->setRequestXml($request);

			return $response;

		} catch (\SoapFault $fault) {

			$response = $this->makeResponse($request);
			$this->setRequestXml($request);

			throw new SoapRuntimeException(
				'SoapFault: '.$fault->getMessage(),
				$this->getLastResponseHttpStatus(),
				$fault,
				$response
			);
		}
	}

	/**
	 * @param SoapRequest                 $request
	 * @param array|string|null|\stdClass $responseData
	 *
	 * @return SoapResponse
	 */
	protected function makeResponse(SoapRequest $request, $responseData = null): SoapResponse
	{
		return app(
			$request->getSoapResponseHandler(),
			[
				'handler'    => $this->getResponseHandler(),
				'client'     => $this,
				'request'    => $request,
				'requestXml' => $this->__getLastRequest(),
				'data'       => $responseData,
				'xml'        => $this->__getLastResponse(),
				'headers'    => $this->__getLastResponseHeaders(),
			]
		);
	}

	/**
	 * @param SoapRequest $request
	 */
	protected function setRequestXml(SoapRequest $request)
	{
		$request->setXml($this->__getLastRequest());
	}

	/**
	 * @return int
	 */
	protected function getLastResponseHttpStatus(): int
	{
		$headers = $this->__getLastResponseHeaders();
		$matches = null;

		if (preg_match('#^HTTP\/\d\.\d\s+(\d{3}).*$#im', $headers, $matches)) {
			return (int)$matches[1];
		}

		return 0;
	}
}