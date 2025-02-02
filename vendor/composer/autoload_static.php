<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd14d6bb7353b2e4898900dfee6090d86
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd14d6bb7353b2e4898900dfee6090d86::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd14d6bb7353b2e4898900dfee6090d86::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd14d6bb7353b2e4898900dfee6090d86::$classMap;

        }, null, ClassLoader::class);
    }
}
