<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8de789a2c20183752e72c14c93a923cf
{
    public static $prefixLengthsPsr4 = array (
        'V' => 
        array (
            'Videos\\' => 7,
        ),
        'I' => 
        array (
            'Inc\\' => 4,
        ),
        'C' => 
        array (
            'Core\\' => 5,
            'Classes\\' => 8,
        ),
        'A' => 
        array (
            'Authentication\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Videos\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc/classes/core/videos',
        ),
        'Inc\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc',
        ),
        'Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc/classes/core',
        ),
        'Classes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc/classes',
        ),
        'Authentication\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc/classes/core/authentication',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Core\\Social_Walker' => __DIR__ . '/../..' . '/inc/classes/core/Social_Walker.php',
        'Core\\assets' => __DIR__ . '/../..' . '/inc/classes/core/assets.php',
        'Inc\\classes\\core\\autnentication\\authentication' => __DIR__ . '/../..' . '/inc/classes/core/autnentication/authentication.php',
        'Inc\\classes\\yoyo_tube' => __DIR__ . '/../..' . '/inc/classes/yoyo_tube.php',
        'Inc\\traits\\singleton' => __DIR__ . '/../..' . '/inc/traits/singleton.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8de789a2c20183752e72c14c93a923cf::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8de789a2c20183752e72c14c93a923cf::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit8de789a2c20183752e72c14c93a923cf::$classMap;

        }, null, ClassLoader::class);
    }
}
