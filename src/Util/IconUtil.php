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

namespace Markocupic\FontawesomeIconPickerBundle\Util;

use Symfony\Component\Yaml\Yaml;

class IconUtil
{
    public function __construct(
        private readonly string $projectDir,
        private readonly string $fontawesomeMetaFilePath,
        private readonly array $fontawesomeStyles,
    ) {
    }

    public function getIconsAll(): array
    {
        $arrMatches = [];
        $strFile = file_get_contents($this->projectDir.'/'.$this->fontawesomeMetaFilePath);

        $arrYaml = Yaml::parse($strFile);

        foreach ($arrYaml as $iconName => $arrItemProps) {
            if (!empty($arrItemProps['styles']) && \is_array($arrItemProps['styles'])) {
                foreach ($this->fontawesomeStyles as $style) {
                    $style = str_replace('fa-', '', $style);

                    if (\in_array($style, $arrItemProps['styles'], true)) {
                        $arrMatches[$iconName] = [
                            'id' => $iconName,
                            'faClass' => 'fa-'.$iconName,
                            'styles' => $arrItemProps['styles'],
                            'label' => $arrItemProps['label'],
                            'unicode' => $arrItemProps['unicode'],
                            'faStyles' => array_map(static fn ($faStyle) => 'fa-'.$faStyle, $arrItemProps['styles']),
                        ];
                        break;
                    }
                }
            }
        }
        //die(print_r($arrMatches,true));

        return $arrMatches;
    }
}
