<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitcda29c6859a2ec15daef0739cabebd88
{
    public static $files = array (
        '73a76277cdd754516bf94aa9c0aa6bb3' => __DIR__ . '/../..' . '/src/main.function.php',
        '2c30778c83e7cf1ab5d05f6fb053a212' => __DIR__ . '/../..' . '/src/template.function.php',
        '4497162affd5dbda9202a35ac3a5f40d' => __DIR__ . '/../..' . '/src/file.function.php',
        '9b07bf066fe6228fb75ba49a3e662569' => __DIR__ . '/../..' . '/src/birthday.function.php',
        '7a85d8af1ca58319ffad0e16a7ac7e21' => __DIR__ . '/../..' . '/src/data.function.php',
        'f78a65ff222a5cb77f359f2231769eb0' => __DIR__ . '/../..' . '/src/users.function.php',
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInitcda29c6859a2ec15daef0739cabebd88::$classMap;

        }, null, ClassLoader::class);
    }
}
