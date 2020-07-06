$(document).ready(function () {
    if (window.jQuery) {
        let jQversion = $.fn.jquery;
        console.log("enabled jQuery version " + jQversion);
    } else {
        console.log("jQuery not found!");
    }
    function checkLogin(){
        let login = ($("#r_form  input[name = login]").val());
        let input = ($("#r_form  input[name = login]"));
        let data = input.serialize();
        $.ajax({
            url:     '/Controllers/registration.php', //url страницы (action_ajax_form.php)
            type:     "POST", //метод отправки
            dataType: "html", //формат данных
            data: data,  // Сеарилизуем объект
            success: function(response) { //Данные отправлены успешно
                let rezult = response;
                if(rezult == ""){
                    return true;
                }
                if(rezult == "Даний логін вже існує"){
                    $('#rezult').html('<span class="red-alert">'+rezult+'</span>');
                    return false;
                }
            },
            error: function(response) { // Данные не отправлены
                $('#result_form').html('Помилка під час передачі данних.');
                let rezult = response;
            }
        });
    }
    $('#s_btn').click(function () {
        event.preventDefault();
        $('#rezult').html('');
        if($('#p1').val() === $('#p2').val()){
            //checkLogin();
            sendRegForm('r_form');
        }else{
            $('#rezult').html('<span class="red-alert">Паролі не співпадають</span>');
        }
    });
    $('#s_auth').click(function () {
        event.preventDefault();
        $('#a_rezult').html('');
        sendAuthForm('a_form');
    });
    function sendRegForm(id_form) {
        $.ajax({
            url:    '/Controllers/registration.php', //url страницы (action_ajax_form.php)
            type:     "POST", //метод отправки
            dataType: "html", //формат данных
            data: $("#"+id_form).serializeArray(),  // Сеарилизуем объект
            success: function(response) { //Данные отправлены успешно
                let rezult = response;
                if(rezult == "ok"){
                    let text = "Реєстрація пройдена успішно, Ви будете перенаправлені на сторінку входу автоматично, через декілька секунд.";
                    $('#rezult').html('<span class="info-alert">'+text+'</span>');
                    function redirect(){
                        window.location.replace("/login");
                    }
                    setTimeout(redirect, 5000);
                }else{
                    console.log(response);
                    $('#rezult').html('<span class="red-alert">'+rezult+'</span>');
                }
            },
            error: function(response) { // Данные не отправлены
                let rezult = response;
                $('#rezult').html('<span class="red-alert">'+rezult+'</span>');
            }
        });
    }
    function sendAuthForm(id_form) {
        $.ajax({
            url:    '/Controllers/login.php', //url страницы (action_ajax_form.php)
            type:     "POST", //метод отправки
            dataType: "html", //формат данных
            data: $("#"+id_form).serializeArray(),  // Сеарилизуем объект
            success: function(response) { //Данные отправлены успешно
                function redirect(){
                    window.location.replace("/dashboard");
                }
                if(response == 1){
                    redirect();
                }else{
                    alert(response);
                }

            },
            error: function(response) { // Данные не отправлены
               console.log("don't send");
            }
        });
    }
    $('#new_task').click(function () {
        $.ajax({
            url:    '/Controllers/dashboard.php', //url страницы (action_ajax_form.php)
            type:     "POST", //метод отправки
            dataType: "html", //формат данных
            data: $("#"+id_form).serializeArray(),  // Сеарилизуем объект
            success: function(response) { //Данные отправлены успешно
                function redirect(){
                    window.location.replace("/dashboard");
                }
                if(response == 1){
                    redirect();
                }else{
                    alert(response);
                }

            },
            error: function(response) { // Данные не отправлены
                console.log("don't send");
            }
        });
    });
    $('.tabs-rows__item').click(function () {
        let a = $(this).parent().parent('.tabs__block').attr('id');
        let parentIdText = '#'+a;
        let parentEl = $(parentIdText);
        let id = $(this).attr('id');
        let thisEL = $(this);
        let defaultBorderColor = thisEL.css('border-color');
        let defaultTextColor = thisEL.children('span').css('color');
        thisEL.css({'border-color':'green'});
        thisEL.children('span').css({'color':'green'});
        let TabsContainer = parentEl.children('.tabs__tabs-rows');
        let tabs = TabsContainer.children('.tabs-rows__item');
        let NotThisTab = tabs.not(this);
        NotThisTab.css({'border-color': defaultBorderColor});
        NotThisTab.children('span').css({'color': defaultTextColor});
        let contents = parentEl.find('.tabs__section-container');
        let thisContent = contents.children('[data-id='+id+']');
        contents.children().not(thisContent).hide('500');
        thisContent.show('500');
    });
    setInterval(getCurrentDate, 82800000);
    function getCurrentDate() {
        let date = {'date': true}
        let ret = "";
        $.ajax({
            url:    '/Controllers/dashboard.php', //url страницы (action_ajax_form.php)
            type:     "POST", //метод отправки
            dataType: "html", //формат данных
            data: date,  // Сеарилизуем объект
            success: function(response) { //Данные отправлены успешно
                ret = response;
            },
            error: function(response) { // Данные не отправлены
                console.log("don't send");
            }
        });
        return ret;
    }
    getCurrentDate();
    $('input[name = "date-start"]').attr('min', getCurrentDate());
    function addTask(){

    }
    var files = [];
    $('input[type=file]').change(function(){
        files = (this.files);
    });
    $('#task_submit').click(function () {
        event.preventDefault();
        var data = [];
        // data[0] = $('#newTaskForm').serializeArray();
        var form = document.forms.newTaskForm;
            console.log(form);
        data = new FormData(form);
        $.each( files, function( key, value ){
            data.append( key, value );
        });
        console.log(data);
        if(($('.task-num-departament').val() === "") & ($('.task-num-askod').val() === "") & ($('.task-num-moz').val() === "")){
            alert("Помилка, потрібно вказати хоча б один номер листа");
        }else {

            var form = document.forms.newTaskForm;
            var formData = new FormData(form);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/Controllers/dashboard.php");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if(xhr.status == 200) {
                        data = xhr.responseText;
                        console.log(data);
                        if(data == "true") {
                            // $(".sending").replaceWith("<p>Принято!<p>");
                            alert("ok");
                        } else {
                            // $(".sending").replaceWith("<p >Ошибка! Обновите страницу...<p>");
                            alert("ne ok");
                        }
                    }
                }
            };
            xhr.send(formData);

        }
    });
    $('.text__row').click(function () {
        let filterBlock = $(this).siblings('.label__block-filter');
        if(filterBlock.is(":visible") === true){
            $(this).children('.row__arrow').css({'transform':'rotate(360deg)'});
            filterBlock.hide(300);

        }
        if(filterBlock.is(":hidden") === true){
            $(this).children('.row__arrow').css({'transform':'rotate(180deg)'});
            filterBlock.show(300);

        }
    });
    $('#start-date-asc').click(function() {
        let html = $('.table__row').sort(function (a, b) {
            let sortA = $(a).data('date-start');
            return (sortA < sortB) ? -1 : (sortA > sortB) ? 1 : 0;
        });
        $('.tasks-list').html(html);
    });
    $('#start-date-desc').click(function() {
        let html = $('.table__row').sort(function (a, b) {
            let sortA = $(a).data('date-start');
            let sortB = $(b).data('date-start');
            return (sortA < sortB) ? 1 : (sortA > sortB) ? -1 : 0;
        });
        $('.tasks-list').html(html);
    });
    $('#end-date-desc').click(function() {

        let html = $('.table__row').sort(function (a, b) {
            let sortA = $(a).data('date-end');
            let sortB = $(b).data('date-end');
            return (sortA < sortB) ? 1 : (sortA > sortB) ? -1 : 0;
        });
        $('.tasks-list').html(html);
    });
    $('#end-date-asc').click(function() {
        let html = $('.table__row').sort(function (a, b) {
            let sortA = $(a).data('date-end');
            let sortB = $(b).data('date-end');
            return (sortA < sortB) ? -1 : (sortA > sortB) ? 1 : 0;
        });
        $('.tasks-list').html(html);
    });
    $('#subDateStart').click(function () {
        // event.stopPropagation();
        event.preventDefault();
        $.ajax({
            url: '/Controllers/dashboard.php', //url страницы (action_ajax_form.php)
            type: "POST", //метод отправки
            dataType: "html", //формат данных
            data: $('#sDateEnd').serializeArray(),  // Сеарилизуем объект
            // data: data,
            success: function (response) { //Данные отправлены успешно
                // console.log($.parseJSON(response));
                if (response === "error") {
                   alert("Вкажіть хоча б одну дату.");
                } else {
                    $('.tasks-list').empty();
                    $('.tasks-list').append(response);
                }
            },
            error: function (response) { // Данные не отправлены
                console.log("don't send");
            }
        });

    });
    var managerContent = $('.tasks-list').html();
    $('#clearDateStart').click(function () {

        $('.tasks-list').empty();
        $('.tasks-list').append(managerContent);
    });
});