<?php namespace App\Component\SoapClient\Concerns;

trait HasOptions
{
	/**
	 * @var array
	 */
	protected $options = [];

	/**
	 * @param array|null $options
	 *
	 * @return array
	 */
	public function options(array $options = null)
	{
		if ($options !== null) {
			$this->options = $options;
		}

		return $this->options;
	}

	/**
	 * @param $key
	 * @param $value
	 *
	 * @return $this
	 */
	public function setOption($key, $value)
	{
		array_set($this->options, $key, $value);

		return $this;
	}

	/**
	 * @param string $key
	 * @param null   $default
	 *
	 * @return mixed
	 */
	public function getOption($key, $default = null)
	{
		return array_get($this->options(), $key, $default);
	}
}