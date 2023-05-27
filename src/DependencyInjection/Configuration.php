<?php

declare(strict_types=1);

/*
 * This file is part of Fontawesome Icon Picker Bundle.
 *
 * (c) Marko Cupic 2023 <m.cupic@gmx.ch>
 * @license LGPL-3.0+
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/markocupic/fontawesome-icon-picker-bundle
 */

namespace Markocupic\FontawesomeIconPickerBundle\DependencyInjection;

use Markocupic\FontawesomeIconPickerBundle\Config;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public const ROOT_KEY = 'markocupic_fontawesome_icon_picker';

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(self::ROOT_KEY);

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('fontawesome_meta_file_path')
                    ->cannotBeEmpty()
                    ->info('Path from root to the fontawesome meta file.')
                    ->defaultValue('vendor/markocupic/fontawesome-icon-picker-bundle/fontawesome/icons.yaml')
                ->end()
                ->scalarNode('fontawesome_source_path')
                    ->defaultValue('https://use.fontawesome.com/releases/v'.Config::FONTAWESOME_VERSION.'/js/all.js')
                ->end()
                ->arrayNode('fontawesome_styles')
                    ->children()
                        ->scalarNode('fas')->cannotBeEmpty()->defaultValue('fa-solid')->end()
                        ->scalarNode('far')->cannotBeEmpty()->defaultValue('fa-regular')->end()
                        ->scalarNode('fal')->cannotBeEmpty()->defaultValue('fa-light')->end()
                        ->scalarNode('fab')->cannotBeEmpty()->defaultValue('fa-brands')->end()
                        ->scalarNode('fad')->cannotBeEmpty()->defaultValue('fa-duotone')->end()
                        ->scalarNode('fat')->cannotBeEmpty()->defaultValue('fa-thin')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
