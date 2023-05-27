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

namespace Markocupic\FontawesomeIconPickerBundle\ContaoBackendWidget;

use Contao\ContentModel;
use Contao\Input;
use Contao\StringUtil;
use Contao\System;
use Contao\Widget;
use Symfony\Component\Yaml\Yaml;

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

    /**
     * @return string
     */
    public function generate()
    {
        return $this->generatePicker();
    }

    protected function generatePicker(): string
    {
        $ContentModel = ContentModel::findByPk(Input::get('id'));

        // Load Font Awesome
        $arrIconsAll = $this->getIconsAll();

        // Filter
        $html = '<div style="display:flex;justify-content:flex-end;align-items:center;margin-bottom:15px">';
        $html .= '<h3 style="padding:0;margin:0 10px 0 0"><label>'.$GLOBALS['TL_LANG']['MSC']['faIconFilter'].'</label></h3>';
        $html .= '<input type="text" id="ctrl_faFilter" class="tl_text" style="max-width:200px">';
        $html .= '</div>';
        // Build radio-button-list
        $html .= '<div id="iconBox">';

        $inputValue = '';
        $currIconName = null;
        $currIconPrefix = null;

        if (\count(StringUtil::deserialize($ContentModel->faIcon, true)) > 0) {
            $inputValue = implode('||', StringUtil::deserialize($ContentModel->faIcon, true));
            $arrFa = StringUtil::deserialize($ContentModel->faIcon, true);
            $currIconName = $arrFa[0];
            $currIconPrefix = $arrFa[1];
        }

        $html .= sprintf('<input type="hidden" id="ctrl_faIcon" name="faIcon" value="%s">', $inputValue);

        foreach ($arrIconsAll as $arrFa) {
            $cssClassChecked = '';
            $iconName = $arrFa['id'];
            $iconLabel = $arrFa['label'];
            $iconUnicode = $arrFa['unicode'];

            if ($currIconName === $iconName) {
                $cssClassChecked = ' checked';
            }

            $html .= sprintf('<div onclick="" title="%s" class="font-awesome-icon-item%s">', $iconName, $cssClassChecked);
            $html .= sprintf('<div class="font-id-title">%s</div>', $iconName);
            $html .= sprintf('<i class="fa-2x fa-fw %s fa-%s"></i>', $arrFa['faStyle'] ?? '', $iconName);
            $html .= '<div class="faStyleBox">';

            $styles = System::getContainer()->getParameter('markocupic_fontawesome_icon_picker.fontawesome_styles');

            foreach ($styles as $shortcut => $style) {
                $selectedStyle = '';

                if (\in_array(str_replace('fa-', '', $style), $arrFa['styles'], true)) {
                    if ($shortcut === $currIconPrefix) {
                        $selectedStyle = ' selectedStyle';
                    }
                    $html .= sprintf(
                        '<div class="faStyleButton%s" role="button" title="%s" data-falabel="%s" data-faiconunicode="%s" data-faiconprefix="%s" data-faiconname="%s">%s</div>',
                        $selectedStyle,
                        $style,
                        $iconLabel,
                        $iconUnicode,
                        $shortcut,
                        $iconName,
                        substr(ucfirst(str_replace('fa-', '', $style)), 0, 1),
                    );
                }
            }

            $html .= '</div>';
            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Get all FontAwesomeClasses as array from icons.yml
     * Download this file at:
     * https://fontawesome.com/get-started.
     */
    protected function getIconsAll(): array
    {
        $projectDir = System::getContainer()->get('kernel.projectDir');
        $iconMetaFilePath = trim(
            System::getContainer()->getParameter('markocupic_fontawesome_icon_picker.fontawesome_meta_file_path'),
            '/',
        );

        $arrMatches = [];
        $strFile = file_get_contents($projectDir.'/'.$iconMetaFilePath);

        $arrYaml = Yaml::parse($strFile);

        foreach ($arrYaml as $iconName => $arrItemProps) {
            $arrItem = [
                'id' => $iconName,
                'faClass' => 'fa-'.$iconName,
                'styles' => $arrItemProps['styles'],
                'label' => $arrItemProps['label'],
                'unicode' => $arrItemProps['unicode'],
            ];

            if (!empty($arrItemProps['styles']) && \is_array($arrItemProps['styles'])) {
                if (\in_array('solid', $arrItemProps['styles'], true)) {
                    $arrItem['style'] = 'solid';
                    $arrItem['faStyle'] = 'fa-solid';
                } elseif (\in_array('light', $arrItemProps['styles'], true)) {
                    $arrItem['style'] = 'light';
                    $arrItem['faStyle'] = 'fa-light';
                } elseif (\in_array('regular', $arrItemProps['styles'], true)) {
                    $arrItem['style'] = 'regular';
                    $arrItem['faStyle'] = 'fa-regular';
                } elseif (\in_array('brands', $arrItemProps['styles'], true)) {
                    $arrItem['style'] = 'brands';
                    $arrItem['faStyle'] = 'fa-brands';
                } elseif (\in_array('duotone', $arrItemProps['styles'], true)) {
                    $arrItem['style'] = 'duotone';
                    $arrItem['faStyle'] = 'fa-duotone';
                } elseif (\in_array('thin', $arrItemProps['styles'], true)) {
                    $arrItem['style'] = 'thin';
                    $arrItem['faStyle'] = 'fa-thin';
                }
            }
            $arrMatches[] = $arrItem;
        }

        return $arrMatches;
    }

    /**
     * @param mixed $varInput
     *
     * @return mixed
     */
    protected function validator($varInput)
    {
        $varInput = explode('||', $varInput);
        $varInput = serialize($varInput);

        return parent::validator($varInput);
    }
}
