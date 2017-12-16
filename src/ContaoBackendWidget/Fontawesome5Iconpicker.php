<?php

/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 16.12.2017
 * Time: 11:13
 */

namespace Markocupic\FontawesomeIconPickerBundle\ContaoBackendWidget;

use Contao\Widget;
use Contao\ContentModel;
use Contao\Input;
use Contao\StringUtil;
use Symfony\Component\Yaml\Yaml;


class Fontawesome5Iconpicker extends Widget
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
     * @param mixed $varInput
     * @return mixed
     */
    protected function validator($varInput)
    {
        $varInput = explode('||', $varInput);
        return serialize($varInput);

        return parent::validator($varInput);
    }

    /**
     * @return string
     */
    public function generate()
    {
        return $this->generatePicker();
    }


    protected function generatePicker()
    {
        $ContentModel = ContentModel::findByPk(Input::get('id'));
        if ($ContentModel !== null)
        {
            if (Input::post('FORM_SUBMIT'))
            {
                if (Input::post('faIcon') != '')
                {
                    //$ContentModel->faIcon = serialize(Input::post('faIcon'));
                    //$ContentModel->save();
                }
            }
        }
        // Load Font Awesome
        $arrFaIds = $this->getFaIds();
        $html = '<fieldset id="ctrl_faIcon" class="tl_radio_container">';
        // Filter
        $html .= '<h3><label>' . $GLOBALS['TL_LANG']['tl_content']['faIconFilter'] . '</label></h3>';
        $html .= '<input type="text" id="faClassFilter" class="tl_text fa-class-filter" placeholder="filter">';


        // Build radio-button-list
        $html .= '<h3><label>Icon picker</label></h3>';
        $html .= '<div id="iconBox">';

        $inputValue = '';
        $currentFaId = null;
        $currentFaStyle = null;
        if (count(StringUtil::deserialize($ContentModel->faIcon, true)) == 2)
        {
            $inputValue = implode('||', StringUtil::deserialize($ContentModel->faIcon, true));
            $arrFa = StringUtil::deserialize($ContentModel->faIcon, true);
            $currentFaId = $arrFa[0];
            $currentFaStyle = $arrFa[1];
        }


        $html .= '<input type="hidden" name="faIcon" value="' . $inputValue . '">';
        $i = 0;
        foreach ($arrFaIds as $arrFa)
        {
            $checked = '';
            $cssClassChecked = '';
            $cssClassCheckedWithAttribute = '';
            if ($currentFaId === 'fa-' . $arrFa['id'])
            {
                $checked = ' checked="checked"';
                $cssClassChecked = ' checked';
                $cssClassCheckedWithAttribute = ' class="checked"';
            }

            $html .= sprintf('<div onclick="" title="%s" class="font-awesome-icon-item%s" data-faClass="fa-%s">', $arrFa['id'], $cssClassChecked, $arrFa['id']);
            $html .= '<div class="font-id-title">' . $arrFa['id'] . '</div>';
            $html .= '<i class="fa fa-2x fa-fw ' . $arrFa['faStyle'] . ' ' . $arrFa['faClass'] . '"></i>';

            $html .= '<div class="faStyleBox">';
            foreach ($arrFa['availableStyles'] as $style)
            {
                $selectedStyle = '';

                if ($style === 'light')
                {
                    if ($currentFaStyle === 'fal')
                    {
                        $selectedStyle = ' selectedStyle';
                    }
                    $html .= sprintf('<div class="faStyle faStyleLight%s" role="button" title="light" data-fa-style="fal">L</div>', $selectedStyle);
                }
                if ($style === 'solid')
                {
                    if ($currentFaStyle === 'fas')
                    {
                        $selectedStyle = ' selectedStyle';
                    }
                    $html .= sprintf('<div class="faStyle faStyleSolid%s" role="button" title="solid" data-fa-style="fas">S</div>', $selectedStyle);
                }
                if ($style === 'brands')
                {
                    if ($currentFaStyle === 'fab')
                    {
                        $selectedStyle = ' selectedStyle';
                    }
                    $html .= sprintf('<div class="faStyle faStyleBrand%s" role="button" title="brands" data-fa-style="fab">B</div>', $selectedStyle);
                }
            }
            $html .= '</div>';
            $html .= '</div>';

            $i++;
        }


        $html .= '</div>';
        $html .= '</fieldset>';


        // Javascript (Mootools)


        return $html;

    }

    /**
     * Get all FontAwesomeClasses as array from icons.yml
     * Download this file at:
     * https://raw.githubusercontent.com/FortAwesome/Font-Awesome/v4.7.0/src/3.2.1/icons.yml
     * @return array
     */
    protected function getFaIds()
    {

        $strFile = file_get_contents(TL_ROOT . '/vendor/markocupic/fontawesome-icon-picker-bundle/src/Resources/fontawesome/icons.yml');

        $arrYaml = Yaml::parse($strFile);
        foreach ($arrYaml as $faId => $arrItemProps)
        {
            $arrItem = array(
                'id' => $faId,
                'style' => 'solid',
                'faStyle' => 'fas',
                'faClass' => 'fa-' . $faId,
                'availableStyles' => $arrItemProps['styles']

            );

            if (is_array($arrItemProps['styles']))
            {
                if (in_array('regular', $arrItemProps['styles']))
                {
                    $arrItem['style'] = 'regular';
                    $arrItem['faStyle'] = 'far';
                }

                if (in_array('light', $arrItemProps['styles']))
                {
                    $arrItem['style'] = 'light';
                    $arrItem['faStyle'] = 'fal';
                }

                if (in_array('brands', $arrItemProps['styles']))
                {
                    $arrItem['style'] = 'brands';
                    $arrItem['faStyle'] = 'fab';
                }
            }
            $arrMatches[] = $arrItem;
        }

        return $arrMatches;
    }

}