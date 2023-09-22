<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitec0ca56a12261a05ed950885bc053d54
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitec0ca56a12261a05ed950885bc053d54::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitec0ca56a12261a05ed950885bc053d54::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
