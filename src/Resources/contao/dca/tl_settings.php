<?php

// Palettes
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] = str_replace('{files_legend', '{fontawesome_icon_picker_legend:hide},serviceLinkFontawesomeSRC;{files_legend', $GLOBALS['TL_DCA']['tl_settings']['palettes']['default']);


// Fields
$GLOBALS['TL_DCA']['tl_settings']['fields']['serviceLinkFontawesomeSRC'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_settings']['serviceLinkFontawesomeSRC'],
    'inputType' => 'text',
    'eval' => array('mandatory' => false, 'tl_class' => 'w50')
);