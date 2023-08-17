<?php

namespace App\Controller\Tests;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tests', name: 'app_tests_', condition: "'dev' === '%kernel.environment%'")]
class TestsController extends AbstractController
{
    #[Route('/webpack', name: 'webpack')]
    public function testWebpackIndex(): Response
    {
        return $this->render('tests/test_webpack.html.twig', [
            'controller_name' => 'TestsController',
        ]);
    }

    #[Route('/jsx', name: 'jsx')]
    public function testJsxIndex(): Response
    {
        return $this->render('tests/test_jsx.html.twig', [
            'controller_name' => 'TestsController',
        ]);
    }
}