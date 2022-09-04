<?php

/*
 * This file is part of ocubom/html-bundle
 *
 * © Oscar Cubo Medina <https://ocubom.github.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ocubom\HtmlBundle\DependencyInjection;

use Ocubom\HtmlBundle\EventListener\AddHttpHeadersListener;
use Ocubom\Twig\Extension\HtmlAttributesRuntime;
use Ocubom\Twig\Extension\HtmlCompressRuntime;
use Ocubom\Twig\Extension\HtmlExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class OcubomHtmlExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        // $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        // $loader->load('services.php');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $this->registerTwigHtmlExtension($container, $config);
        $this->registerHeadersListener($container, $config);
    }

    private function registerTwigHtmlExtension(ContainerBuilder $container, array $config): void
    {
        $container->register(HtmlExtension::class)
            ->addTag('twig.extension');

        $container->register(HtmlAttributesRuntime::class)
            ->addTag('twig.runtime');

        $container->register(HtmlCompressRuntime::class)
            ->setArguments([
                $config['compress']['force'],
                $config['compress']['level'],
            ])
            ->addTag('twig.runtime');
    }

    private function registerHeadersListener(ContainerBuilder $container, array $config): void
    {
        // Filter enabled header rules
        $headers = array_filter($config['headers'], function (array $header): bool {
            return $header['enabled'] ? true : false;
        });

        // Only register listener if some rule is defined
        if (count($headers) > 0) {
            $container->register(AddHttpHeadersListener::class)
                ->setArguments(array_values($headers))
                ->addTag('kernel.event_subscriber');
        }
    }
}
