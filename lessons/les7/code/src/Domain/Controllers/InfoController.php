<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Geekbrains\Application1\Domain\Models\SiteInfo;
use Geekbrains\Application1\Application\Render;

class InfoController
{
    public function actionIndex(): string
    {
        $siteInfo = new SiteInfo();

        $render = new Render();
        return $render->renderPage('site-info.twig', [
            'server' => $siteInfo->getWebServer(),
            'phpVersion' => $siteInfo->getPhpVersion(),
            'userAgent' => $siteInfo->getUserAgent()
        ]);
    }
}
