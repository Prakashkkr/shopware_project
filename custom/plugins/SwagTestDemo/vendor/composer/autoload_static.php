<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb3414809e0e311dcec269d922c694681
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SwagTestDemo\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SwagTestDemo\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb3414809e0e311dcec269d922c694681::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb3414809e0e311dcec269d922c694681::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb3414809e0e311dcec269d922c694681::$classMap;

        }, null, ClassLoader::class);
    }
}