<?php

use Sami\Sami;
use Sami\RemoteRepository\GitHubRemoteRepository;
use Sami\Version\GitVersionCollection;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('Resources')
    ->exclude('Tests')
    ->in($dir = 'src');

return new Sami($iterator, array(
    'theme'                => 'github',
    'title'                => 'planb/wand',
    'build_dir'            => __DIR__.'/docs/api/',
    'cache_dir'            => __DIR__.'/var/cache/sami/%version%',
    'template_dirs'        => array(__DIR__.'/../src/Wand/Docs/config/views/template/github'),
    'default_opened_level' => 2,
));

