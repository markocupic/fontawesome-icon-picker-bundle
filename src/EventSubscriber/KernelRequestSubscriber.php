<?php

declare(strict_types=1);

/*
 * This file is part of Fontawesome Icon Picker Bundle.
 *
 * (c) Marko Cupic 2022 <m.cupic@gmx.ch>
 * @license LGPL-3.0+
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/markocupic/fontawesome-icon-picker-bundle
 */

namespace Markocupic\FontawesomeIconPickerBundle\EventSubscriber;

use Contao\CoreBundle\Routing\ScopeMatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelRequestSubscriber implements EventSubscriberInterface
{
    protected ScopeMatcher $scopeMatcher;
    protected string $fontawesomeSourcePath;

    public function __construct(ScopeMatcher $scopeMatcher, string $fontawesomeSourcePath)
    {
        $this->scopeMatcher = $scopeMatcher;
        $this->fontawesomeSourcePath = $fontawesomeSourcePath;
    }

    public static function getSubscribedEvents()
    {
        return [KernelEvents::REQUEST => 'onKernelRequest'];
    }

    public function onKernelRequest(RequestEvent $e): void
    {
        $request = $e->getRequest();

        if ($this->scopeMatcher->isBackendRequest($request)) {
            $GLOBALS['TL_CSS'][] = 'bundles/markocupicfontawesomeiconpicker/css/iconPicker.css|static';
            $GLOBALS['TL_JAVASCRIPT'][] = 'bundles/markocupicfontawesomeiconpicker/js/iconPicker.js';
            $GLOBALS['TL_JAVASCRIPT'][] = $this->fontawesomeSourcePath;
        }
    }
}
