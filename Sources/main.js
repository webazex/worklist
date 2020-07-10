$(document).ready(function () {
    if (window.jQuery) {
        let jQversion = $.fn.jquery;
        console.log("enabled jQuery version " + jQversion);
    } else {
        console.log("jQuery not found!");
    }

    function checkLogin() {
        let login = ($("#r_form  input[name = login]").val());
        let input = ($("#r_form  input[name = login]"));
        let data = input.serialize();
        $.ajax({
            url: '/Controllers/registration.php', //url страницы (action_ajax_form.php)
            type: "POST", //метод отправки
            dataType: "html", //формат данных
            data: data,  // Сеарилизуем объект
            success: function (response) { //Данные отправлены успешно
                let rezult = response;
                if (rezult == "") {
                    return true;
                }
                if (rezult == "Даний логін вже існує") {
                    $('#rezult').html('<span class="red-alert">' + rezult + '</span>');
                    return false;
                }
            },
            error: function (response) { // Данные не отправлены
                $('#result_form').html('Помилка під час передачі данних.');
                let rezult = response;
            }
        });
    }

    $('#s_btn').click(function () {
        event.preventDefault();
        $('#rezult').html('');
        if ($('#p1').val() === $('#p2').val()) {
            //checkLogin();
            sendRegForm('r_form');
        } else {
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
            url: '/Controllers/registration.php', //url страницы (action_ajax_form.php)
            type: "POST", //метод отправки
            dataType: "html", //формат данных
            data: $("#" + id_form).serializeArray(),  // Сеарилизуем объект
            success: function (response) { //Данные отправлены успешно
                let rezult = response;
                if (rezult == "ok") {
                    let text = "Реєстрація пройдена успішно, Ви будете перенаправлені на сторінку входу автоматично, через декілька секунд.";
                    $('#rezult').html('<span class="info-alert">' + text + '</span>');

                    function redirect() {
                        window.location.replace("/login");
                    }

                    setTimeout(redirect, 5000);
                } else {
                    console.log(response);
                    $('#rezult').html('<span class="red-alert">' + rezult + '</span>');
                }
            },
            error: function (response) { // Данные не отправлены
                let rezult = response;
                $('#rezult').html('<span class="red-alert">' + rezult + '</span>');
            }
        });
    }

    function sendAuthForm(id_form) {
        $.ajax({
            url: '/Controllers/login.php', //url страницы (action_ajax_form.php)
            type: "POST", //метод отправки
            dataType: "html", //формат данных
            data: $("#" + id_form).serializeArray(),  // Сеарилизуем объект
            success: function (response) { //Данные отправлены успешно
                function redirect() {
                    window.location.replace("/dashboard");
                }

                if (response == 1) {
                    redirect();
                } else {
                    alert(response);
                }

            },
            error: function (response) { // Данные не отправлены
                console.log("don't send");
            }
        });
    }

    $('#new_task').click(function () {
        $.ajax({
            url: '/Controllers/dashboard.php', //url страницы (action_ajax_form.php)
            type: "POST", //метод отправки
            dataType: "html", //формат данных
            data: $("#" + id_form).serializeArray(),  // Сеарилизуем объект
            success: function (response) { //Данные отправлены успешно
                function redirect() {
                    window.location.replace("/dashboard");
                }

                if (response == 1) {
                    redirect();
                } else {
                    alert(response);
                }

            },
            error: function (response) { // Данные не отправлены
                console.log("don't send");
            }
        });
    });
    $('.tabs-rows__item').click(function () {
        let a = $(this).parent().parent('.tabs__block').attr('id');
        let parentIdText = '#' + a;
        let parentEl = $(parentIdText);
        let id = $(this).attr('id');
        let thisEL = $(this);
        let defaultBorderColor = thisEL.css('border-color');
        let defaultTextColor = thisEL.children('span').css('color');
        thisEL.css({'border-color': '#77a89c'});
        thisEL.children('span').css({'color': '#77a89c'});
        let TabsContainer = parentEl.children('.tabs__tabs-rows');
        let tabs = TabsContainer.children('.tabs-rows__item');
        let NotThisTab = tabs.not(this);
        NotThisTab.css({'border-color': defaultBorderColor});
        NotThisTab.children('span').css({'color': defaultTextColor});
        let contents = parentEl.find('.tabs__section-container');
        let thisContent = contents.children('[data-id=' + id + ']');
        contents.children().not(thisContent).hide('500');
        thisContent.show('500');
    });
    setInterval(getCurrentDate, 82800000);

    function getCurrentDate() {
        let date = {'date': true}
        let ret = "";
        $.ajax({
            url: '/Controllers/dashboard.php', //url страницы (action_ajax_form.php)
            type: "POST", //метод отправки
            dataType: "html", //формат данных
            data: date,  // Сеарилизуем объект
            success: function (response) { //Данные отправлены успешно
                ret = response;
            },
            error: function (response) { // Данные не отправлены
                console.log("don't send");
            }
        });
        return ret;
    }

    getCurrentDate();
    $('input[name = "date-start"]').attr('min', getCurrentDate());

    function addTask() {

    }

    var files = [];
    $('input[type=file]').change(function () {
        files = (this.files);
    });
    $('#task_submit').click(function () {
        event.preventDefault();
        var data = [];
        // data[0] = $('#newTaskForm').serializeArray();
        var form = document.forms.newTaskForm;
        console.log(form);
        data = new FormData(form);
        $.each(files, function (key, value) {
            data.append(key, value);
        });
        if (($('.task-num-departament').val() === "") & ($('.task-num-askod').val() === "") & ($('.task-num-moz').val() === "")) {
            alert("Помилка, потрібно вказати хоча б один номер листа");
        } else {
            let val1 = true;
        }
        if ((($('#newTaskForm input[name = date-start]')), ($('#newTaskForm input[name = date-end]'))).val() == "") {
            var val1 = false;
        } else {
            var val1 = true;
        }
        if ((val1) == true) {
            var form = document.forms.newTaskForm;
            var formData = new FormData(form);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/Controllers/dashboard.php");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        data = xhr.responseText;
                        if (data == "ok") {
                            $('#callback').html('<p class="info-alert"><span>Задачу успішно поставлено</span></p>');
                        } else if (data == "false") {
                            $('#callback').html('<p class="red-alert"><span>Задачу не створено.</span></p>');
                        } else if (data == "zero") {
                            $('#callback').html('<p class="red-alert"><span>Відсутні вхідні данні. Працюємо над виправленням.</span></p>');
                        }
                    }
                }
            };
            xhr.send(formData);
        } else {
            $('#callback').html('<p class="red-alert"><span>Вкажіть дати постановки задачі та кінцевий термін!</span></p>');
        }

        function clearCallback() {
            $('#callback').html('')
        }

        setInterval(clearCallback, 5000);
    });
    $('.text__row').click(function () {
        let filterBlock = $(this).siblings('.label__block-filter');
        if (filterBlock.is(":visible") === true) {
            $(this).children('.row__arrow').css({'transform': 'rotate(360deg)'});
            filterBlock.hide(300);

        }
        if (filterBlock.is(":hidden") === true) {
            $(this).children('.row__arrow').css({'transform': 'rotate(180deg)'});
            filterBlock.show(300);

        }
    });
    $('#start-date-asc').click(function () {
        let html = $('.table__row').sort(function (a, b) {
            let sortA = $(a).data('date-start');
            let sortB = $(b).data('date-start');
            return (sortA < sortB) ? -1 : (sortA > sortB) ? 1 : 0;
        });
        $('.tasks-list').html(html);
    });
    $('#start-date-desc').click(function () {
        let html = $('.table__row').sort(function (a, b) {
            let sortA = $(a).data('date-start');
            let sortB = $(b).data('date-start');
            return (sortA < sortB) ? 1 : (sortA > sortB) ? -1 : 0;
        });
        $('.tasks-list').html(html);
    });
    $('#end-date-desc').click(function () {

        let html = $('.table__row').sort(function (a, b) {
            let sortA = $(a).data('date-end');
            let sortB = $(b).data('date-end');
            return (sortA < sortB) ? 1 : (sortA > sortB) ? -1 : 0;
        });
        $('.tasks-list').html(html);
    });
    $('#end-date-asc').click(function () {
        let html = $('.table__row').sort(function (a, b) {
            let sortA = $(a).data('date-end');
            let sortB = $(b).data('date-end');
            return (sortA < sortB) ? -1 : (sortA > sortB) ? 1 : 0;
        });
        $('.tasks-list').html(html);
    });

    // =====ajax search for date-start
    $('#subDateStart').click(function () {
        // event.stopPropagation();
        event.preventDefault();
        if (($('#sDateStart input[name = search-start-date]').val() == "") & ($('#sDateStart input[name = search-end-date]').val() == "")) {
            alert("Вкажіть хоча б одну з дат");
        } else {
            $.ajax({
                url: '/Controllers/dashboard.php', //url страницы (action_ajax_form.php)
                type: "POST", //метод отправки
                dataType: "html", //формат данных
                data: $('#sDateStart').serializeArray(),  // Сеарилизуем объект
                // data: data,
                success: function (response) { //Данные отправлены успешно
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
        }
    });
    var managerContent = $('.tasks-list').html();
    $('#clearDateStart').click(function () {
        $('#sDateStart')[0].reset();
        $('.tasks-list').empty();
        $('.tasks-list').append(managerContent);
    });
    // ==ajax request for theme search
    $('#subTheme').click(function () {
        event.preventDefault();
        if ($('#sTheme input[name = search-theme]').val() == "") {
            alert("Не заповнено поле пошуку теми.");
        } else {
            $.ajax({
                url: '/Controllers/dashboard.php', //url страницы (action_ajax_form.php)
                type: "POST", //метод отправки
                dataType: "html", //формат данных
                data: $('#sTheme').serializeArray(),  // Сеарилизуем объект
                success: function (response) { //Данные отправлены успешно
                    if (response === "error") {
                        alert("Не заповнено поле пошуку теми.");
                    } else {
                        $('.tasks-list').empty();
                        $('.tasks-list').append(response);
                    }
                },
                error: function (response) { // Данные не отправлены
                    console.log("don't send");
                }
            });
        }
    });
    $('#resTheme').click(function () {
        $('#sTheme')[0].reset();
        $('.tasks-list').empty();
        $('.tasks-list').append(managerContent);
    });
    // ===ajax request for numbers search
    $('#subNumbers').click(function () {
        event.preventDefault();
        if (($('#sNumbers input[name = search-moz]').val() == "") & ($('#sNumbers input[name = search-ascod]').val() == "") & ($('#sNumbers input[name = search-department]').val() == "")) {
            alert("Вкажіть хоча б один номер листа.");
        } else {
            $.ajax({
                url: '/Controllers/dashboard.php', //url страницы (action_ajax_form.php)
                type: "POST", //метод отправки
                dataType: "html", //формат данных
                data: $('#sNumbers').serializeArray(),  // Сеарилизуем объект
                success: function (response) { //Данные отправлены успешно
                    if (response === "error") {
                        alert("Вкажіть хоча б один номер листа.");
                    } else {
                        $('.tasks-list').empty();
                        $('.tasks-list').append(response);
                    }
                },
                error: function (response) { // Данные не отправлены
                    console.log("don't send");
                }
            });
        }
    });
    $('#resNumbers').click(function () {
        $('#sNumbers')[0].reset();
        $('.tasks-list').empty();
        $('.tasks-list').append(managerContent);
    });

    // ===ajax search performers
    $('#subPerfomance').click(function () {
        event.preventDefault();
        if(($('.search-performers').val() == "default")){
            alert("Оберіть виконавця.");
        } else {
            $.ajax({
                url: '/Controllers/dashboard.php', //url страницы (action_ajax_form.php)
                type: "POST", //метод отправки
                dataType: "html", //формат данных
                data: $('#sPerfomance').serializeArray(),  // Сеарилизуем объект
                success: function (response) { //Данные отправлены успешно
                    if (response === "error") {
                        alert("Оберіть виконавця.");
                    } else {
                        $('.tasks-list').empty();
                        $('.tasks-list').append(response);
                    }
                },
                error: function (response) { // Данные не отправлены
                    console.log("don't send");
                }
            });
        }
    });
    $('#resPerfomance').click(function () {
        $('#sPerfomance')[0].reset();
        $('.tasks-list').empty();
        $('.tasks-list').append(managerContent);
    });

    // =====ajax search department performers
    $('#subDepPerfomance').click(function () {
        event.preventDefault();
        if(($('#sDepartmentPerfomance input[name = search-department-perfomance]').val() == "")){
            alert("Вкажіть дані для пошуку.");
        } else {
            $.ajax({
                url: '/Controllers/dashboard.php', //url страницы (action_ajax_form.php)
                type: "POST", //метод отправки
                dataType: "html", //формат данных
                data: $('#sDepartmentPerfomance').serializeArray(),  // Сеарилизуем объект
                success: function (response) { //Данные отправлены успешно
                    if (response === "error") {
                        alert("Оберіть виконавця.");
                    } else {
                        $('.tasks-list').empty();
                        $('.tasks-list').append(response);
                    }
                },
                error: function (response) { // Данные не отправлены
                    console.log("don't send");
                }
            });
        }
    });
    $('#resDepPerfomance').click(function () {
        $('#sDepartmentPerfomance')[0].reset();
        $('.tasks-list').empty();
        $('.tasks-list').append(managerContent);
    });

    // =====ajax search for date-end
    $('#subDateEnd').click(function () {
        // event.stopPropagation();
        event.preventDefault();
        if (($('#sDateEnd input[name = search-start-date-e]').val() == "") & ($('#sDateEnd input[name = search-end-date-e]').val() == "")) {
            alert("Вкажіть хоча б одну з дат");
        } else {
            $.ajax({
                url: '/Controllers/dashboard.php', //url страницы (action_ajax_form.php)
                type: "POST", //метод отправки
                dataType: "html", //формат данных
                data: $('#sDateEnd').serializeArray(),  // Сеарилизуем объект
                // data: data,
                success: function (response) { //Данные отправлены успешно
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
        }
    });
    var managerContent = $('.tasks-list').html();
    $('#resDateEnd').click(function () {
        $('#sDateEnd')[0].reset();
        $('.tasks-list').empty();
        $('.tasks-list').append(managerContent);
    });
});
$('.tasks-list form').on( "click", "button#edit_task", function() {
    event.preventDefault();
    let id = 'tId-'+$(this).parent().parent().attr('data-id');
    $.ajax({
        url: '/Controllers/dashboard.php', //url страницы (action_ajax_form.php)
        type: "POST", //метод отправки
        dataType: "html", //формат данных
        data: $('#'+id).serializeArray(),  // Сеарилизуем объект
        // data: data,
        success: function (response) { //Данные отправлены успешно
            if(response == "true"){
                alert("Дані успішно оновлено");
            }else if(response == "false"){
                alert("Дані успішно оновлено");
            }
        },
        error: function (response) { // Данные не отправлены
            alert("Помилка відправки");
        }
    });
});
// ===ajax edit task

// hiding for scroll
$(window).scroll(function () {
    if ($(this).scrollTop() > 388) {
        $('#btn_up').css({'display': 'block'});
    } else {
        $('#btn_up').css({'display': 'none'});
    }
});
// ====scroll for click up
$('#btn_up').click(function() {
    $('html, body').animate({scrollTop: 0},500);
    return false;
});