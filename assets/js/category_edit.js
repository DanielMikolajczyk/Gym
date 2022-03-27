import $ from 'jquery';
$(function() {
    $('#category_parent').amsifySuggestags({
        suggestionsAction : {
            minChars: 2,
            minChange: -1,
            delay: 200,
            type: 'GET',
            url: '/api/category/suggest'
        },
        selectOnHover: false,
        printValues: false,
        noSuggestionMsg: 'Nie znaleziono podanych ćwiczeń',
        afterAdd : function(value) {
            let names = $('#category_parent').data("names").split(',');
            let counter = 0;
            $('#category_parent').next().children(':first-child').children("span").each(function(){
                $(this).text(names[counter]);
                counter++;
            })
        },
    })

    $('#category_excercises').amsifySuggestags({
        suggestionsAction : {
            minChars: 2,
            minChange: -1,
            delay: 200,
            type: 'GET',
            url: '/api/exercise/suggest'
        },
        selectOnHover: false,
        printValues: false,
        noSuggestionMsg: 'Nie znaleziono podanych ćwiczeń',
        afterAdd : function(value) {
            let names = $('#category_excercises').data("names").split(',');
            let counter = 0;
            $('#category_excercises').next().children(':first-child').children("span").each(function(){
                $(this).text(names[counter]);
                counter++;
            })
        },
    })

});

