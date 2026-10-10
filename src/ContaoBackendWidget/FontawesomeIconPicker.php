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

namespace Markocupic\FontawesomeIconPickerBundle\ContaoBackendWidget;

use Contao\StringUtil;
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
        $selectedStyle = null;
        $arrIcon = $this->varValue;

        $arrIcons = [];

        if (!empty($arrIcon) && \is_array($arrIcon)) {
            $varValue = json_encode($this->varValue);
            $selectedIcon = $arrIcon[0] ?? '';
            $selectedStyle = $arrIcon[1] ?? '';
        }

        foreach ($arrIconsAll as $arrFa) {
            $arrIcon = [];
            $arrIcon['fa_id'] = $arrFa['id'];
            $arrIcon['fa_label'] = $arrFa['label'];
            $arrIcon['fa_attr_selected'] = '';
            $arrIcon['fa_class'] = $arrFa['faClass'];
            $arrIcon['fa_unicode'] = $arrFa['unicode'] ?? '';
            $arrIcon['fa_available_styles'] = [];
            $arrIcon['fa_styles'] = [];
            $arrIcon['fa_search_terms'] = '';
            if (isset($arrFa['search']['terms'])) {
                $arrIcon['fa_search_terms'] = implode(', ', $arrFa['search']['terms']);
            }

            $arrIcon['fa_styles_shortcut'] = '';

            if ($selectedIcon === $arrFa['id']) {
                $arrIcon['fa_attr_selected'] = ' checked';
            }

            $styles = System::getContainer()->getParameter('markocupic_fontawesome_icon_picker.fontawesome_allowed_styles');

            foreach ($styles as $style) {
                if (\in_array(str_replace('fa-', '', $style), $arrFa['styles'], true)) {
                    $iconStyle = [];
                    $iconStyle['style'] = $style;
                    $iconStyle['style_shortcut'] = substr(ucfirst(str_replace('fa-', '', $style)), 0, 1);
                    $iconStyle['style_attr_selected'] = '';

                    if ($style === $selectedStyle) {
                        $iconStyle['style_attr_selected'] = ' selectedStyle';
                    }

                    $arrIcon['fa_available_styles'][] = $style;

                    $arrIcon['fa_styles'][] = $iconStyle;
                }
            }

            $arrIcons[] = $arrIcon;
        }

        $twig = System::getContainer()->get('twig');

        return $twig->render('@MarkocupicFontawesomeIconPicker/fontawesome_icon_picker_widget.html.twig', [
            'input_value' => $varValue,
            'name' => $this->strName,
            'icons' => $arrIcons,
        ]);
    }

    protected function validator(mixed $varInput): mixed
    {
        if (null === $varInput || '' === $varInput) {
            return parent::validator($varInput);
        }

        // Contao 5 encodes the input, Contao 6 does not
        $icon = json_decode(StringUtil::revertInputEncoding((string) $varInput), true);

        // Expected format: ["icon-name", "fa-style", "unicode"]
        if (!\is_array($icon) || !array_is_list($icon) || \count($icon) < 2 || array_filter($icon, static fn ($v): bool => !\is_string($v))) {
            $this->addError('Invalid icon.');

            return '';
        }

        return parent::validator(serialize($icon));
    }
}
