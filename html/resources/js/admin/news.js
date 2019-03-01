function edittext() {
    document.getElementById('newText1').style.display="inline";
    document.getElementById('newText2').style.display='none';
};
function edittheme() {
    document.getElementById('newTheme1').style.display="inline";
    document.getElementById('newTheme2').style.display='none';
};
function dellimg(image) {
    $.ajax({
        type: "POST",
        url: "/admin/delete",
        data: { fileName: '/resources/images/news/'+image}
    }).done(function (result) {
        document.getElementById('newsImg'+image).style.display='none';
        document.getElementById('imgDel'+image).style.display='inline';
        document.getElementById('imgDel'+image).innerText=result;
    });
};

 function zf(newsId,fname) {
    var file_data = $('#sortpicture').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    form_data.append('fname', fname);
    $.ajax({
        url: '/admin/addFile/'+newsId,
    dataType: 'text',
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    type: 'post',
}).done(function(result){
    location.reload(false);
if (result=='<strong>Файл успешно загружен!</strong>')
    document.getElementById('message').innerHTML='<p id="message" class="message-ok">Файл загружен успешно. </p>';
else document.getElementById('message').innerHTML='<p id="message" class="message-error">Файл загрузить не удалось.</p>';
});
};

 function nst(tagNumber) {
     document.getElementById('savetag'+tagNumber).style.display='inline';
     document.getElementById('saved'+tagNumber).style.display='none';
 };

 function delltag(tagNumber) {
     document.getElementById('tag_'+tagNumber).value='';
     document.getElementById('savetag'+tagNumber).style.display='inline';
     document.getElementById('saved'+tagNumber).style.display='none';
 };

 function saveEditedTags(newsId) {
var tags=[];
var tagsinput=document.getElementsByClassName('inptag');
var l=tagsinput.length;
//console.log(l);
for (var i=0; i<l; i++) {
    tags[i] = tagsinput[i].value;
}
console.log(tags);
     $.ajax({
         type: "POST",
         url: "/tag/edit/"+newsId,
         data: { tags: tags}
     }).done(function (result) {
        location.reload(true);
     });
 };

