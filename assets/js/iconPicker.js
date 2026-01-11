/*
 * This file is part of Fontawesome Icon Picker Bundle.
 *
 * (c) Marko Cupic <m.cupic@gmx.ch>
 * @license LGPL-3.0+
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/markocupic/fontawesome-icon-picker-bundle
 */
window.addEvent('domready', function () {
    const iconBoxId = 'iconBox';
    const iconBoxInnerId = 'iconBoxInner';
    const iconBox = document.id(iconBoxId);
    const iconBoxInner = document.id(iconBoxInnerId);
    const inputIcon = document.id('ctrl_faIcon');
    const inputFilter = document.id('ctrl_faFilter');
    let blockScroll = false;

    if (!iconBox || !inputIcon || !inputFilter) {
        return;
    }

    // Scroll to the selected item
    (function () {
        if (iconBox) {
            const selectedItem = iconBoxInner.querySelector('.font-awesome-icon-item.checked');

            if (selectedItem) {
                iconBox.scrollTop = selectedItem.offsetTop - 120;
            }
        }
    })();

    // Event click on the icon
    iconBox.getElements('.font-awesome-icon-item').addEvent('click', function () {
        // Remove and re-add class 'checked'
        iconBox.getElements('.font-awesome-icon-item.checked').removeClass('checked');
        this.addClass('checked');

        // Set value
        const faIconStyle = this.getElements('.faStyleButton')[0].getProperty('data-faiconstyle');
        const faIconName = this.getElements('.faStyleButton')[0].getProperty('data-faiconname');
        const faIconUnicode = this.getElements('.faStyleButton')[0].getProperty('data-faiconunicode');

        inputIcon.setProperty('value', faIconName + '||' + faIconStyle + '||' + faIconUnicode);

        // Style button handling
        iconBox.getElements('.faStyleButton.selectedStyle').removeClass('selectedStyle');
        this.getElements('.faStyleButton')[0].addClass('selectedStyle');
    });

    // Add event to filter input
    inputFilter.addEvent('input', function () {
        const strFilter = this.getProperty('value').trim(' ');
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
        const faIconStyle = this.getProperty('data-faiconstyle');
        const faIconName = this.getProperty('data-faiconname');
        const faIconUnicode = this.getProperty('data-faiconunicode');

        inputIcon.setProperty('value', faIconName + '||' + faIconStyle + '||' + faIconUnicode);
    });
});
