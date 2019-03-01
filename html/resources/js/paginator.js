function pagView() {
    document.getElementById("pv1").style.display="none";
    //var pagesLinks =document.getElementsByClassName("c");

    for( let a=0; a<document.getElementsByClassName("c").length; a++) {
        var l=document.getElementsByClassName("c").length;
        var del = Math.abs(2500 / l);
        setTimeout(function(){
            console.log(a)
            console.log(document.getElementsByClassName("c")[a]);
            document.getElementsByClassName("c")[a].style = "display:inline";
        },a*100)

    }
    //document.getElementsByClassName("c")[0].style = "display:inline";
}

