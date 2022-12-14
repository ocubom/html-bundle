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

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $builder = new TreeBuilder('ocubom_html');

        $root = $builder->getRootNode();

        $this->addHeadersSection($root);
        $this->addHtmlCompressSection($root);

        return $builder;
    }

    private function addHeadersSection(ArrayNodeDefinition $root): self
    {
        $root
            ->fixXmlConfig('header')
            ->children()
                ->arrayNode('headers')
                    ->info(implode("\n", [
                        'HTTP headers that must be set.',
                        'The listener will only be registered if at least one rule is enabled.',
                    ]))
                    ->prototype('array')
                        ->fixXmlConfig('header')
                        ->treatFalseLike(['enabled' => false])
                        ->treatTrueLike(['enabled' => true])
                        ->treatNullLike(['enabled' => true])
                        ->children()
                            ->booleanNode('enabled')
                                ->info('Apply this rule?')
                                ->defaultTrue()
                            ->end()
                            ->scalarNode('name')
                                ->info('The header name to be added.')
                                ->example('X-UA-Compatible')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('pattern')
                                ->info('A regular expression to extract the header value.')
                                ->example('@@[\p{Zs}]*<meta\s+(?:http-equiv="X-UA-Compatible"\s+content="([^"]+)"|content="([^"]+)"\s+http-equiv="X-UA-Compatible")\s*>\p{Zs}*\n?@i')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('value')
                                ->info('The format of the value (printf processed using the matched value).')
                                ->example('%2$s')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('replace')
                                ->info('The text that replaces the match in the original (printf processed using the matched value).')
                                // ->example('')
                                ->defaultValue('%s')
                            ->end()
                            ->arrayNode('formats')
                                ->info('The response formats when this replacement must be done.')
                                ->example('["text/html"]')
                                // ->addDefaultChildrenIfNoneSet()
                                ->prototype('scalar')
                                    // ->defaultValue('text/html')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $this;
    }

    private function addHtmlCompressSection(ArrayNodeDefinition $root): self
    {
        $root
            ->children()
                ->arrayNode('compress')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('force')
                            ->info('Force compression?')
                            ->defaultFalse()
                        ->end()
                        ->enumNode('level')
                            ->info('The level of compression to use')
                            ->defaultValue('smallest')
                            ->values(['none', 'fastest', 'normal', 'smallest'])
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $this;
    }
}
