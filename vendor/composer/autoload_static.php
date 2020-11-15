<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit01a39954f0638b47e6424a5e3cd923ed
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

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit01a39954f0638b47e6424a5e3cd923ed::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit01a39954f0638b47e6424a5e3cd923ed::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
