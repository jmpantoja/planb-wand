#!/usr/bin/env php
<?php
require __DIR__.'/../vendor/autoload.php';

use PlanB\WandBundle\Command\WandCommand;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

if (!ini_get('date.timezone')) {
    date_default_timezone_set('UTC');
}

ini_set('memory_limit', "-1");

$application = new Application('wand', '1.0.0');

$container = new ContainerBuilder();
$container->setParameter('root_dir', dirname(__DIR__));

$loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../config'));

$loader->load('twig.xml');
$loader->load('subscriber.xml');
$loader->load('services.xml');

$command = new WandCommand($container);

$application->add($command);

$application->setDefaultCommand($command->getName(), true);
$application->run();
