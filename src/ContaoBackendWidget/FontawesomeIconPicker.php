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

namespace Markocupic\FontawesomeIconPickerBundle\ContaoBackendWidget;

use Contao\System;
use Contao\Widget;
use Markocupic\FontawesomeIconPickerBundle\Util\IconUtil;

class FontawesomeIconPicker extends Widget
{
    /**
     * @var bool
     */
    protected $blnSubmitInput = true;

    /**
     * @var string
     */
    protected $strTemplate = 'be_widget';

    public function generate(): string
    {
        return $this->generatePicker();
    }

    protected function generatePicker(): string
    {
        /** @var IconUtil $iconUtil */
        $iconUtil = System::getContainer()->get(IconUtil::class);

        // Load Font Awesome icon meta file
        $arrIconsAll = $iconUtil->getIconsAll();

        $varValue = '';
        $selectedIcon = null;
        $selectedIconPrefix = null;
        $arrIcon = $this->varValue;

        $arrIcons = [];

        if (!empty($arrIcon) && \is_array($arrIcon)) {
            $varValue = implode('||', $this->varValue);
            $selectedIcon = $arrIcon[0] ?? '';
            $selectedIconPrefix = $arrIcon[1] ?? '';
        }

        foreach ($arrIconsAll as $arrFa) {
            $arrIcon = [];
            $arrIcon['fa_id'] = $arrFa['id'];
            $arrIcon['fa_label'] = $arrFa['label'];
            $arrIcon['fa_attr_selected'] = '';
            $arrIcon['fa_class'] = $arrFa['faClass'];
            $arrIcon['fa_style'] = $arrFa['faStyles'][0];
            $arrIcon['fa_unicode'] = $arrFa['unicode'];
            $arrIcon['fa_styles'] = [];

            if ($selectedIcon === $arrFa['id']) {
                $arrIcon['fa_attr_selected'] = ' checked';
            }

            $styles = System::getContainer()->getParameter('markocupic_fontawesome_icon_picker.fontawesome_styles');

            foreach ($styles as $prefix => $style) {
                if (\in_array(str_replace('fa-', '', $style), $arrFa['styles'], true)) {
                    $iconStyle = [];
                    $iconStyle['style_shortcut'] = substr(ucfirst(str_replace('fa-', '', $style)), 0, 1);
                    $iconStyle['style_prefix'] = $prefix;
                    $iconStyle['style_attr_selected'] = '';

                    if ($prefix === $selectedIconPrefix) {
                        $iconStyle['style_attr_selected'] = ' selectedStyle';
                    }

                    $arrIcon['fa_styles'][] = $iconStyle;
                }
            }

            $arrIcons[] = $arrIcon;
        }

        $twig = System::getContainer()->get('twig');

        return $twig->render(
            '@MarkocupicFontawesomeIconPicker/fontawesome_icon_picker_widget.html.twig',
            [
                'input_value' => $varValue,
                'name' => $this->strName,
                'icons' => $arrIcons,
            ]
        );
    }

    protected function validator(mixed $varInput): mixed
    {
        if (null !== $varInput) {
            $varInput = explode('||', $varInput);
            $varInput = serialize($varInput);
        }

        return parent::validator($varInput);
    }
}
