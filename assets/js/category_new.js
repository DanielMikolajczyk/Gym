import $ from 'jquery';
$(document).ready(function() {
    let sth = $('input[name="asd"]').data('info').split(',');
    console.log(sth)
    
    // $('#input_category_name').amsifySuggestags({
    //     suggestions: sth,
    //     whiteList: true,
    //     defaultTagClass: 'badge',
    //     classes: ['bg-primary', 'bg-success', 'bg-danger', 'bg-warning', 'bg-info'],
    //     selectOnHover: false,
    //     printValues: false,
    // });

    $('#input_category_name').amsifySuggestags({
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
    })
});

