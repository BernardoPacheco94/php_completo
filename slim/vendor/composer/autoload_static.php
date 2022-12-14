<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit29a813c646279041c98adadcf9d3dd27
{
    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'Slim' => 
            array (
                0 => __DIR__ . '/..' . '/slim/slim',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit29a813c646279041c98adadcf9d3dd27::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit29a813c646279041c98adadcf9d3dd27::$classMap;

        }, null, ClassLoader::class);
    }
}
