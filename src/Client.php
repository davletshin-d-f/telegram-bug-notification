<?php

namespace Davletshindf\TelegramBugNotification;

use GuzzleHttp\Client as GuzzleClient;
use Throwable;

class Client
{
    protected GuzzleClient $guzzle;

    public function __construct(protected Config $config)
    {
        $this->guzzle = new GuzzleClient();
    }

    public function notify(Throwable $exception): void
    {
        try {
            $url = $this->config->getBaseUrl()
                . '/bot'
                . $this->config->getToken()
                . '/sendMessage';

            $params = [
                'form_params' => [
                    'chat_id' => $this->config->getChatId(),
                    'text' => "<b>Error</b>\n"
                        . "<b><i>" . $_SERVER['SERVER_NAME'] . "</i></b>\n"
                        . $exception->getFile() . ":" . $exception->getLine() . "\n"
                        . "<i>" . $exception->getMessage() . "</i>\n\n"
                        . "#error #" . str_replace('.', '_', $_SERVER['SERVER_NAME']) . " #" . str_replace('\\', '_', get_class($exception)),
                    'parse_mode' => 'html',
                ]
            ];

            $this->guzzle->post($url, $params);
        } catch (Throwable) {}
    }
}
