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

namespace Markocupic\FontawesomeIconPickerBundle;

class FontAwesomeStyles
{
    public static function getStyles(): array
    {
        return [
            'fa-solid',
            'fa-regular',
            'fa-light',
            'fa-brands',
            'fa-duotone',
            'fa-thin',
        ];
    }
}
