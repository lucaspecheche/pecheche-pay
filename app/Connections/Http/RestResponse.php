<?php

namespace App\Connections\Http;

use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Response;

class RestResponse
{
    protected $body;
    protected $content;
    protected $statusCode;
    protected $success = false;

    public static function success(Response $response): RestResponse
    {
        $content = $response->getBody() ? $response->getBody()->getContents() : null;

        return (new static())
            ->setContent($content)
            ->setStatusCode($response->getStatusCode())
            ->setSuccess();
    }

    public static function failure(BadResponseException $exception): RestResponse
    {
        $body = $exception->getResponse()
            ? $exception->getResponse()->getBody()
            : null;

        $statusCode = $exception->getResponse()
            ? $exception->getResponse()->getStatusCode()
            : null;

        return (new static())
            ->setContent($body ? $body->getContents() : null)
            ->setStatusCode($statusCode)
            ->setSuccess(false);
    }


    public function getStatus(): ?int
    {
        return $this->statusCode;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function toArray(): array
    {
        $response = json_decode($this->getContent(), true);
        return is_array($response) ? $response : [];
    }

    public function get(string $key = null)
    {
        return $key
            ? data_get($this->toArray(), $key, null)
            : $this->content;
    }

    public function setContent($content): RestResponse
    {
        $this->content = $content;
        return $this;
    }

    public function setStatusCode($statusCode): RestResponse
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function setSuccess(bool $success = true): RestResponse
    {
        $this->success = $success;
        return $this;
    }
}
