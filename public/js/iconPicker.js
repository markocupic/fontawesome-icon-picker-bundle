/*
 * This file is part of Fontawesome Icon Picker Bundle.
 *
 * (c) Marko Cupic 2023 <m.cupic@gmx.ch>
 * @license LGPL-3.0+
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/markocupic/fontawesome-icon-picker-bundle
 */
window.addEvent('domready', function () {

    var iconBox = document.id('iconBox');
    var inputIcon = document.id('ctrl_faIcon');
    var inputFilter = document.id('ctrl_faFilter');
    var blockScroll = false;

    if (!iconBox || !inputIcon || !inputFilter) {
        return;
    }

    // Scroll on domready to selected icon
    if (iconBox.getElements('.font-awesome-icon-item.checked').length) {
        new Fx.Scroll(iconBox).toElement(iconBox.getElements('.font-awesome-icon-item.checked')[0]);
    }

    // Event click on the icon
    iconBox.getElements('.font-awesome-icon-item').addEvent('click', function () {
        // Remove and readd class 'checked'
        iconBox.getElements('.font-awesome-icon-item.checked').removeClass('checked');
        this.addClass('checked');

        // Set value
        var faIconPrefix = this.getElements('.faStyleButton')[0].getProperty('data-faiconprefix');
        var faIconName = this.getElements('.faStyleButton')[0].getProperty('data-faiconname');
        var faIconUnicode = this.getElements('.faStyleButton')[0].getProperty('data-faiconunicode');

        inputIcon.setProperty('value', faIconName + '||' + faIconPrefix + '||' + faIconUnicode);

        // Style button handling
        iconBox.getElements('.faStyleButton.selectedStyle').removeClass('selectedStyle');
        this.getElements('.faStyleButton')[0].addClass('selectedStyle');
    });

    // Add event to filter input
    inputFilter.addEvent('input', function () {
        var strFilter = this.getProperty('value').trim(' ');
        iconBox.getElements('.faStyleButton').each(function (el) {
            el.getParents('.font-awesome-icon-item').removeClass('filtered');
            if (strFilter !== '') {
                if (el.getProperty('data-faiconname').contains(strFilter) === false) {
                    el.getParents('.font-awesome-icon-item').addClass('filtered');
                }
            } else {
                if (iconBox.getElements('.font-awesome-icon-item.checked').length) {
                    // Scroll to selected icon
                    if (!blockScroll) {
                        blockScroll = true;
                        window.setTimeout(function () {
                            new Fx.Scroll(iconBox).toElement(iconBox.getElements('.font-awesome-icon-item.checked')[0]);
                        }, 400);
                        window.setTimeout(function () {
                            blockScroll = false;
                        }, 1000);
                    }

                }
            }
        });
    });

    // Event click on style buttons
    iconBox.getElements('.font-awesome-icon-item .faStyleButton').addEvent('click', function (e) {

        e.preventDefault();
        e.stopPropagation();
        // Remove and add class again
        iconBox.getElements('.font-awesome-icon-item .faStyleButton').removeClass('selectedStyle');
        this.addClass('selectedStyle');

        // Set value
        var faIconPrefix = this.getProperty('data-faiconprefix');
        var faIconName = this.getProperty('data-faiconname');
        var faIconUnicode = this.getProperty('data-faiconunicode');

        inputIcon.setProperty('value', faIconName + '||' + faIconPrefix + '||' + faIconUnicode);
    });
});