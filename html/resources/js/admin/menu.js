/** dmi - delete menu item */
function dmi(mId) {
//mId - menus item id
    //console.log(mId);
    var deleteConfirm = confirm("Данный пункт меню, и все его подчиненные будут удалены:\n"+mId+". Согласны?");
   //console.log(deleteConfirm);
   if (deleteConfirm) {
       $.ajax({
           type: "POST",
           url: "/admin/menu/delMenuItems",
           data: {mId: mId} //Удаляем пункт меню с подпунктами из базы:)
       }).done(function (result) {
        console.log(result);
        if (result) {
            document.location.reload(false);
            document.getElementById('message_added').className = 'message-ok';
            document.getElementById('message_added').innerText = 'Удалено '+result+'пунктов (подпунктов) id:'+mId;
        }
       })
   }
};

function ami(subId) {
    var m=document.getElementsByName('new_menu_item'+subId)[0].value;
    var l=document.getElementsByName('new_link'+subId)[0].value;

    console.log(subId);
    console.log(m);
    console.log(l);

    $.ajax({
        type: "POST",
        url: "/admin/menu/addMenuItem",
        data: {sub_item: subId, menu_item: m, link: l} //добавляем в базу пункт меню с sub_item=subId, menu_item=m, link=l
    }).done(function (result) {
        console.log(result);
            document.location.reload(false);
    })
};

function nsm(mId) {
    document.getElementById("save"+mId).style.display="inline";
};

function umi(mId) {
    var m=document.getElementsByName('menu_item'+mId)[0].value;
    var l=document.getElementsByName('link'+mId)[0].value;

    console.log(mId);
    console.log(m);
    console.log(l);

    $.ajax({
        type: "POST",
        url: "/admin/menu/updateMenuItem",
        data: {mId: mId, menu_item: m, link: l} //добавляем в базу пункт меню с sub_item=subId, menu_item=m, link=l
    }).done(function (result) {
        console.log(result);
        document.location.reload(false);
    })
};

