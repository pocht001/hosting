/** Устанавливаем фоны */
function defBg() { //картинка фона сайта
    $.ajax({
        type: "POST",
        url: "/admin/defbg",
        data: {rbId: 555,status: 777} //data тут нафиг не нада, это просто шоб було :)
    }).done(function (result) {
        console.log(result);
        if (result.length>1) document.getElementById('rb_added').innerHTML = '<p class="message-error">'+
            result+'</p>';
    else document.getElementById('rb_added').innerHTML = '<p class="message-ok">Сбросили фоновую картинку на дефолт: '+
            result+'</p>';
        //document.location.reload(false);
    });
};

function hBg(hcolor) { // цвет фона шапки
    console.log(hcolor);
    $.ajax({
        type: "POST",
        url: "/admin/hbg",
        data: {hcolor: hcolor} //data тут нафиг не нада, это просто шоб було :)
    }).done(function (result) {
        console.log(result);
        if (result.length>1) document.getElementById('rb_added').innerHTML = '<p class="message-error">'+
            result+'</p>';
        else document.getElementById('rb_added').innerHTML = '<p class="message-ok">Установлен цвет фона хедера: '+
            hcolor+'</p>';
        //document.location.reload(false);
    });
};
