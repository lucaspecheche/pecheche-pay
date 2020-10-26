<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class BuildException extends Exception
{
    protected $message = 'Internal Error';
    protected $shortMessage;
    protected $description;
    protected $httpCode = Response::HTTP_UNPROCESSABLE_ENTITY;

    public function render()
    {
        return response($this->getError(), $this->httpCode);
    }

    public function setMessage(string $message): BuildException
    {
        $this->message = $message;
        return $this;
    }

    public function setDescription(string $description): BuildException
    {
        $this->description = $description;
        return $this;
    }

    public function setShortMessage(string $shortMessage): BuildException
    {
        $this->code         = $shortMessage;
        $this->shortMessage = $shortMessage;
        return $this;
    }

    public function setHttpCode(int $code): BuildException
    {
        $this->httpCode = $code;
        return $this;
    }

    public function getError(): array
    {
        return array_filter([
            'shortMessage'       => $this->shortMessage,
            'message'            => $this->message,
            'description'        => $this->description
        ]);
    }

    public static function new(): BuildException
    {
        return new static();
    }
}
