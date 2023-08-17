<?php

namespace App\Controller\Tests;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Object\CustomTranslationObject;

#[Route('/test/variabilization', name: 'app_test_varibilization_', condition: "'dev' === '%kernel.environment%'")]
class TestVariabilizationController extends AbstractController
{
    #[Route('/html/twig', name: 'html_twig')]
    public function testHtmlTwigIndex(): Response
    {
        // Load Translations
        CustomTranslationObject::load([
            "tests/layout.yaml",
            "tests/pages/page1.yaml",
        ]) ;

        return $this->render('tests/test_variabilization_page1.html.twig', [
            'controller_name' => 'TestVariabilizationController',
        ]);
    }

    #[Route('/js/jsx', name: 'js_jsx')]
    public function testJsJsxIndex(): Response
    {
        // Load Translations
        CustomTranslationObject::load([
            "tests/layout.yaml",
            "tests/pages/page2.yaml",
        ]) ;

        // Get Translations
        $siteTranslation = CustomTranslationObject::get([
            "tests/pages/page2.yaml",
        ]) ;

        return $this->render('tests/test_variabilization_page2.html.twig', [
            'controller_name' => 'TestVariabilizationController',
            'siteTranslation' => $siteTranslation,
        ]);
    }
}