/* Создание нового товара */
$(document).ready(function(){
    $(".crud-submit").click(function(e) {
        e.preventDefault();
        var name2 = $("#create-item").find("input[name='name']").val();
        var price2 = $("#create-item").find("textarea[name='price']").val();
        var rating2 = $("#create-item").find("textarea[name='rating']").val();
        $.ajax({
            url:"add.php",
            cache: false,
            method:"POST",
            data:{name2:name2, price2:price2, rating2:rating2},
            success:function(data) {
                $('#employee_table').html(data);
                $(".modal .close").click()
                toastr.success('Товар добавлен успешно.', 'Уведомление', {timeOut: 5000});
            }
        });
    });
});



/* Удаление товара */
$("body").on("click",".remove-item",function(){
    var id = $(this).parent("td").data('id');
    console.log (id);
    $.ajax({
        url: 'delete.php',
        method:'POST',
        data:{id:id}
    }).done(function(data){
        $('#employee_table').html(data);
        toastr.success('Товар успешно удален.', 'Уведомление', {timeOut: 5000});
    });


});


/* Сортировка товара */
$(document).ready(function(){
    $(document).on('click', '.column_sort', function(){
        var column_name = $(this).attr("id");
        var order = $(this).data("order");
        var column_name2 = $(this).attr("id");
        var arrow = '';
        if(order == 'desc')
        {
            arrow = '&nbsp;<i class="material-icons">arrow_downward</i>';
        }
        else
        {
            arrow = '&nbsp;<i class="material-icons">arrow_upward</i>';
        }
        $.ajax({
            url:"sort.php",
            method:"POST",
            cache: false,
            data:{column_name:column_name, order:order, column_name2:column_name2},
            success:function(data) {
                $('#employee_table').html(data);
                $('#'+column_name+'').append(arrow);
                //window.location.hash='index.php?sort=' + column_name + '&order=' + order;

                window.history.pushState({foo: 'bar'}, "page 2", "index.php?sort=" + column_name + "&order=" + order);

            }
        })
    });
});

/* Берем данные для редактирования товара */
$("body").on("click",".edit-item",function(){


    var id = $(this).parent("td").data('id');
    var name = $(this).parent("td").prev("td").prev("td").prev("td").text();
    var price = $(this).parent("td").prev("td").prev("td").text();
    var rating = $(this).parent("td").prev("td").text();


    $("#edit-item").find("input[name='name']").val(name);
    $("#edit-item").find("textarea[name='price']").val(price);
    $("#edit-item").find("textarea[name='rating']").val(rating);
    $("#edit-item").find(".edit-id").val(id);

});
/* Обновление товара */
$("body").on("click",".crud-submit-edit",function(e){
    e.preventDefault();
    $('#loadingmessage').show();
    var name3 = $("#edit-item").find("input[name='name']").val();
    var price3 = $("#edit-item").find("textarea[name='price']").val();
    var rating3 = $("#edit-item").find("textarea[name='rating']").val();
    var id3 = $("#edit-item").find(".edit-id").val();

    console.log (id);
    $.ajax({
        url: 'update.php',
        method:'POST',
        data:{id3:id3, name3:name3, price3:price3, rating3:rating3}
    }).done(function(data){
        $('#loadingmessage').hide();
        $('#employee_table').html(data);
        $(".modal .close").click()
        toastr.success('Товар успешно обновлен.', 'Уведомление', {timeOut: 5000});
    });
});

$(document).ajaxStart(function(){
    toastr.success('Начало выполнение запроса.', 'Уведомление', {timeOut: 5000});
});

$(document).ajaxStop (function(){
    toastr.success('Конец выполнения запроса.', 'Уведомление', {timeOut: 5000});
});

$(document).ajaxError(function(){
    toastr.success('An error occurred:' + status + 'nError: ' + error, {timeOut: 5000});
});

