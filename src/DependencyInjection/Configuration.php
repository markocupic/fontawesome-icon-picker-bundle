<?php

declare(strict_types=1);

/*
 * This file is part of Fontawesome Icon Picker Bundle.
 *
 * (c) Marko Cupic <m.cupic@gmx.ch>
 * @license GPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/markocupic/fontawesome-icon-picker-bundle
 */

namespace Markocupic\FontawesomeIconPickerBundle\DependencyInjection;

use Markocupic\FontawesomeIconPickerBundle\FontAwesomeStyles;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Filesystem\Path;

class Configuration implements ConfigurationInterface
{
    public const ROOT_KEY = 'markocupic_fontawesome_icon_picker';

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(self::ROOT_KEY);

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('fontawesome_version')
                    ->cannotBeEmpty()
                    ->defaultValue($this->getFontawesomeDefaultVersion())
                    ->validate()
                        ->ifTrue(static fn ($v) => !preg_match('/^\d+\.\d+\.\d+$/', $v))
                        ->thenInvalid('The "fontawesome_version" must follow the format X.Y.Z (e.g. 7.0.1).')
                    ->end()
                ->end()
                ->scalarNode('fontawesome_meta_file_path')
                    ->cannotBeEmpty()
                    ->info('Path from root to the fontawesome meta file. Get the original meta file from https://github.com/FortAwesome/Font-Awesome/blob/6.4.0/metadata/icons.yml')
                    ->defaultValue('vendor/markocupic/fontawesome-icon-picker-bundle/fontawesome/metadata/icons.yml')
                ->end()
                ->scalarNode('fontawesome_source_path')
                    ->defaultValue('https://use.fontawesome.com/releases/v'.$this->getFontawesomeDefaultVersion().'/js/all.js')
                ->end()
                ->arrayNode('fontawesome_allowed_styles')
                    ->prototype('scalar')->end()
                    ->defaultValue(FontAwesomeStyles::getStyles())
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }

    private function getFontawesomeDefaultVersion(): string
    {
        return file_get_contents(Path::join(__DIR__, '../../fontawesome/.version'));
    }
}
