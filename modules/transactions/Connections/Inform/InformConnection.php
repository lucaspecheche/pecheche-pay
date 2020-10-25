<?php

namespace Transactions\Connections\Inform;

use Transactions\Exceptions\ConnectionExceptions;

class InformConnection
{
    protected $informClient;

    private const SUCCESS_SEND_MSG_STATUS = 'Enviado';

    public function __construct(InformClientInterface $informClient)
    {
        $this->informClient = $informClient;
    }

    public function send(string $message)
    {
        $response = $this->informClient->post(InformRoutes::sendMsg(), ['message' => $message]);
        $isSuccess = $response->isSuccess() && $response->get('message') === self::SUCCESS_SEND_MSG_STATUS;

        throw_unless($isSuccess, ConnectionExceptions::errorSendMsg($response->getContent()));
    }
}
