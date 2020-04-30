<?php

namespace App\Controller\Helpers;


class ClientBundleHelpers {
    
    private const BASE_ASSET_PATH = '/../../../public';
    private const ASSET_DIR_NAME = 'assets';

    /**
     * @return array|false|string
     */
    public static function getEssentialCssInline() {
        return file_get_contents(__DIR__ . self::BASE_ASSET_PATH . '/' . self::ASSET_DIR_NAME . '/essential.css');
    }

    /**
     * @return array|false|string
     */
    public static function getEssentialJsInline() {
        return file_get_contents(__DIR__ . self::BASE_ASSET_PATH . '/' . self::ASSET_DIR_NAME . '/essential.js');
    }

    /**
     * @param string $bundleName
     * @param string $bundleFileName
     * @return string
     */
    public static function getBundlePath(string $bundleDirName, string $bundleFileName) : string {
        $assetPath = self::getExternalBundlePath(self::BASE_ASSET_PATH, self::ASSET_DIR_NAME, $bundleFileName, $bundleDirName . '/');
        if (!empty($assetPath)) return $assetPath;

        $assetPath = self::getExternalBundlePath(self::BASE_ASSET_PATH, self::ASSET_DIR_NAME, $bundleFileName);
        if (!empty($assetPath)) return $assetPath;

        return '';
    }

    /**
     * @param string $basePath
     * @param string $assetDirName
     * @param string $bundleFileName
     * @param string $bundleDir
     * @return string
     */
    private static function getExternalBundlePath(string $basePath, string $assetDirName, string $bundleFileName, string $bundleDir = '') : ?string {
        preg_match('/(.+)(\..+$)/', $bundleFileName, $baseFileMatches);
        if (count($baseFileMatches) !== 3) throw new \UnexpectedValueException('A total of 3 matches were expected');
        $baseFileName = $baseFileMatches[1];
        $baseFileExt = $baseFileMatches[2];

        $files = glob(__DIR__ . $basePath . '/' . $assetDirName . '/' . $bundleDir . $baseFileName . '*' . $baseFileExt);

        if (empty($files)) return null;
        
        $indexPattern = str_replace('/', '\/', '/' . $assetDirName . '/' . $bundleDir);
        preg_match('/' . $indexPattern . $baseFileName . '(_[0-9a-z]+)?' . $baseFileExt . '/', $files[0], $matches);
        if (!empty($matches)) return $matches[0];

        return null;
    }
}
