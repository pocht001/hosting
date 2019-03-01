$(document).ready(function() {
    setTimeout(function(){
        $('#popup1').show();
        $('.overlay').show();

    }, 15000);
});
$('.popup .close, .overlay, .popup .subscribe').click(function() {
    $('.overlay, .popup').hide();
});
