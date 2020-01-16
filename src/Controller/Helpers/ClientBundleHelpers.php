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
     * @return bool|string
     */
    public static function getEssentialJsInline() {
        return file_get_contents(__DIR__ . '/../../../public/assets/essential.inline.js');
    }

    /**
     * @param string $bundleNames
     * @return string
     */
    public static function getBundledCssPath(string $bundleName) {
        $files = glob(__DIR__ . '/../../../public/assets/' . $bundleName . '.bundle*.css');
        if (empty($files)) return '';
        
        preg_match('/\/assets\/' . $bundleName . '.*/', $files[0], $matches);
        return (!empty($matches)) ? $matches[0] : '';
    }

    /**
     * @param string $bundleNames
     * @return string
     */
    public static function getBundledJsPath(string $bundleName) {
        $files = glob(__DIR__ . '/../../../public/assets/' . $bundleName . '.bundle*.js');
        if (empty($files)) return '';
        
        preg_match('/\/assets\/' . $bundleName . '.*/', $files[0], $matches);
        return (!empty($matches)) ? $matches[0] : '';
    }
}