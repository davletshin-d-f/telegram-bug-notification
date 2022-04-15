<?php

namespace Davletshindf\TelegramBugNotification;

class Config
{
    /**
     * @param array $config
     *    $config = [
     *      'base_url'          => 'https://api.telegram.org',  // Telegram host
     *      'token'             => '',                          // Telegram bot token
     *      'chat_id'           => '',                          // Telegram chat id
     *      'file_storage'      => '',                          // Stacktrace file storage
     *      'stacktrace_url'    => '',                          // Stacktrace open url
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
        return $this->getFormattedUrlOrPath($this->config['base_url']);
    }

    public function getToken(): ?string
    {
        return $this->config['token'] ?? null;
    }

    public function getChatId(): null|string|int
    {
        return $this->config['chat_id'] ?? null;
    }

    public function getFileStorage(): ?string
    {
        return $this->getFormattedUrlOrPath($this->config['file_storage']);
    }

    public function getStacktraceUrl(): ?string
    {
        return $this->getFormattedUrlOrPath($this->config['stacktrace_url']);
    }

    public function getFormattedUrlOrPath(string $data): ?string
    {
        $result = rtrim($data ?? '', '/\\');

        return $result !== '' ? $result : null;
    }
}
