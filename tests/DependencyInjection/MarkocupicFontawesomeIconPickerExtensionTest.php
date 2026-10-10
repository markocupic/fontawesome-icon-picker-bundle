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

namespace Markocupic\FontawesomeIconPickerBundle\Tests\DependencyInjection;

use Markocupic\FontawesomeIconPickerBundle\DependencyInjection\MarkocupicFontawesomeIconPickerExtension;
use Markocupic\FontawesomeIconPickerBundle\FontAwesomeStyles;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MarkocupicFontawesomeIconPickerExtensionTest extends TestCase
{
    public function testSetsTheDefaultParameters(): void
    {
        $container = new ContainerBuilder();

        (new MarkocupicFontawesomeIconPickerExtension())->load([], $container);

        $version = trim(file_get_contents(__DIR__.'/../../fontawesome/.version'));

        $this->assertSame($version, $container->getParameter('markocupic_fontawesome_icon_picker.fontawesome_version'));
        $this->assertSame(FontAwesomeStyles::getStyles(), $container->getParameter('markocupic_fontawesome_icon_picker.fontawesome_allowed_styles'));
        $this->assertSame('https://use.fontawesome.com/releases/v'.$version.'/js/all.js', $container->getParameter('markocupic_fontawesome_icon_picker.fontawesome_source_path'));
    }

    public function testRejectsAnInvalidVersion(): void
    {
        $this->expectException(InvalidConfigurationException::class);

        (new MarkocupicFontawesomeIconPickerExtension())->load([['fontawesome_version' => '7.0']], new ContainerBuilder());
    }
}
