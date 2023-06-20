<?php


namespace Fastik1\Vkfast\Api;


use CurlHandle;
use Fastik1\Vkfast\Exceptions\CurlException;
use Fastik1\Vkfast\Exceptions\VkApiError;

class VkApiRequest
{
    private string $access_token;
    private float $version;
    private CurlHandle $curl;
    const API_URL = 'https://api.vk.com/method';
    private bool $ignore_error = false;

    public function __construct(string $access_token, float $version, bool $ignore_error)
    {
        $this->access_token = $access_token;
        $this->version = $version;
        $this->curl = curl_init();
        $this->ignore_error = $ignore_error;
    }

    public function apiRequest(string $method, array $parameters)
    {
        try {
            $response = $this->sendCurl([
                CURLOPT_URL => self::API_URL . '/' . $method . '?' . http_build_query($parameters + ['access_token' => $this->access_token, 'v' => $this->version]),
            ]);
        } catch (CurlException $e) {
            return false;
        }

        if (($response->error ?? null) and !$this->ignore_error) {
            throw new VkApiError($response->error->error_msg, $response->error->error_code);
        }

        return $response;
    }

    public function sendCurl(array $options = [])
    {
        curl_reset($this->curl);
        $options += [
            CURLOPT_RETURNTRANSFER => true,
        ];
        curl_setopt_array($this->curl, $options);

        $response = curl_exec($this->curl);

        if ($response === false) {
            throw new CurlException(curl_error($this->curl));
        }

        return json_decode($response);
    }
}