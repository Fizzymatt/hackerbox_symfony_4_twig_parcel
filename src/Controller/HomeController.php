<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Helpers\ClientBundleHelpers;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render(
            'home/index.html.twig',
            [
                'essential_styles' => ClientBundleHelpers::getEssentialCssInline(),
                'essential_scripts' => ClientBundleHelpers::getEssentialJsInline(),
                'bundled_styles' => ClientBundleHelpers::getBundlePath('homePage', 'index.css'),
                'bundled_scripts' => ClientBundleHelpers::getBundlePath('homePage', 'index.js')
            ]
        );
    }
}