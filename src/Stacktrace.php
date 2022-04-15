<?php

namespace Davletshindf\TelegramBugNotification;

use DateTime;
use Throwable;

class Stacktrace
{
    protected string $fileDir;
    protected string $fileName;

    public function __construct(
        protected Config $config,
        protected Throwable $exception
    )
    {
        $this->setFileName();
    }

    public function getStacktrace(): ?string
    {
        if (
            !empty($this->config->getFileStorage()) &&
            !empty($this->config->getStacktraceUrl()) &&
            $this->saveFile()
        ) {
            return '<a href="' . $this->config->getStacktraceUrl() . '/' . $this->getFileName() . '">stacktrace</a>';
        }

        return null;
    }

    private function saveFile(): bool
    {
        try {
            $content = [
                "HOST: " . $_SERVER['HTTP_HOST'] . "\n",
                "ROUTE: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "\n",
                "DATE TIME: " . (new DateTime())->format(DateTime::ATOM) . "\n",
                "EXCEPTION CLASS: " . get_class($this->exception) . "\n",
                "EXCEPTION FILE: " . $this->exception->getFile() . ":" . $this->exception->getLine() . "\n",
                "\n",
                "===== EXCEPTION TRACE =====" . "\n",
                $this->exception->getTraceAsString(),
            ];

            file_put_contents($this->getFullFileName(), $content);

            return true;
        } catch (Throwable) {
            return false;
        }
    }

    private function setFileName(): void
    {
        $this->fileDir = $this->config->getFileStorage();

        if (!is_dir($this->fileDir)) {
            mkdir($this->fileDir, 0644);
        }

        $dateTime = (new DateTime())->format('Y_m_d_H_i_s');

        $hash = hash('sha256', $dateTime . $this->exception->getTraceAsString());

        $this->fileName = $dateTime . '_' . $hash;
    }

    private function getFileName(): ?string
    {
        return $this->fileName;
    }

    private function getFullFileName(): ?string
    {
        return $this->fileDir . '/' . $this->fileName;
    }
}
