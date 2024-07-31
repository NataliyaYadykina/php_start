<?php

namespace Geekbrains\Application1\Application;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class Render
{

    private string $viewFolder = '/Domain/Views/';
    private FilesystemLoader $loader;
    private Environment $environment;


    public function __construct()
    {

        $this->loader = new FilesystemLoader(dirname(__DIR__) . $this->viewFolder);
        $this->environment = new Environment($this->loader, [
            // 'cache' => $_SERVER['DOCUMENT_ROOT'].'/cache/',
        ]);
    }

    public function renderPage(string $contentTemplateName = 'page-index.twig', array $templateVariables = [])
    {
        $template = $this->environment->load('layouts/main.twig');

        $templateVariables['content_template_name'] = $contentTemplateName;
        $templateVariables['title'] = 'Главная страница';

        return $template->render($templateVariables);
    }
}
