<?php

declare(strict_types=1);

/*
 * This file is part of Fontawesome Icon Picker Bundle.
 *
 * (c) Marko Cupic <m.cupic@gmx.ch>
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
                    ->info('Path from root to the fontawesome meta file. Get the original meta file from https://github.com/FortAwesome/Font-Awesome/blob/6.4.0/metadata/icons.yml')
                    ->defaultValue('vendor/markocupic/fontawesome-icon-picker-bundle/fontawesome/metadata/icons.yml')
                ->end()
                ->scalarNode('fontawesome_source_path')
                    ->defaultValue('https://use.fontawesome.com/releases/v'.Config::FONTAWESOME_VERSION.'/js/all.js')
                ->end()
                ->arrayNode('fontawesome_styles')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')->end()
                    ->defaultValue([
                        'fas' => 'fa-solid',
                        'far' => 'fa-regular',
                        'fal' => 'fa-light',
                        'fab' => 'fa-brands',
                        'fad' => 'fa-duotone',
                        'fat' => 'fa-thin',
                    ])
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
