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

namespace Markocupic\FontawesomeIconPickerBundle\Tests\Util;

use Markocupic\FontawesomeIconPickerBundle\Util\IconUtil;
use PHPUnit\Framework\TestCase;

class IconUtilTest extends TestCase
{
    public function testReadsTheIconsOfTheAllowedStyles(): void
    {
        $iconUtil = new IconUtil(\dirname(__DIR__, 2), 'fontawesome/metadata/icons.yml', ['fa-brands']);
        $icons = $iconUtil->getIconsAll();

        $this->assertNotEmpty($icons);

        foreach ($icons as $icon) {
            $this->assertContains('brands', $icon['styles']);
            $this->assertSame('fa-'.$icon['id'], $icon['faClass']);
        }

        $this->assertArrayHasKey('github', $icons);
        $this->assertArrayNotHasKey('house', $icons);
    }

    public function testReadsAllIconsOfTheDefaultStyles(): void
    {
        $iconUtil = new IconUtil(\dirname(__DIR__, 2), 'fontawesome/metadata/icons.yml', ['fa-solid', 'fa-regular', 'fa-brands']);
        $icons = $iconUtil->getIconsAll();

        $this->assertArrayHasKey('house', $icons);
        $this->assertArrayHasKey('github', $icons);
        $this->assertContains('fa-solid', $icons['house']['faStyles']);
    }
}
