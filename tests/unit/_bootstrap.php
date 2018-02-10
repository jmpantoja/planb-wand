<?php
$base = codecept_root_dir();

include $base . '/vendor/autoload.php'; // composer autoload

$kernel = \AspectMock\Kernel::getInstance();
$kernel->init([
    'debug' => false,
    'cacheDir' => $base . 'var/mocks',
    'includePaths' => [
        $base . '/src',
        $base . '/vendor'
    ],
    'excludePaths' => [
        $base . "/vendor/planb/utils-dev",
        $base . "/vendor/behat",
        $base . "/vendor/codeception",
        $base . "/vendor/mockery",
        $base . "/vendor/goaop",
        $base . "/vendor/nikic",
        $base . "/vendor/phpunit",
        $base . "/vendor/symfony/symfony/src/Symfony/Component/VarDumper"
    ],
]);
