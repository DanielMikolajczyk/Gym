import $ from 'jquery';
$(function() {
    $('#user_group_Users').amsifySuggestags({
        suggestionsAction : {
            minChars: 2,
            minChange: -1,
            delay: 200,
            type: 'GET',
            url: '/api/user/suggest'
        },
        whitelist: true,
        selectOnHover: false,
        printValues: false,
        noSuggestionMsg: 'Nie znaleziono podanych użytkowników.',
        afterAdd : function(value) {
            let names = $('#user_group_Users').data("names").split(',');
            let counter = 0;
            $('.amsify-suggestags-input-area').children("span").each(function(){
                $(this).text(names[counter]);
                counter++;
            })
        },
    })

});

