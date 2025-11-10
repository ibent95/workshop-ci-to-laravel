<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http as HttpClient;
use Illuminate\Http\Client\Response as HttpResponse;
use Illuminate\Http\Client\RequestException as HttpRequestException;

class CommonService
{
	public function __construct(
		protected HttpClient $httpClient,
	) {}

	/** Get the id
	 *
	 * @return string
	 */
	public function generateId(): string
	{
		return DB::select('SELECT UUID_SHORT() AS uuidShort;')[0]->uuidShort;
	}

	/** Get the uuid version 4
	 *
	 * @return string
	 */
	public function generateUuid(): string
	{
		return Str::uuid();
	}

	/** Get the uuid version 7
	 *
	 * @return string
	 */
	public function generateUuidV7(): string
	{
		return Str::uuid7();
	}

	/**
	 * Send a GET request.
	 *
	 * @param string $url             The URL to send the request to
	 * @param mixed  $body            The request body
	 * @param array  $queryParameters Query parameters for the request
	 * @param array  $headers         Headers to include in the request
	 *
	 * @return HttpResponse
	 */
	public function httpGet(
		string $url,
		mixed $body,
		array $queryParameters = [],
		array $headers = []
	): HttpResponse {
		$this->results = $this->httpClient::withQueryParameters($queryParameters)
			->withHeaders($headers)
			->get($url, $body);

		if ($this->results->failed()) {
			$this->results->throw(
				fn(HttpResponse $response, HttpRequestException $exception)
				=> $this->httpThrowException($url, $response, $exception)
			);
		}

		return $this->results;
	}

	/**
	 * Send a POST request.
	 *
	 * @param string       $url             The URL to send the request to
	 * @param mixed        $body            The request body
	 * @param array | null $queryParameters Query parameters for the request
	 * @param array | null $headers         Headers to include in the request
	 *
	 * @return HttpResponse
	 */
	public function httpPost(
		string $url,
		mixed $body,
		?array $queryParameters = [],
		?array $headers = []
	): HttpResponse {
		$this->results = $this->httpClient::withQueryParameters($queryParameters)
			->withHeaders($headers)
			->post($url, $body);

		if ($this->results->failed()) {
			$this->results->throw(
				fn(HttpResponse $response, HttpRequestException $exception)
				=> $this->httpThrowException($url, $response, $exception)
			);
		}

		return $this->results;
	}

	/**
	 * Send a PUT request.
	 *
	 * @param string       $url             The URL to send the request to
	 * @param mixed        $body            The request body
	 * @param array | null $queryParameters Query parameters for the request
	 * @param array | null $headers         Headers to include in the request
	 *
	 * @return HttpResponse
	 */
	public function httpPut(
		string $url,
		mixed $body,
		array $queryParameters = [],
		array $headers = []
	): HttpResponse {
		$this->results = $this->httpClient::withQueryParameters($queryParameters)
			->withHeaders($headers)
			->put($url, $body);

		if ($this->results->failed()) {
			$this->results->throw(
				fn(HttpResponse $response, HttpRequestException $exception)
				=> $this->httpThrowException($url, $response, $exception)
			);
		}

		return $this->results;
	}

	/**
	 * Send a DELETE request.
	 *
	 * @param string       $url             The URL to send the request to
	 * @param mixed        $body            The request body
	 * @param array | null $queryParameters Query parameters for the request
	 * @param array | null $headers         Headers to include in the request
	 *
	 * @return HttpResponse
	 */
	public function httpDelete(
		string $url,
		mixed $body,
		array $queryParameters = [],
		array $headers = []
	): HttpResponse {
		$this->results = $this->httpClient::withQueryParameters($queryParameters)
			->withHeaders($headers)
			->delete($url, $body);

		if ($this->results->failed()) {
			$this->results->throw(
				fn(HttpResponse $response, HttpRequestException $exception)
				=> $this->httpThrowException($url, $response, $exception)
			);
		}

		return $this->results;
	}

	/**
	 * Send a GET request asynchronously.
	 *
	 * @param string       $url             The URL to send the request to
	 * @param mixed        $body            The request body
	 * @param array | null $queryParameters Query parameters for the request
	 * @param array | null $headers         Headers to include in the request
	 *
	 * @return HttpResponse
	 */
	public function httpGetAsync(
		string $url,
		mixed $body,
		array $queryParameters = [],
		array $headers = []
	): HttpResponse {
		$this->results = $this->httpClient::withQueryParameters($queryParameters)
			->withHeaders($headers)
			->getAsync($url, $body);

		if ($this->results->failed()) {
			$this->results->throw(
				fn(HttpResponse $response, HttpRequestException $exception)
				=> $this->httpThrowException($url, $response, $exception)
			);
		}

		return $this->results;
	}

	/**
	 * Send a POST request asynchronously.
	 *
	 * @param string       $url             The URL to send the request to
	 * @param mixed        $body            The request body
	 * @param array | null $queryParameters Query parameters for the request
	 * @param array | null $headers         Headers to include in the request
	 *
	 * @return HttpResponse
	 */
	public function httpPostAsync(
		string $url,
		mixed $body,
		array $queryParameters = [],
		array $headers = []
	): HttpResponse {
		$this->results = $this->httpClient::withQueryParameters($queryParameters)
			->withHeaders($headers)
			->postAsync($url, $body);

		if ($this->results->failed()) {
			$this->results->throw(
				fn(HttpResponse $response, HttpRequestException $exception)
				=> $this->httpThrowException($url, $response, $exception)
			);
		}

		return $this->results;
	}

	/**
	 * Send a PUT request asynchronously.
	 *
	 * @param string       $url             The URL to send the request to
	 * @param mixed        $body            The request body
	 * @param array | null $queryParameters Query parameters for the request
	 * @param array | null $headers         Headers to include in the request
	 *
	 * @return HttpResponse
	 */
	public function httpPutAsync(
		string $url,
		mixed $body,
		array $queryParameters = [],
		array $headers = []
	): HttpResponse {
		$this->results = $this->httpClient::withQueryParameters($queryParameters)
			->withHeaders($headers)
			->putAsync($url, $body);

		if ($this->results->failed()) {
			$this->results->throw(
				fn(HttpResponse $response, HttpRequestException $exception)
				=> $this->httpThrowException($url, $response, $exception)
			);
		}

		return $this->results;
	}

	/**
	 * Send a DELETE request asynchronously.
	 *
	 * @param string       $url             The URL to send the request to
	 * @param mixed        $body            The request body
	 * @param array | null $queryParameters Query parameters for the request
	 * @param array | null $headers         Headers to include in the request
	 *
	 * @return HttpResponse
	 */
	public function httpDeleteAsync(
		string $url,
		mixed $body,
		array $queryParameters = [],
		array $headers = []
	): HttpResponse {
		$this->results = $this->httpClient::withQueryParameters($queryParameters)
			->withHeaders($headers)
			->deleteAsync($url, $body);

		if ($this->results->failed()) {
			$this->results->throw(
				fn(HttpResponse $response, HttpRequestException $exception)
				=> $this->httpThrowException($url, $response, $exception)
			);
		}

		return $this->results;
	}

	/**
	 * Handle HTTP exceptions.
	 *
	 * @param string               $url       The URL that was requested
	 * @param HttpResponse         $response  The HTTP response received
	 * @param HttpRequestException $exception The exception that was thrown
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	private function httpThrowException(
		string $url,
		HttpResponse $response,
		HttpRequestException $exception
	): void {
		throw new GeneralException(
			"Gagal mengakses {$url}. Response : "
				. json_encode($response)
				. ". Exception : "
				. $exception->getMessage()
				. ". Body : "
				. $response->body(),
			400,
			$exception
		);
	}
}
