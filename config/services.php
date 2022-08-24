<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Ocubom\HtmlBundle\Twig\HtmlExtension;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(HtmlExtension::class);
};
