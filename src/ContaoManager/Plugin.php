<?php
/**
 * @copyright  Marko Cupic 2017 <m.cupic@gmx.ch>
 * @author     Marko Cupic
 * @package    GalleryCreatrBundle
 * @license    LGPL-3.0+
 * @see	       https://github.com/markocupic/gallery-creator-bundle
 *
 */
namespace Markocupic\FontawesomeIconPickerBundle\ContaoManager;

use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

/**
 * Plugin for the Contao Manager.
 *
 * @author Marko Cupic
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create('Markocupic\FontawesomeIconPickerBundle\MarkocupicFontawesomeIconPickerBundle')
                ->setLoadAfter(['Contao\CoreBundle\ContaoCoreBundle']), 
        ];
    }
}
