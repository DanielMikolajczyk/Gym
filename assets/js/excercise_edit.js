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
        selectOnHover: false,
        printValues: false,
        noSuggestionMsg: 'Nie znaleziono podanych ćwiczeń',
        afterAdd : function(value) {
            let names = $('#excercise_categories').data("names").split(',');
            let counter = 0;
            $('.amsify-suggestags-input-area').children("span").each(function(){
                $(this).text(names[counter]);
                counter++;
            })
        },
    })

});

