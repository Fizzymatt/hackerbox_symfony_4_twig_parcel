<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Helpers\ClientBundleHelpers;


class CodeSplittingController extends AbstractController
{
    /**
     * @Route("/codesplitting", name="codeSplitting")
     */
    public function index()
    {
        return $this->render(
            'codeSplitting/index.html.twig',
            [
                'essential_styles' => ClientBundleHelpers::getEssentialCssInline(),
                'essential_scripts' => ClientBundleHelpers::getEssentialJsInline(),
                'bundled_styles' => ClientBundleHelpers::getBundlePath('codeSplitting', 'index.css'),
                'bundled_scripts' => ClientBundleHelpers::getBundlePath('codeSplitting', 'index.js')
            ]
        );
    }
}