function searchTag(f) {
    var inputData =f.value;
//console.log(inputData);

    $.ajax({
        type: "POST",
        url: "/tag/showtags",
        data: {inputData: inputData}
    }).done(function (result) {
        var tagLink;
        var obj = JSON.parse(result);
        if(obj[0]) {
            var ft='';
            for (var i=0;i<obj.length;i++) {
                tagLink = '<a href = "/tag/?tag=' +obj[i]+ '">' +obj[i]+ '</a>';
                ft=ft+'<li>'+tagLink+'</li>';
                //ft=ft+'<li>'+obj[i]+'</li>';
            }
            $('#si1').html(ft);

            document.getElementById("si1").style.display="block";

        }
        else document.getElementById("si1").style.display="none";
    });

}