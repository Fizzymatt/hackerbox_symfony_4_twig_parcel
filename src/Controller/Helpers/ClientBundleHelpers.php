<?php

namespace App\Controller\Helpers;


class ClientBundleHelpers {
    /**
     * @return bool|string
     */
    public static function getEssentialCssInline() {
        return file_get_contents(__DIR__ . '/../../../public/assets/essential.css');
    }

    /**
     * @return bool|string
     */
    public static function getEssentialJsInline() {
        return file_get_contents(__DIR__ . '/../../../public/assets/essential.js');
    }

    /**
     * @param string $bundleNames
     * @return string
     */
    public static function getBundledCssPath(string $bundleName) {
        $files = glob(__DIR__ . '/../../../public/assets/' . $bundleName . '/index*.css');
        if (empty($files)) return '';
        
        preg_match('/\/assets\/' . $bundleName . '\/index(_[0-9a-z]+)?\.css/', $files[0], $matches);
        return (!empty($matches)) ? $matches[0] : '';
    }

    /**
     * @param string $bundleNames
     * @return string
     */
    public static function getBundledJsPath(string $bundleName) {
        $files = glob(__DIR__ . '/../../../public/assets/' . $bundleName . '/index*.js');
        if (empty($files)) return '';
        
        preg_match('/\/assets\/' . $bundleName . '\/index(_[0-9a-z]+)?\.js/', $files[0], $matches);
        return (!empty($matches)) ? $matches[0] : '';
    }
}