<?php

namespace Davletshindf\TelegramBugNotification;

use DateTime;
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
                        . "<b><i>" . $_SERVER['HTTP_HOST'] . "</i></b>\n"
                        . $exception->getFile() . ":" . $exception->getLine() . "\n"
                        . "<i>" . $exception->getMessage() . "</i>\n\n"
                        . "#error "
                        . $this->getHashtag($_SERVER['HTTP_HOST']) . " "
                        . $this->getHashtag(get_class($exception)) . " "
                        . $this->getHashtag('date_' . (new DateTime())->format('Y_m_d')),
                    'parse_mode' => 'html',
                ]
            ];

            $this->guzzle->post($url, $params);
        } catch (Throwable) {
        }
    }

    private function getHashtag(string $text): string
    {
        $text = str_replace('.', '_', $text);

        $text = str_replace('\\', '_', $text);

        return '#' . preg_replace("/[^a-zA-ZА-Яа-я0-9_\s]/", "", $text);
    }
}
