function setStatusProduct(rbId, status) {
    $.ajax({
        type: "POST",
        url: "/admin/rb/status",
        data: {rbId: rbId,status: status}
    }).done(function (result) {
        console.log(result);
        document.location.reload(false);
    });
};