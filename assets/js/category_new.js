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

    $('#category_childs').amsifySuggestags({
        suggestionsAction : {
            minChars: 1,
            minChange: -1,
            delay: 100,
            type: 'GET',
            url: '/api/excercise/suggest'
        },
        whiteList: true,
        selectOnHover: false,
        printValues: false,
        noSuggestionMsg: 'Nie znaleziono podanych ćwiczeń'
    })
});

