document.addEventListener('DOMContentLoaded', () => {
    const iconBoxId = 'iconBox';
    const iconBoxInnerId = 'iconBoxInner';

    const iconBox = document.getElementById(iconBoxId);
    const iconBoxInner = document.getElementById(iconBoxInnerId);
    const inputIcon = document.getElementById('ctrl_faIcon');
    const inputFilter = document.getElementById('ctrl_faFilter');

    let blockScroll = false;

    if (!iconBox || !inputIcon || !inputFilter) {
        return;
    }

    // Scroll to the selected item
    (() => {
        const selectedItem = iconBoxInner?.querySelector('.font-awesome-icon-item.checked');
        if (selectedItem) {
            iconBox.scrollTop = selectedItem.offsetTop - 120;
        }
    })();

    // Event: click on icon item
    iconBox.querySelectorAll('.font-awesome-icon-item').forEach(item => {
        item.addEventListener('click', (e) => {
            // Remove old "checked"
            iconBox.querySelectorAll('.font-awesome-icon-item.checked').forEach(el => el.classList.remove('checked'));

            item.classList.add('checked');

            // Set the style of the first button as default
            const btn = item.querySelector('.faStyleButton');
            const faIconStyle = btn.dataset.faiconstyle;
            const faIconName = item.dataset.faiconname;
            const faIconUnicode = item.dataset.faiconunicode;

            inputIcon.value = JSON.stringify([faIconName, faIconStyle, faIconUnicode]);

            // Style button handling
            iconBox.querySelectorAll('.faStyleButton.selectedStyle').forEach(el => el.classList.remove('selectedStyle'));

            btn.classList.add('selectedStyle');
        });
    });

    // Event: filter input
    inputFilter.addEventListener('input', () => {
        const strFilter = inputFilter.value.trim();

        iconBox.querySelectorAll('.font-awesome-icon-item').forEach(item => {
            item.classList.remove('filtered');

            if (strFilter !== '') {
                const name = item.dataset.faiconname || '';
                const terms = item.dataset.fasearchterms || '';

                if (!name.includes(strFilter) && !terms.includes(strFilter)) {
                    item.classList.add('filtered');
                }
            } else {
                // Scroll back to the selected icon
                const selected = iconBox.querySelector('.font-awesome-icon-item.checked');
                if (selected && !blockScroll) {
                    blockScroll = true;

                    setTimeout(() => {
                        selected.scrollIntoView({behavior: 'smooth', block: 'center'});
                    }, 400);

                    setTimeout(() => {
                        blockScroll = false;
                    }, 1000);
                }
            }
        });
    });

    // Event: click on style buttons
    iconBox.querySelectorAll('.font-awesome-icon-item .faStyleButton').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            e.stopPropagation();

            // Remove old selectedStyle
            iconBox.querySelectorAll('.faStyleButton.selectedStyle').forEach(el => el.classList.remove('selectedStyle'));

            btn.classList.add('selectedStyle');

            const iconItem = btn.closest('.font-awesome-icon-item');
            // Set value
            const faIconStyle = btn.dataset.faiconstyle;
            const faIconName = iconItem.dataset.faiconname;
            const faIconUnicode = iconItem.dataset.faiconunicode;

            inputIcon.value = JSON.stringify([faIconName, faIconStyle, faIconUnicode]);
        });
    });
});
