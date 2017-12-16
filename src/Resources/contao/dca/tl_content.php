<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * @package Gallery Creator
 * @link    http://www.contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Add fields to tl_content
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['faIcon'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['faIcon'],
    'search' => true,
    'inputType' => 'fontawesome5Iconpicker',
    'eval' => array('doNotShow' => true),
    'sql' => "blob NULL",
);



