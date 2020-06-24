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
    $('#task_submit').click(function () {
        event.preventDefault();
        if(($('.task-num-departament').val() === "") & ($('.task-num-askod').val() === "") & ($('.task-num-moz').val() === "")){
            alert("Помилка, потрібно вказати хоча б один номер листа");
        }else {
            $.ajax({
                url: '/Controllers/dashboard.php', //url страницы (action_ajax_form.php)
                type: "POST", //метод отправки
                dataType: "html", //формат данных
                data: $('#newTaskForm').serializeArray(),  // Сеарилизуем объект
                success: function (response) { //Данные отправлены успешно
                    if (response === "ok") {
                        $('#callback').html('<span class="info-alert">Задачу поставлено успішно</span>');
                    } else if (response === "zero") {
                        $('#callback').html('<span class="red-alert">Не проставлені виконавці</span>');
                    } else {
                        $('#callback').html('<span class="red-alert">Виникла помилка під час постановки задачі. Задачу не поставлено.</span>');
                    }

                    function clearCallback() {
                        $('#callback').empty();
                    }

                    setTimeout(clearCallback, 3000);
                },
                error: function (response) { // Данные не отправлены
                    console.log("don't send");
                }
            });
        }
    });
});