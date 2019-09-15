<?php

namespace App\Controller\Helpers;


class ClientBundleHelpers {
    /**
     * @return bool|string
     */
    public static function getEssentialCssInline() {
        return file_get_contents(__DIR__ . '/../../../public/assets/essential.inline.css');
    }

    /**
     * @return array|false|string
     */
    public static function getEssentialJsInline() {
        return file_get_contents(__DIR__ . '/../../../public/assets/essential.inline.js');
    }
}