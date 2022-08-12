<?php

declare(strict_types=1);

/*
 * This file is part of Fontawesome Icon Picker Bundle.
 *
 * (c) Marko Cupic 2022 <m.cupic@gmx.ch>
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
                ->scalarNode('fontawesome_source_path')
                    ->defaultValue('https://use.fontawesome.com/releases/v'.Config::FONTAWESOME_VERSION.'/js/all.js')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
