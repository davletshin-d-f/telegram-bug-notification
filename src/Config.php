<?php

namespace Davletshindf\TelegramBugNotification;

class Config
{
    /**
     * @param array $config
     *    $config = [
     *      'base_url'  => 'https://api.telegram.org',  // Telegram host
     *      'token'     => '',                          // Telegram bot token
     *      'chat_id'   => '',                          // Telegram chat id
     *    ]
     */
    public function __construct(protected array $config)
    {
        if (empty($this->config['base_url'])) {
            $this->config['base_url'] = 'https://api.telegram.org';
        }
    }

    public function getBaseUrl(): ?string
    {
        $url = trim($this->config['base_url'] ?? '', '/');

        return $url !== '' ? $url : null;
    }

    public function getToken(): ?string
    {
        return $this->config['token'] ?? null;
    }

    public function getChatId(): null|string|int
    {
        return $this->config['chat_id'] ?? null;
    }
}
