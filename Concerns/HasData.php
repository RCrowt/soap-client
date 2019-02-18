<?php namespace App\Component\SoapClient\Concerns;

use Illuminate\Support\Collection;

trait HasData
{
	/**
	 * @var
	 */
	protected $data;

	/**
	 * @param array|null $data
	 *
	 * @return array|object
	 */
	public function data($data = null)
	{
		if ($data !== null) {
			$this->data = $data;
		}

		return $this->data;
	}

	/**
	 * @param $key
	 * @param $value
	 *
	 * @return $this
	 */
	public function setData($key, $value)
	{
		data_set($this->data, $key, $value);

		return $this;
	}

	/**
	 * @param string $key
	 * @param null   $default
	 *
	 * @return mixed
	 */
	public function getData($key, $default = null)
	{
		return data_get($this->data(), $key, $default);
	}

	/**
	 * @param $key
	 * @param $default
	 *
	 * @return Collection
	 */
	public function getDataCollection($key, $default = []): Collection
	{
		return collect($this->getData($key, $default));
	}
}