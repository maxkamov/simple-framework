<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4ba3b2b5d40317619d8a779a590c0ead
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'app\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4ba3b2b5d40317619d8a779a590c0ead::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4ba3b2b5d40317619d8a779a590c0ead::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
