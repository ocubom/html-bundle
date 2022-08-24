<?php

/*
 * This file is part of ocubom/html-bundle
 *
 * © Oscar Cubo Medina <https://ocubom.github.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ocubom\HtmlBundle\Tests;

use Ocubom\HtmlBundle\DependencyInjection\OcubomHtmlExtension;
use Ocubom\HtmlBundle\EventListener\AddHttpHeadersListener;
use Ocubom\Twig\Extension\HtmlExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class OcubomHtmlExtensionTest extends TestCase
{
    /** @dataProvider provideConfiguration */
    public function testConfiguration($buildContainer, $expected)
    {
        $container = new ContainerBuilder(new ParameterBag([
            'kernel.debug' => false,
        ]));
        $container->registerExtension(new OcubomHtmlExtension());
        $buildContainer($container);
        $container->getCompilerPassConfig()->setOptimizationPasses([]);
        $container->getCompilerPassConfig()->setRemovingPasses([]);
        $container->getCompilerPassConfig()->setAfterRemovingPasses([]);
        $container->compile();

        foreach ($expected as $name => $class) {
            if (null === $class) {
                $this->assertFalse($container->hasDefinition($name));
            } else {
                $this->assertEquals($class, $container->getDefinition($name)->getClass());
            }
        }
    }

    public function provideConfiguration()
    {
        yield 'default' => [
            function (ContainerBuilder $container) {
                $container->registerExtension(new OcubomHtmlExtension());
                $container->loadFromExtension('ocubom_html');
            },
            [
                AddHttpHeadersListener::class => null,
                HtmlExtension::class => HtmlExtension::class,
            ]
        ];

        yield 'with headers' => [
            function (ContainerBuilder $container) {
                $container->registerExtension(new OcubomHtmlExtension());
                $container->loadFromExtension('ocubom_html', [
                    'headers' => array_values(AddHttpHeadersTest::$rules),
                ]);
            },
            [
                AddHttpHeadersListener::class => AddHttpHeadersListener::class,
                HtmlExtension::class => HtmlExtension::class,
            ]
        ];
    }
}
