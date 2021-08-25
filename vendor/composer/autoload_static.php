<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit75dd5fccb3a9a48ad236c2d66ed8e644
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'DWP\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'DWP\\' => 
        array (
            0 => __DIR__ . '/../..' . '/include',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit75dd5fccb3a9a48ad236c2d66ed8e644::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit75dd5fccb3a9a48ad236c2d66ed8e644::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit75dd5fccb3a9a48ad236c2d66ed8e644::$classMap;

        }, null, ClassLoader::class);
    }
}
