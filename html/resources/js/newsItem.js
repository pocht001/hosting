function randomInteger(min, max) {
    var rand = min - 0.5 + Math.random() * (max - min + 1)
    rand = Math.round(rand);
    return rand;
};

var timerId = setInterval(function(){
var ri = randomInteger(0,5);
document.getElementById('readNow').innerHTML =
    'Эту новость сейчас читают: <b>' + ri + '</b> посетителей.';

    //console.log(newsId);
    $.ajax({
        type: "POST",
        url: "/new/howreadadd",
        data: {id: newsId, readersAdd:ri}
    }).done(function (result) {

        $('#readAll').html('Её уже прочитали: <b>' + result + '</b>.');
    });
}, 3000);

function like(commentId,likeid,anscom) {
    $.ajax({
        type: "POST",
        url: "/comment/likeadd/"+commentId,
    }).done(function (result) {
        if (result) {
            var obj = JSON.parse(result);
            if (obj['likes']) {
                var comlikes;
                if (anscom) comlikes =document.getElementsByClassName("la");
                else comlikes =document.getElementsByClassName("l");
                comlikes[likeid].innerHTML=obj['likes'];
            }}
    });
};

function dislike(commentId,dislikeid,anscom) {
    $.ajax({
        type: "POST",
        url: "/comment/dislikeadd/"+commentId,
    }).done(function (result) {
        if (result) {
            var obj = JSON.parse(result);
            if (obj['dislikes']) {
                var comlikes;
                if (anscom) comlikes =document.getElementsByClassName("dla");
                else comlikes =document.getElementsByClassName("dl");
                comlikes[dislikeid].innerHTML=obj['dislikes'];
            }}
    });
};
var ct;
$(document).keyup(function(event) {
    if ($("#comText").is(":focus") && event.key === "Enter") {
        ct = $('#comText').val().replace(/\n/g, "<br>")
        //console.log(ct);
    }
    else if ($("#comText").is(":focus")){
        ct = $('#comText').val().replace(/\n/g, "<br>")
        //console.log(ct,'no enter');
    }
});

function addcomment(newsId,userid,commentText) {
    $.ajax({
        type: "POST",
        url: "/comment/add/"+newsId,
        data: {userid: userid, commentText: commentText}
    }).done(function (result) {
        if (result) {
            var obj = JSON.parse(result);
            if (obj['result']=='true') {
               console.log(commentText);

                document.getElementById('addedComment').innerHTML =
                    '<div class="comment"><span class="commentatribute"> Вы, Менее минуты назад'+
                    '</span></br><div class = "commenttext">'+ct+'</div></br>'+
                    '<input TYPE="button" name="editcomment" id="editcomment" value="Редактировать" onClick="ec('+
                    obj['comment_id']+',\''+ct+'\')">'+
                    '<span class="commentatribute"> Доступно только первую минуту.</span></div>';

                setTimeout(function(){
                    document.location.reload(false);
                },60000);
            }}
    });
};

function ec(comment_id, commentText) {
    document.getElementById('addedComment').innerHTML =
    '<div id="addedComment"><br><textarea id="comText"></textarea><br>'+
    '</div></br><input TYPE="button" value="Подтвердить редактирование" onClick="editcomment('+comment_id+')">';
    var ct2 = commentText.replace(/<br ?\/?>/g, "\n");
    document.getElementById("comText").focus();
    document.getElementById("comText").value = ct2;
};

function editcomment(cid) {
    var ct3 = document.getElementById("comText").value;
    if(ct3.length==0) {
        //console.log(cid+": null");
        $.ajax({ //вызвать удаление комментария если поле ввода очистил.
            type: "POST",
            url: "/comment/delete/"+cid,
            data: {commentText: ct3}
        }).done(function (result) { });
    }
    else {
        //console.log(ct3); //вызвать update
        $.ajax({
            type: "POST",
            url: "/comment/update/"+cid,
            data: {commentText: ct3}
        }).done(function (result) {
            var d = new Date();

            var date_format_str = d.getFullYear().toString()+
                "-"+((d.getMonth()+1).toString().length==2?(d.getMonth()+1).toString():"0"+(d.getMonth()+1).toString())+
                "-"+(d.getDate().toString().length==2?d.getDate().toString():"0"+d.getDate().toString())+
                " "+(d.getHours().toString().length==2?d.getHours().toString():"0"+d.getHours().toString())+
                ":"+((parseInt(d.getMinutes()/5)*5).toString().length==2?d.getMinutes().toString():"0"+d.getMinutes().toString())+":00";

                document.getElementById('addedComment').innerHTML =
                    '<div class="comment"><span class="commentatribute"> Вы, '+date_format_str+
                    '</span></br><div class = "commenttext">'+ct+'</div></div>';
        });
    }
};

function show_ans_textarea(cn) { //cn - comment number
    document.getElementsByClassName("show_ans_textarea")[cn].style.display="none";
    document.getElementsByClassName("ansText")[cn].style.display="inline";
    document.getElementsByClassName("addanswer")[cn].style.display="inline";
    document.getElementsByClassName("ansText")[cn].focus();
};

function addanswer(commId,userId,num,newsId) {
var answerText = document.getElementsByClassName("ansText")[num].value;
    $.ajax({
        type: "POST",
        url: "/comment/add/"+newsId,
        data: {userid: userId, commentText: answerText, answer_on:commId}
    }).done(function (result) {
        if (result) {
            var obj = JSON.parse(result);
            if (obj['result']=='true') {
        if (document.getElementsByClassName('comment')[0]) {
            document.location.reload(false);
        }}
        }

    });
}