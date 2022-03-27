import $ from "jquery";

$(function(){
    const modalBody = $('#modalBody');
    const modalPlaceholder = modalBody.children(':first-child').clone();

    //Add AJAX to every button with deatailed info
    $('.btn-outline-success').each(function(index){
        $(this).on('click',function(){
            let categoryId = $(this).data('category');
            $.ajax({
                url: '/api/category/'+categoryId,
            }).done(function(data){
                $('#modalSpinner').toggleClass('d-none');
                $('#modalCategoryId').text(data.id);
                $('#modalCategoryName').text(data.name);
                $('#modalCategoryMain').text(data.main == true ? "Tak" : "Nie");
                $('#modalCategoryFinal').text(data.final == true ? "Tak" : "Nie");
                $('#modalData').toggleClass('d-none');

            })

        })
    });

    //Restore previous state after closing the modal for both closing methods
    
})