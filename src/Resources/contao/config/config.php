<?php

// ServiceLinks require FontAwesome 5
define('SERVICE_LINK_FONTAWESOME_VERSION', '5.0.1');



if (TL_MODE == 'BE')
{
    $GLOBALS['TL_CSS'][] = 'bundles/markocupicfontawesomeiconpicker/css/iconPicker.css|static';
    $GLOBALS['TL_JAVASCRIPT'][] = 'bundles/markocupicfontawesomeiconpicker/js/iconPicker.js';

    if(Config::get('fontawesomIconPickerFontawesomeSRC') != '')
    {
        // Use custom version
        $GLOBALS['TL_JAVASCRIPT'][] = \Contao\Config::get('fontawesomIconPickerFontawesomeSRC');
    }
    else
    {
        // Use free version
        $GLOBALS['TL_JAVASCRIPT'][] = 'https://use.fontawesome.com/releases/v5.0.1/js/all.js';
    }

}


$GLOBALS['BE_FFL']['fontawesome5Iconpicker'] = 'Markocupic\ServiceLinkBundle\ContaoBackendWidget\Fontawesome5Iconpicker';