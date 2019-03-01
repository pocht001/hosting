$(function () {
    var t;
    var t2;
    var t3;
$('.sidebar').mouseenter(function(){
    var a=this;
        t=document.getElementById('t'+a.id);
        t2=Number(t.innerText);
        t3=t.style;
        t.innerText=Number(t.innerText)*0.9;
        t.style="color: black; font-size: 20px;";
    }
    )
    $('.sidebar').mouseleave(function(){
        t.innerText=t2;
        t.style=t3;
        }
    )
})

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
