 function modcom(commentId) {
// Модерация комментария
    $.ajax({
        type: "POST",
        url: "/comment/moderation/"+commentId
    }).done(function (result) {

        if (result) {
            var obj = JSON.parse(result);
            if(obj['commentId']) {
                location.reload();
            } else {
                console.log('The comment was not moderate.');
            }
        }
    });
};

function cancelmod(commentId) {
// Возврат на модерацию комментария
    $.ajax({
        type: "POST",
        url: "/comment/moderationcancel/"+commentId
    }).done(function (result) {

        if (result) {
            var obj = JSON.parse(result);
            if(obj['commentId']) {
                document.location.reload(false);
            } else {
                console.log('The comment was not bac to moderation.');
            }
        }
    });
};

function editcomment() {
    var commentText = document.getElementById('comText').value;
    var cid = document.getElementById('cih').value;
    $.ajax({
        type: "POST",
        url: "/comment/update/"+cid,
        data: {commentText: commentText}
    }).done(function (result) {
        console.log('The comment was updated');
        cancelEdit();
        document.location.reload(false);
    });
}

function ec(commentId) { //отобразить попап с редактируемым комментарием
    $('#popup1').show();
    $('#overlay').show();
    document.getElementById('comText').value = document.getElementById('edcom'+commentId).innerText;
    document.getElementById("comText").focus();
    document.getElementById("cih").value=commentId;
};

function cancelEdit() { //прячем попап и оверлей
    $('#overlay, #popup1').hide();
};

function addc(newsId,comText) {
    var ct=comText.value; //Сначала вытягиваем id комментируемой новости из строки, выбранной в селекте
    newsId1 = newsId.value;
    //newsId1 = parseInt(newsId.value);
    if (newsId1 && ct) {

        $.ajax({
            type: "POST",
            url: "/comment/add/"+newsId1,
            data: {commentText: ct, userid:22}
        }).done(function (result) {

            var obj = JSON.parse(result);
            if(obj['result']=='true') {
                console.log('zbs');
                document.getElementById('message_added').innerHTML =
                    '<p>Комментарий добавлен успешно. id:'+obj["comment_id"]+'</p>'+
                    '<button id="again" onclick="again()">Добавить еще.</button>';
                document.getElementById('message_added').style.display="inline";
                document.getElementById('message_added').style.color = "#44B966";
                document.getElementById('addcomment').style.display="none";
            } else if(obj['result']=='false') {
                document.getElementById('message_added').innerHTML =
                    '<p>Error. Комментарий не был добавлен</p>'+
                    '<button id="again" onclick="again()">Попробовать еще раз.</button>';
                document.getElementById('message_added').style.display="inline";
                document.getElementById('message_added').style.color = "#D93636";
                document.getElementById('addcomment').style.display="none";
            }

        });
    } else { //Подсвечиваем красным незаполненные поля на 1.5с
        if (!newsId1) { //если не выбрана новость, подсветить рамкой выбор новостей
        document.getElementById('newsId').style.border = "2px solid red";
        setTimeout(function () {
            document.getElementById('newsId').style.border = "0px";
        }, 1500);}
        if (!ct) { //если не введен текст, подсветить textarea красной рамкой
            document.getElementById('comText').style.border = "2px solid red";
            setTimeout(function () {
                document.getElementById('comText').style.border = "0px";
            }, 1500);}
    }
};

function again() { //скрыть сообщение об успехе/ошибке, показать блок добавления комментария
    document.getElementById('message_added').style.display="none";
    document.getElementById('addcomment').style.display="inline";
}