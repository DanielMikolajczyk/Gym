import $ from 'jquery';
import 'bootstrap-select';
let categoryCounter =0;
let rowNumber =0;
let groupNumber =0;
let excercises;

$(function (){
    $('#workout_users').amsifySuggestags({
        suggestionsAction : {
            minChars: 3,
            minChange: -1,
            delay: 200,
            type: 'GET',
            url: '/api/user/suggest'
        },
        selectOnHover: false,
        printValues: false,
        noSuggestionMsg: 'Nie znaleziono użytkowników.',
    })

    $('#workout_groups').amsifySuggestags({
        suggestionsAction : {
            minChars: 3,
            minChange: -1,
            delay: 200,
            type: 'GET',
            url: '/api/user-groups/suggest'
        },
        selectOnHover: false,
        printValues: false,
        noSuggestionMsg: 'Nie znaleziono grup.',
    })

    //MODAL
    //Toggle the display of underlying categories 
    $('.fa-arrow-down').on('click',function(){
        $(this).parent().parent().parent().next().toggleClass("d-none");
    });

    let chosenCategoryId = ''; 
    let chosenCategoryName = ''; 
    //Ensure choosing only one category
    $('[id^="category-"]').on('click',function(){
        $('[id^="category-"]').not(this).prop('checked',false);
        chosenCategoryId = $(this).attr('id').slice(9);
        chosenCategoryName = $(this).prev().text();
        $.ajax({
            url: '/api/exercise/category/'+chosenCategoryId
        }).done(function(data){
            excercises = data;       
        })
    });

    //Handle WorkoutKind title
    $('#workout_kind').on('change',function(){
        $('#workout_kind_title').text($('#workout_kind option:selected').text());
    });

    //Handle correct data display
    let lastInputDate = "";

    let headerOptions = `
    <option value=""></option>
    <option value="1">ROZGRZEWKA</option>
    <option value="2">REAKTYWNOŚĆ</option>
    <option value="3">PREWENCJA URAZÓW</option>
    <option value="4">WYTRZYMAŁOŚĆ</option>
    <option value="5">PRZYGOTOWANIE RUCHOWE</option>
    <option value="6">SIŁA</option>
    <option value="7">PROGRAM KOREKCYJNY</option>
    `;


    //Add new main (red) category
    $('#add_category').on('click',function(){
        categoryCounter++;

        let redHtml = 
        `<div id="category_div_number_${categoryCounter}">
            <div class="bg-danger border-dark border" data-info="cateogry">
                <select name="" class="bg-danger text-white shadow-none" id="category_${categoryCounter}">
                    ${headerOptions}
                </select>
                <span class="float-right mr-3 text-white" id="category_remove_${categoryCounter}">
                    <i class="fa-solid fa-minus"></i>
                </span>
            </div>
        </div>`;

        let warmupHeaderHtml =
        `<div data-info="category_group">
            <div class="row g-0 mx-0 bg-warning font-weight-bold" data-info="category_headers">
                <div class="col-1 p-0 bg-warning border border-dark">
                    Data
                </div>
                <div class="col-3 p-0 bg-warning border border-dark">
                    Forma
                    <span class="float-right mr-1">
                        <i id="warmup_remove_rows" class="fa-solid fa-minus"></i>
                    </span>
                    <span class="float-right mr-1">
                        <i id="warmup_add_rows" class="fa-solid fa-plus"></i>
                    </span>
                </div>
                <div class="col-8 p-0 bg-warning border border-dark">
                    Uwagi
                </div>
            </div>
        </div>`; 

        let reactivityHeaderHtml = 
        `<div data-info="category_group">
            <div class="row g-0 mx-0 bg-warning font-weight-bold" data-info="category_headers">
                <div class="col-1 p-0 bg-warning border border-dark">
                    Data
                </div>
                <div class="col-4 p-0 bg-warning border border-dark">
                    Ćwiczenie
                    <span class="float-right mr-1">
                        <i id="reactivity_remove_rows" class="fa-solid fa-minus"></i>
                    </span>
                    <span class="float-right mr-1">
                        <i id="reactivity_add_rows" class="fa-solid fa-plus"></i>
                    </span>
                </div>
                <div class="col-2 p-0 bg-warning border border-dark">
                    Serie
                </div>
                <div class="col-2 p-0 bg-warning border border-dark">
                    Powtórzenia
                </div>
                <div class="col-2 p-0 bg-warning border border-dark">
                    Obciążenie
                </div>
                <div class="col-1 p-0 bg-warning border border-dark">
                    Przerwa
                </div>
            </div>
        </div>`;

        let injuryPreventionHeaderHtml = 
        `<div data-info="category_group">
            <div class="row g-0 mx-0 bg-warning font-weight-bold" data-info="category_headers">
                <div class="col-1 p-0 bg-warning border border-dark">
                    Data
                </div>
                <div class="col-4 p-0 bg-warning border border-dark">
                    Ćwiczenie
                    <span class="float-right mr-1">
                        <i id="injury_prevention_remove_rows" class="fa-solid fa-minus"></i>
                    </span>
                    <span class="float-right mr-1">
                        <i id="injury_prevention_add_rows" class="fa-solid fa-plus"></i>
                    </span>
                </div>
                <div class="col-2 p-0 bg-warning border border-dark">
                    Serie
                </div>
                <div class="col-2 p-0 bg-warning border border-dark">
                    Powt.
                </div>
                <div class="col-2 p-0 bg-warning border border-dark">
                    Obciążenie
                </div>
                <div class="col-1 p-0 bg-warning border border-dark">
                    Przerwa
                </div>
            </div>
        </div>`;
    
        let enduranceHeaderHtml =
        `<div data-info="category_group">
            <div class="row g-0 mx-0 bg-warning font-weight-bold" data-info="category_headers">
                <div class="col-1 p-0 bg-warning border border-dark fs-6">
                    Data
                </div>
                <div class="col-2 p-0 border border-dark bg-warning">
                    Metoda
                    <span class="float-right mr-1">
                        <i id="endurance_remove_rows" class="fa-solid fa-minus"></i>
                    </span>
                    <span class="float-right mr-1">
                        <i id="endurance_add_rows" class="fa-solid fa-plus"></i>
                    </span>
                </div>
                <div class="col-1 p-0 border border-dark bg-warning">
                    Intensywność
                </div>
                <div class="col-2 p-0 border border-dark bg-warning">
                    Dł. Odcinka
                </div>
                <div class="col-1 p-0 border border-dark bg-warning">
                    Serie
                </div>
                <div class="col-1 p-0 border border-dark bg-warning">
                    Powt.
                </div>
                <div class="col-2 p-0 border border-dark bg-warning">
                    Praca : wypoczynek
                </div>
                <div class="col-2 p-0 border border-dark bg-warning">
                    Charakter przerwy
                </div>
            </div>
        </div>`;
        
        let preparationHeadersShort =
        `<div class="row g-0 mx-0 bg-warning border border-dark" data-info="category_headers">
            <div class="col-6 border border-dark">
                Ćwiczenie
                <span class="float-right mr-3">
                    <i id="rolling_add" class="fa-solid fa-minus"></i>
                </span>
                <span class="float-right mr-3">
                    <i id="rolling_add" class="fa-solid fa-plus"></i>
                </span>
            </div>
            <div class="col-6 border border-dark">
                Dozowanie
            </div>
        </div>`;

        let preparationHeadersLong = 
        `<div class="row g-0 mx-0 bg-warning border border-dark" data-info="category_headers">
            <div class="col-2 border border-dark">
                Tydzień
            </div>
            <div class="col-3 border border-dark">
                Ćwiczenie
                <span class="float-right mr-3">
                    <i id="rolling_add" class="fa-solid fa-minus"></i>
                </span>
                <span class="float-right mr-3">
                    <i id="rolling_add" class="fa-solid fa-plus"></i>
                </span>
            </div>
            <div class="col-2 border border-dark">
                Serie
            </div>
            <div class="col-2 border border-dark">
                Powt.
            </div>
            <div class="col-2 border border-dark">
                Obciążenie
            </div>
            <div class="col-1 border border-dark">
                Przerwa
            </div>
        </div>`;



        //Add new red main category
        $('#table-header').append(redHtml);

        //On change o the selected name of red category
        //Remove all previous headers and inputs and + sign
        //And add new headers
        $(`#category_${categoryCounter}`).on('change',function(){
            
            // On cateogry change remove all data below
            $(this).parent().parent().children().slice(1).remove();

            //Adding new headers and inputs listeners
            let selectedOption = $(this).val();
            switch(selectedOption){
                case '1': 
                    //Remove plus sing on red category
                    if($(this).parent().children().length > 2){
                        $(this).parent().children(':last-child').remove();
                    }
                    //Add new header
                    $(this).parent().parent().append(warmupHeaderHtml);

                    //Add new input row
                    $(this).parent().next().children(':first-child').find('span').eq(1).on('click',function(){
                        //Count number of elements: 1st row is 3rd child
                        groupNumber = 0;
                        rowNumber = $(this).parent().parent().parent().children().length - 1;
                        let warmupInputsHtml =
                        `<div class="row g-0 mx-0" data-info="row">
                            <div class="col-1 p-0">
                                <input type="text" class="w-100 h-100 o-p-input border border-dark o-bg-gray-400" name="plan[warmup][${groupNumber}][${rowNumber}][date]" value="${lastInputDate}" data-info="date">
                            </div>
                            <div class="col-3 p-0">
                                <select name="plan[warmup][${groupNumber}][${rowNumber}][excercise]" id="" class="w-100" title="Wybierz ćwiczenia" multiple>
                                <optgroup label="${chosenCategoryName}">`
                                    excercises.forEach((element)=>{
                                        warmupInputsHtml+=`<option value="${element['id']}">${element['name']}</option>`
                                    });
                                    warmupInputsHtml+=
                                `</select>
                            </div>
                            <div class="col-8 p-0">
                                <input type="text" name="plan[warmup][${groupNumber}][${rowNumber}][description]" class="w-100 h-100 o-p-input border border-dark o-bg-gray-400">
                            </div>
                        </div>`;
                        $(this).parent().parent().parent().append(warmupInputsHtml);
                        $(this).parent().parent().parent().children(':last-child').find('select').selectpicker();
                        $(this).parent().parent().parent().children(':last-child').find('[data-info="date"]').on('change',function(){lastInputDate = $(this).val()});
                    })

                    //Remove last input row
                    $(this).parent().next().children(':first-child').find('span').eq(0).on('click',function(){
                        $(this).parent().parent().parent().children(':last-child').remove();
                    })
                    break;

                case '2':
                    //Remove plus sing on red category
                    if($(this).parent().children().length > 2){
                        $(this).parent().children(':last-child').remove();
                    }
                    //Add button to create new header lines
                    $(this).parent().parent().children().eq(0).append(`
                        <span class="float-right mr-3 text-white">
                            <i class="fa-solid fa-plus"></i>
                        </span>`);
                    //Add button pressed (red one)
                    $(this).next().next().on('click',function(){
                        //Create new group with headers row
                        $(this).parent().parent().append(reactivityHeaderHtml);
                        //Add event listener for adding new rows to the group
                        $(this).parent().parent().children(':last-child').children(':first-child').children(':nth-child(2)').children(':last-child')
                            .on('click',function(){
                            groupNumber = $(this).parent().parent().parent().index() - 1;
                            rowNumber = $(this).parent().parent().parent().children().length - 1;
                            let reactivityInputsHtml = 
                            `<div class="row g-0 mx-0" data-info="row">
                                <div class="col-1 p-0">
                                    <input class="w-100 h-100 o-p-input border border-dark o-bg-gray-400" type="text" name="plan[reactivity][${groupNumber}][${rowNumber}][date]" value="${lastInputDate}" data-info="date">
                                </div>
                                <div class="col-4 p-0">
                                    <select name="plan[reactivity][${groupNumber}][${rowNumber}][excercise]" id="" class="w-100" title="Wybierz ćwiczenie" >
                                        <optgroup label="${chosenCategoryName}">`
                                        excercises.forEach((element)=>{
                                                reactivityInputsHtml+=`<option value="${element['id']}">${element['name']}</option>`
                                            });
                                        reactivityInputsHtml+=
                                    `</select>
                                </div>
                                <div class="col-2 p-0">
                                    <input class="w-100 h-100 o-p-input border border-dark o-bg-gray-400" type="text" name="plan[reactivity][${groupNumber}][${rowNumber}][series]">
                                </div>
                                <div class="col-2 p-0">
                                    <input class="w-100 h-100 o-p-input border border-dark o-bg-gray-400" type="text" name="plan[reactivity][${groupNumber}][${rowNumber}][repetition]">
                                </div>
                                <div class="col-2 p-0">
                                    <input class="w-100 h-100 o-p-input border border-dark o-bg-gray-400" type="text" name="plan[reactivity][${groupNumber}][${rowNumber}][load]">
                                </div>
                                <div class="col-1 p-0">
                                    <input class="w-100 h-100 o-p-input border border-dark o-bg-gray-400" type="text" name="plan[reactivity][${groupNumber}][${rowNumber}][break]">
                                </div>
                            </div>`;
                            $(this).parent().parent().parent().append(reactivityInputsHtml);
                            $(this).parent().parent().parent().children(':last-child').find('select').selectpicker();
                            $(this).parent().parent().parent().children(':last-child').find('[data-info="date"]').on('change',function(){lastInputDate = $(this).val()});
                        });

                        //Add event listener for removing last row of the group
                        $(this).parent().parent().children(':last-child').children(':first-child').children(':nth-child(2)').children(':nth-child(1)')
                            .on('click',function(){
                                $(this).parent().parent().parent().children(':last-child').remove();
                            });
                    })
                    
                    break;

                case '3':
                    //Remove plus sing on red category
                    if($(this).parent().children().length > 2){
                        $(this).parent().children(':last-child').remove();
                    }
                    //Add button to create new header lines
                    $(this).parent().parent().children().eq(0).append(`
                        <span class="float-right mr-3 text-white">
                            <i class="fa-solid fa-plus"></i>
                        </span>`);
                    //Add button pressed (red one)
                    $(this).next().next().on('click',function(){
                        //Create new group with headers row
                        $(this).parent().parent().append(injuryPreventionHeaderHtml);
                        //Add event listener for adding new rows to the group
                        $(this).parent().parent().children(':last-child').children(':first-child').children(':nth-child(2)').children(':last-child')
                            .on('click',function(){
                            groupNumber = $(this).parent().parent().parent().index() - 1;
                            rowNumber = $(this).parent().parent().parent().children().length - 1;
                            let injuryPreventionInputsHtml = 
                            `<div class="row g-0 mx-0" data-info="row">
                                <div class="col-1 p-0">
                                    <input class="w-100 h-100 border border-dark o-p-input o-bg-gray-400" type="text" name="plan[injuryPrevention][${groupNumber}][${rowNumber}][date]" value="${lastInputDate}" data-info="date">
                                </div>
                                <div class="col-4 p-0">
                                    <select id="" class="w-100" name="plan[injuryPrevention][${groupNumber}][${rowNumber}][excercise]" title="Wybierz ćwiczenie">
                                        <optgroup label="${chosenCategoryName}">`
                                        excercises.forEach((element)=>{
                                            injuryPreventionInputsHtml+=`<option value="${element['id']}">${element['name']}</option>`
                                        });
                                        injuryPreventionInputsHtml+=
                                        `</select>
                                    </select>
                                </div>
                                <div class="col-2 p-0">
                                    <input class="w-100 h-100 border border-dark o-p-input o-bg-gray-400" type="text" name="plan[injuryPrevention][${groupNumber}][${rowNumber}][series]">
                                </div>
                                <div class="col-2 p-0">
                                    <input class="w-100 h-100 border border-dark o-p-input o-bg-gray-400" type="text" name="plan[injuryPrevention][${groupNumber}][${rowNumber}][load]">
                                </div>
                                <div class="col-2 p-0">
                                    <input class="w-100 h-100 border border-dark o-p-input o-bg-gray-400" type="text" name="plan[injuryPrevention][${groupNumber}][${rowNumber}][repetition]">
                                </div>
                                <div class="col-1 p-0">
                                    <input class="w-100 h-100 border border-dark o-p-input o-bg-gray-400" type="text" name="plan[injuryPrevention][${groupNumber}][${rowNumber}][break]">
                                </div>
                            </div>`;
                            $(this).parent().parent().parent().append(injuryPreventionInputsHtml);
                            $(this).parent().parent().parent().children(':last-child').find('select').selectpicker();
                            $(this).parent().parent().parent().children(':last-child').find('[data-info="date"]').on('change',function(){lastInputDate = $(this).val()});
                        })
                        //Add event listener for removing last row of the group
                        $(this).parent().parent().children(':last-child').children(':first-child').children(':nth-child(2)').children(':nth-child(1)')
                            .on('click',function(){
                                $(this).parent().parent().parent().children(':last-child').remove();
                        });
                    });
                    break;

                case '4':
                    //Remove plus sing on red category
                    if($(this).parent().children().length > 2){
                        $(this).parent().children(':last-child').remove();
                    }
                    //Add Headers
                    $(this).parent().parent().append(enduranceHeaderHtml);
                    //Add listener for adding rows  
                    $(this).parent().next().children(':first-child').find('span').eq(1).on('click',function(){
                        groupNumber = $(this).parent().parent().parent().index() - 1;
                        rowNumber = $(this).parent().parent().parent().children().length - 1;
                        let enduranceInputsHtml =
                        `<div class="row g-0 mx-0" data-info="row">
                            <div class="col-1 p-0">
                                <input class="w-100 h-100 o-p-input border border-dark o-bg-gray-400" type="text" name="plan[endurance][${groupNumber}][${rowNumber}][date]" value="${lastInputDate}" data-info="date">
                            </div>
                            <div class="col-2 p-0">
                            <select name="plan[endurance][${groupNumber}][${rowNumber}][excercise]" id="" class="w-100" title="Wybierz ćwiczenie" >
                                <optgroup label="${chosenCategoryName}">`
                                excercises.forEach((element)=>{
                                        enduranceInputsHtml+=`<option value="${element['id']}">${element['name']}</option>`
                                    });
                                enduranceInputsHtml+=
                            `</select>
                            </div>
                            <div class="col-1 p-0">
                                <select class="w-100" name="plan[endurance][${groupNumber}][${rowNumber}][intensity]">
                                    <optgroup label="Intensywność">
                                        <option value="80%MAS">80%MAS</option>
                                        <option value="85%MAS">85%MAS</option>
                                        <option value="90%MAS">90%MAS</option>
                                        <option value="95%MAS">95%MAS</option>
                                        <option value="100%MAS">100%MAS</option>
                                        <option value="105%MAS">105%MAS</option>
                                        <option value="110%MAS">110%MAS</option>
                                        <option value="115%MAS">115%MAS</option>
                                        <option value="120%MAS">120%MAS</option>
                                        <option value="125%MAS">125%MAS</option>
                                        <option value="130%MAS">130%MAS</option>
                                        <option value="3,4m/s">3,4m/s</option>
                                        <option value="3,6m/s">3,6m/s</option>
                                        <option value="3,8m/s">3,8m/s</option>
                                        <option value="4,0m/s">4,0m/s</option>
                                        <option value="4,2m/s">4,2m/s</option>
                                        <option value="4,4m/s">4,4m/s</option>
                                        <option value="4,6m/s">4,6m/s</option>
                                        <option value="4,8m/s">4,8m/s</option>
                                        <option value="5,0m/s">5,0m/s</option>
                                        <option value="Max.">Max.</option>
                                        <option value="Sprint">Sprint</option>
                                        <option value="Tlenowa regeneracyjna 60-75% HR max.">Tlenowa regeneracyjna 60-75% HR max.</option>
                                        <option value="Podprogowa 75-85% HR max.">Podprogowa 75-85% HR max.</option>
                                        <option value="Progowa 85% HR max.">Progowa 85% HR max.</option>
                                        <option value="Beztlenowa mleczanowa: 85-100% HR max.">Beztlenowa mleczanowa: 85-100% HR max.</option>
                                    </optgroup>
                                </select>
                            </div>
                            <div class="col-2 p-0">
                                <input class="w-100 border h-100 o-p-input border border-dark o-bg-gray-400" type="text" name="plan[endurance][${groupNumber}][${rowNumber}][length]">
                            </div>
                            <div class="col-1 p-0">
                                <input class="w-100 border h-100 o-p-input border border-dark o-bg-gray-400" type="text" name="plan[endurance][${groupNumber}][${rowNumber}][series]">
                            </div>
                            <div class="col-1 p-0">
                                <input class="w-100 border h-100 o-p-input border border-dark o-bg-gray-400" type="text" name="plan[endurance][${groupNumber}][${rowNumber}][repetition]">
                            </div>
                            <div class="col-2 p-0">
                                <input class="w-100 border h-100 o-p-input border border-dark o-bg-gray-400" type="text" name="plan[endurance][${groupNumber}][${rowNumber}][work_rest]">
                            </div>
                            <div class="col-2 p-0">
                                <input class="w-100 border h-100 o-p-input border border-dark o-bg-gray-400" type="text" name="plan[endurance][${groupNumber}][${rowNumber}][break]">
                            </div>
                        </div>`;
                        $(this).parent().parent().parent().append(enduranceInputsHtml);
                        $(this).parent().parent().parent().children(':last-child').find('select').selectpicker();
                        $(this).parent().parent().parent().children(':last-child').find('[data-info="date"]').on('change',function(){lastInputDate = $(this).val()});
                    })
                    $(this).parent().next().children(':first-child').find('span').eq(0).on('click',function(){
                        $(this).parent().parent().parent().children(':last-child').remove();
                    })
                    break;
                case '5':
                    //Remove plus sing on red category
                    if($(this).parent().children().length > 2){
                        $(this).parent().children(':last-child').remove();
                    }
                     //Add button to create new header lines
                    $(this).parent().parent().children().eq(0).append(`
                        <span class="float-right mr-3 text-white">
                            <i class="fa-solid fa-plus"></i>
                        </span>`);

                    $(this).next().next().on('click',function(){
                        groupNumber = $(this).parent().parent().children().length-1;
                        let preparationSelect = 
                        `<div data-info="category_group">
                            <div data-info="category_headers" class="font-weight-bold">
                                <div class="d-flex align-items-center justify-content-around mx-0 bg-warning border border-dark" data-info="category_headers">
                                    <div>
                                        <span>Wpisz tytuł</span>
                                        <input type="text" name="plan[preparation][${groupNumber}][title]" value="${chosenCategoryName}">
                                    </div>
                                    <div>
                                        <span>Wybierz layout</span>
                                        <select name="plan[preparation][${groupNumber}][layout]">
                                            <option value="0" selected></option>
                                            <option value="1">Opcja dwu-kolumnowa</option>
                                            <option value="2">Opcja sześcio-kolumnowa</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                        $(this).parent().parent().append(preparationSelect);
                        //On select change display different headers
                        $(this).parent().parent().children(':last-child').children(':first-child').find('select').on('change',function(){
                            //Firstly delete headers and inputs below if existing
                            if($(this).parent().parent().parent().children().length > 1){
                                $(this).parent().parent().parent().children(':last-child').remove();
                                $(this).parent().parent().parent().parent().children().slice(1).remove();
                            }
                            //Then check which headers to display
                            $(this).val() == 2 ?
                                $(this).parent().parent().parent().append(preparationHeadersLong) :
                                $(this).parent().parent().parent().append(preparationHeadersShort);
                            //Add listener for adding rows
                            $(this).parent().parent().parent().children(':last-child').find('span').eq(1).on('click',function(){
                                groupNumber = $(this).parent().parent().parent().parent().index() - 1;
                                rowNumber = $(this).parent().parent().parent().parent().children().length - 1;
                                let preparationInputsHtml = ``;
                                if($(this).parent().parent().parent().find('select').val() == 2){
                                    preparationInputsHtml =
                                    `<div class="row g-0 mx-0" data-info="row">
                                        <div class="col-2 p-0">
                                            <input class="w-100 h-100 o-p-input border border-dark o-bg-gray-400" type="text" name="plan[preparation][${groupNumber}][${rowNumber}][date]" value="${lastInputDate}" data-info="date">
                                        </div>
                                        <div class="col-3 p-0">
                                            <select name="plan[preparation][${groupNumber}][${rowNumber}][excercise]" id="" class="w-100" title="Wybierz ćwiczenie" >
                                                <optgroup label="${chosenCategoryName}">`
                                                excercises.forEach((element)=>{
                                                        preparationInputsHtml+=`<option value="${element['id']}">${element['name']}</option>`
                                                    });
                                                preparationInputsHtml+=
                                            `</select>
                                        </div>
                                        <div class="col-2 p-0">
                                            <input class="w-100 h-100 o-p-input border border-dark o-bg-gray-400" type="text" name="plan[preparation][${groupNumber}][${rowNumber}][series]">
                                        </div>
                                        <div class="col-2 p-0">
                                            <input class="w-100 h-100 o-p-input border border-dark o-bg-gray-400" type="text" name="plan[preparation][${groupNumber}][${rowNumber}][repetition]">
                                        </div>
                                        <div class="col-2 p-0">
                                            <input class="w-100 h-100 o-p-input border border-dark o-bg-gray-400" type="text" name="plan[preparation][${groupNumber}][${rowNumber}][load]">
                                        </div>
                                        <div class="col-1 p-0">
                                            <input class="w-100 h-100 o-p-input border border-dark o-bg-gray-400" type="text" name="plan[preparation][${groupNumber}][${rowNumber}][break]">
                                        </div>
                                    </div>`;
                                }else{
                                    preparationInputsHtml =
                                    `<div class="row g-0 mx-0" data-info="row">
                                        <div class="col-6 p-0">
                                            <select name="plan[preparation][${groupNumber}][${rowNumber}][excercise]" id="" class="w-100" title="Wybierz ćwiczenie" >
                                                <optgroup label="${chosenCategoryName}">`
                                                excercises.forEach((element)=>{
                                                        preparationInputsHtml+=`<option value="${element['id']}">${element['name']}</option>`
                                                    });
                                                preparationInputsHtml+=
                                            `</select>
                                        </div>
                                        <div class="col-6 p-0">
                                            <input class="w-100 h-100 o-p-input border border-dark o-bg-gray-400" type="text" name="plan[preparation][${groupNumber}][${rowNumber}][dosage]">
                                        </div>
                                    </div>`;
                                }
                                $(this).parent().parent().parent().parent().append(preparationInputsHtml);
                                $(this).parent().parent().parent().parent().children(':last-child').find('select').selectpicker();
                                $(this).parent().parent().parent().parent().children(':last-child').find('[data-info="date"]').on('change',function(){lastInputDate = $(this).val()});

                            });
                            //Add listener for removing last row
                            $(this).parent().parent().parent().children(':last-child').find('span').eq(0).on('click',function(){
                                $(this).parent().parent().parent().parent().children(':last-child').remove();
                            });
                        });
                    });
                    break;
                case '6':
                    //Remove plus sing on red category
                    if($(this).parent().children().length > 2){
                        $(this).parent().children(':last-child').remove();
                    }
                   //Add button to create new header lines
                   $(this).parent().parent().children().eq(0).append(`
                        <span class="float-right mr-3 text-white">
                            <i class="fa-solid fa-plus"></i>
                        </span>`);
                    //Add button pressed (red one)
                    $(this).next().next().on('click',function(){
                        groupNumber = $(this).parent().parent().children().length-1;
                        let strengthHeaderHtml = getHeaders('strength');
                        //Create new group with headers row
                        $(this).parent().parent().append(strengthHeaderHtml);
                        //Add event listener for adding new rows to the group
                        $(this).parent().parent().children(':last-child').children(':first-child').children(':last-child')
                            .children(':nth-child(2)').children(':last-child').on('click',function(){
                                groupNumber = $(this).parent().parent().parent().parent().index() - 1;
                                rowNumber = $(this).parent().parent().parent().parent().children().length - 1;
                                let strengthInputsHtml = 
                                `<div class="row g-0 mx-0" data-info="row">
                                    <div class="col-1 p-0">
                                        <input class="w-100 border border-dark  h-100 o-p-input o-bg-gray-400" type="text" name="plan[strength][${groupNumber}][${rowNumber}][date]" value="${lastInputDate}" data-info="date">
                                    </div>
                                    <div class="col-1 p-0">
                                        <select name="plan[strength][${groupNumber}][${rowNumber}][excercise]" id="" class="w-100" title="Wybierz ćwiczenie" >
                                            <optgroup label="${chosenCategoryName}">`
                                            excercises.forEach((element)=>{
                                                    strengthInputsHtml+=`<option value="${element['id']}">${element['name']}</option>`
                                                });
                                            strengthInputsHtml+=
                                        `</select>
                                    </div>
                                    <div class="col-1 p-0">
                                        <input class="w-100 border border-dark  h-100 o-p-input o-bg-gray-400" type="text" name="plan[strength][${groupNumber}][${rowNumber}][repetition]">
                                    </div>
                                    <div class="col-2 p-0">
                                        <input class="w-100 border border-dark  h-100 o-p-input o-bg-gray-400" type="text" name="plan[strength][${groupNumber}][${rowNumber}][rate]">
                                    </div>
                                    <div class="col-1 p-0">
                                        <input class="w-100 border border-dark  h-100 o-p-input o-bg-gray-400" type="text" name="plan[strength][${groupNumber}][${rowNumber}][break]">
                                    </div>
                                    <div class="col-1 p-0">
                                        <input class="w-100 border border-dark  h-100 o-p-input o-bg-gray-400" type="text" name="plan[strength][${groupNumber}][${rowNumber}][series1]">
                                    </div>
                                    <div class="col-1 p-0">
                                        <input class="w-100 border border-dark  h-100 o-p-input o-bg-gray-400" type="text" name="plan[strength][${groupNumber}][${rowNumber}][series2]">
                                    </div>
                                    <div class="col-1 p-0">
                                        <input class="w-100 border border-dark  h-100 o-p-input o-bg-gray-400" type="text" name="plan[strength][${groupNumber}][${rowNumber}][series3]">
                                    </div>
                                    <div class="col-1 p-0">
                                        <input class="w-100 border border-dark  h-100 o-p-input o-bg-gray-400" type="text" name="plan[strength][${groupNumber}][${rowNumber}][series4]">
                                    </div>
                                    <div class="col-1 p-0">
                                        <input class="w-100 border border-dark  h-100 o-p-input o-bg-gray-400" type="text" name="plan[strength][${groupNumber}][${rowNumber}][series5]">
                                    </div>
                                    <div class="col-1 p-0">
                                        <input class="w-100 border border-dark  h-100 o-p-input o-bg-gray-400" type="text" name="plan[strength][${groupNumber}][${rowNumber}][series6]">
                                    </div>
                                </div>`;
                                $(this).parent().parent().parent().parent().append(strengthInputsHtml);
                                $(this).parent().parent().parent().parent().children(':last-child').find('select').selectpicker();
                                $(this).parent().parent().parent().parent().children(':last-child').find('[data-info="date"]').on('change',function(){lastInputDate = $(this).val()});
                            });
                        $(this).parent().parent().children(':last-child').children(':first-child').children(':last-child')
                            .children(':nth-child(2)').children(':nth-child(1)').on('click',function(){
                                $(this).parent().parent().parent().parent().children(':last-child').remove();
                            });
                    });
                    break;
                case '7':
                    //Remove plus sing on red category
                    if($(this).parent().children().length > 2){
                        $(this).parent().children(':last-child').remove();
                    }
                     //Add button to create new header lines
                    $(this).parent().parent().children().eq(0).append(`
                        <span class="float-right mr-3 text-white">
                            <i class="fa-solid fa-plus"></i>
                        </span>`);

                    $(this).next().next().on('click',function(){
                        groupNumber = $(this).parent().parent().children().length-1;
                        let correctionHeaderHtml = getHeaders('correction');
                        //Create new group with headers row
                        $(this).parent().parent().append(correctionHeaderHtml);
                        //Add event listener for adding new rows to the group
                        $(this).parent().parent().children(':last-child').children(':first-child').children(':last-child').on('click',function(){
                            groupNumber = $(this).parent().parent().index() - 1;
                            rowNumber = $(this).parent().parent().children().length - 1;
                            let correctionInputsHtml = 
                            `<div class="row g-0 mx-0" data-info="row">
                                <div class="col-8 p-0">
                                    <select name="plan[correction][${groupNumber}][${rowNumber}][excercise]" id="" class="w-100" title="Wybierz ćwiczenie" >
                                        <optgroup label="${chosenCategoryName}">`
                                        excercises.forEach((element)=>{
                                                correctionInputsHtml+=`<option value="${element['id']}">${element['name']}</option>`
                                            });
                                        correctionInputsHtml+=
                                    `</select>
                                </div>
                                <div class="col-4 p-0">
                                    <input class="w-100 h-100 o-p-input border border-dark o-bg-gray-400" type="text" name="plan[correction][${groupNumber}][${rowNumber}][comment]">
                                </div>
                            </div>`;
                            $(this).parent().parent().append(correctionInputsHtml);
                            $(this).parent().parent().children(':last-child').find('select').selectpicker();

                        })
                        $(this).parent().parent().children(':last-child').children(':first-child').children(':nth-child(2)').on('click',function(){
                            $(this).parent().parent().children(':last-child').remove();
                        });
                    })
                    break;
                default:
                    break;
            }
        })

        //Remove whole main (red) category and its children
        $(`#category_remove_${categoryCounter}`).on('click',function(){
            $(this).parent().parent().remove()
        })

    });
   
    //TODO
    function getHeaders(mainCategory){
        switch(mainCategory){
            case 'strength':
                return `<div data-info="category_group">
                <div data-info="category_headers" class="font-weight-bold">
                    <div class="row g-0 mx-0 bg-warning border border-dark" data-info="category_headers">
                        <div class="col">
                            <input type="text" name="plan[strength][${groupNumber}][title]" value="${chosenCategoryName}">
                        </div>
                    </div>
                    <div class="row g-0 mx-0 bg-warning border border-dark">
                        <div class="col-1 p-0 border border-dark bg-warning">
                            Data
                        </div>
                        <div class="col-1 p-0 border border-dark bg-warning">
                            Serie
                            <span class="float-right mr-1">
                                <i id="injury_prevention_remove_rows" class="fa-solid fa-minus"></i>
                            </span>
                            <span class="float-right mr-1">
                                <i id="injury_prevention_add_rows" class="fa-solid fa-plus"></i>
                            </span>
                        </div>
                        <div class="col-1 p-0 border border-dark bg-warning">
                            Powt.
                        </div>
                        <div class="col-2 p-0 border border-dark bg-warning">
                            Tempo
                        </div>
                        <div class="col-1 p-0 border border-dark bg-warning">
                            Przerwa
                        </div>
                        <div class="col-1 p-0 border border-dark bg-warning">
                            Seria 1
                        </div>
                        <div class="col-1 p-0 border border-dark bg-warning">
                            Seria 2
                        </div>
                        <div class="col-1 p-0 border border-dark bg-warning">
                            Seria 3
                        </div>
                        <div class="col-1 p-0 border border-dark bg-warning">
                            Seria 4
                        </div>
                        <div class="col-1 p-0 border border-dark bg-warning">
                            Seria 5
                        </div>
                        <div class="col-1 p-0 border border-dark bg-warning">
                            Seria 6
                        </div>
                    </div>
                </div>
            </div>`;

            case 'correction':
                return `<div data-info="category_group">
                    <div class="bg-warning border border-dark font-weight-bold" data-info="category_headers">
                        <input type="text" name="plan[correction][${groupNumber}][title]" value="${chosenCategoryName}">
                        <span class="float-right mr-3">
                            <i id="rolling_add" class="fa-solid fa-minus"></i>
                        </span>
                        <span class="float-right mr-3">
                            <i id="rolling_add" class="fa-solid fa-plus"></i>
                        </span>
                    </div>
                </div>`;
        }
    }
});
