import $ from 'jquery';
$(function() {
    $('.cursor-pointer').on('click',function(){
        $(this).next().toggleClass('d-none');
    })
});