window.addEvent('domready', function (event) {
    if ($$('#ctrl_faIcon #iconBox .checked').length) {
        // Scroll to selected icon
        new Fx.Scroll(document.id('iconBox')).toElement($$('#ctrl_faIcon #iconBox .checked')[0]);
    }
    $$('#iconBox .font-awesome-icon-item').addEvent('click', function (event) {
        $$('#ctrl_faIcon #iconBox .checked').removeClass('checked');
        $$('#ctrl_faIcon #iconBox input').removeProperty('checked').set('checked', false);

        // Set value
        var faStyle = this.getElements('.faStyle')[0].getProperty('data-fa-style');
        var faId = this.getProperty('data-faClass');
        $$('input[name="faIcon"]').setProperty('value', faId + '||' + faStyle);

        this.addClass('checked');
        // Style button handling
        $$('#ctrl_faIcon #iconBox .faStyle.selectedStyle').removeClass('selectedStyle');
        this.getElements('.faStyle')[0].addClass('selectedStyle');
    });

    // Add event to filter input
    $$('input#faClassFilter').addEvent('input', function (event) {
        var strFilter = this.getProperty('value').trim(' ');
        var itemCollection = $$('.font-awesome-icon-item');
        itemCollection.each(function (el) {
            el.removeClass('filtered');
            if (strFilter != '') {
                if (el.getProperty('data-faClass').contains(strFilter) === false) {
                    el.addClass('filtered');
                }
            } else {
                if ($$('#ctrl_faIcon #iconBox .checked').length) {
                    // Scroll to selected icon
                    new Fx.Scroll(document.id('iconBox')).toElement($$('#ctrl_faIcon #iconBox .checked')[0]);
                }
            }
        });
    });

    // Style buttons
    $$('#iconBox .font-awesome-icon-item .faStyle').addEvent('click', function (e) {

        e.preventDefault();
        e.stopPropagation();
        $$('#iconBox .font-awesome-icon-item .faStyle').removeClass('selectedStyle');
        this.addClass('selectedStyle');

        // Set value
        var faStyle = this.getProperty('data-fa-style');
        var faId = this.getParents('.font-awesome-icon-item')[0].getProperty('data-faClass');
        $$('input[name="faIcon"]').setProperty('value', faId + '||' + faStyle);
    });
});