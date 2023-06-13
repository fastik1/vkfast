<?php


namespace Fastik1\Vkfast\Api;


use CurlHandle;
use Fastik1\Vkfast\Exceptions\CurlException;

class VkApiRequest
{
    private string $access_token;
    private float $version;
    private CurlHandle $curl;
    const API_URL = 'https://api.vk.com/method';

    public function __construct(string $access_token, float $version)
    {
        $this->access_token = $access_token;
        $this->version = $version;
        $this->curl = curl_init();
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