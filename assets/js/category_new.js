import $ from 'jquery';
$(function() {
    $('#category_final').prop('checked',true);
    $('#category_final').on("change",function(){
        $('#category_excercises').parent().toggleClass('d-none');
        $('#category_excercises').val('');
        // $('.amsify-suggestags-input-area').children("span").each(function(){
        //     console.log("1");
        // });
    });

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


    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    });
});

