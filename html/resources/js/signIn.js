function signIn(login,password) {

    // Авторизируемся
    $.ajax({
        type: "POST",
        url: "/user/signin",
        data: {userlogin: login, userpass:password}
    }).done(function (result) {

        if (result) {
            var obj = JSON.parse(result);
            if(obj['login']) {
                document.getElementById("authform").style.display="none";
                document.getElementById("outform").style.display="block";
                location.reload();
            } else {
                var inputs =document.getElementsByClassName("authform");
                for(var i=0; i<inputs.length; i++) inputs[i].style.border="solid 1px #FF0000";
            }
        }
    });
};

function signOut() {

    // Разлогиниваемся
    $.ajax({
        type: "GET",
        url: "/user/signout",
    }).done(function (result) {

        if (result) {
            var obj = JSON.parse(result);
            document.getElementById("authform").style.display="block";
            document.getElementById("outform").style.display="none";
        }
    });
};
