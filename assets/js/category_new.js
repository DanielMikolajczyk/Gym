import $ from 'jquery';
$(document).ready(function() {
    //let sth = $('#category_childs').data('info').split(',');
    //console.log(sth)
    
    // $('#input_category_name').amsifySuggestags({
    //     suggestions: sth,
    //     whiteList: true,
    //     defaultTagClass: 'badge',
    //     classes: ['bg-primary', 'bg-success', 'bg-danger', 'bg-warning', 'bg-info'],
    //     selectOnHover: false,
    //     printValues: false,
    // });

    $('#category_excercises').amsifySuggestags({
        suggestionsAction : {
            minChars: 2,
            minChange: -1,
            delay: 200,
            type: 'GET',
            url: '/api/exercise/suggest'
        },
        whiteList: true,
        selectOnHover: false,
        printValues: false,
        noSuggestionMsg: 'Nie znaleziono podanych ćwiczeń'
    })

    $('#category_parent').amsifySuggestags({
        suggestionsAction : {
            minChars: 2,
            minChange: -1,
            delay: 500,
            type: 'GET',
            url: '/api/category/suggest'
        },
        whiteList: true,
        selectOnHover: false,
        printValues: false,
        noSuggestionMsg: 'Nie znaleziono podanej kateogrii'
    })

    $('#category_parent_data').data('information',50);
});

