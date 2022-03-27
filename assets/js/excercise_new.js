import $ from 'jquery';
$(function() {
    $('#excercise_categories').amsifySuggestags({
        suggestionsAction : {
            minChars: 2,
            minChange: -1,
            delay: 200,
            type: 'GET',
            url: '/api/category/suggest/final'
        },
        whitelist: true,
        selectOnHover: false,
        printValues: false,
        noSuggestionMsg: 'Nie znaleziono podanych ćwiczeń',
    })

});

