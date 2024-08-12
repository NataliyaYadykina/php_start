<?php

namespace Geekbrains\Application1\Domain\Models;

class SiteInfo
{
    private string $webServer;
    private string $phpVersion;
    private string $userAgent;

    public function __construct()
    {
        $this->webServer = $_SERVER['SERVER_SOFTWARE'];
        $this->phpVersion = phpversion();
        $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
    }

    public function getWebServer()
    {
        return $this->webServer;
    }

    public function getPhpVersion()
    {
        return $this->phpVersion;
    }

    public function getUserAgent()
    {
        return $this->userAgent;
    }

    public function getInfo(): array
    {
        return [
            'server' => $this->getWebServer(),
            'phpVersion' => $this->getPhpVersion(),
            'userAgent' => $this->getUserAgent()
        ];
    }
}
