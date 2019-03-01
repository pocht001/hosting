function adminAuth(login,pass) {

    // Авторизируемся
    $.ajax({
        type: "POST",
        url: "/admin/auth",
        data: {admin_login: login, admin_pass: pass}
    }).done(function (result) {

        if (result) {
            var obj = JSON.parse(result);
            if(obj['admin_login']) {
                document.getElementById("adminAuth").style.display="none";
                document.getElementById("adminLogout").style.display="block";
                location.reload();
            } else {
                var inputs =document.getElementsByClassName("authform");
                for(var i=0; i<inputs.length; i++) inputs[i].style.border="solid 1px #FF0000";
            }
        }
    });
};

function admLogOut() {

    // Разлогиниваемся
    $.ajax({
        type: "GET",
        url: "/admin/logout",
    }).done(function (result) {

        if (result) {
            var obj = JSON.parse(result);
            document.getElementById("adminAuth").style.display="block";
            document.getElementById("adminLogout").style.display="none";
        }
    });
};
