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
    })

});

