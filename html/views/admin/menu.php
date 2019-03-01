<!--Раздел редактирования меню.-->
<script src="/resources/js/admin/menu.js"></script>
<?php
$message = '<p id="message_added"></p>';
$content = 'Админка. Раздел меню.';
$content .= '<form action="/admin/menu" method="POST" enctype="multipart/form-data"> <ul>';

for ($i=0;$i<count($menuArray);$i++) { /** Пункты меню */
    $content .= '<li>'.$menuArray[$i]['id'].' <input type="text" name="menu_item'.$menuArray[$i]['id'].'"  
    value="'.$menuArray[$i]['menu_item'].'" onkeydown="nsm('.$menuArray[$i]['id'].')" size="48" class="mi">';
    $content .= ' <input type="text" name="link'.$menuArray[$i]['id'].'" value="'.$menuArray[$i]['link'].'"
     onkeydown="nsm('.$menuArray[$i]['id'].')" size="48" class="mi">
 <span class="dellItem" onclick="dmi(\''.$menuArray[$i]['all_sub_items'].'\')">&nbsp;X</span>
 <span id="save'.$menuArray[$i]['id'].'" class="savemi" onclick="umi('.$menuArray[$i]['id'].')">SAVE</span></li>';
    // dmi - delete menu item

    $content .= '<ul>';
    if (isset($menuArray[$i]['si'])) {
        $subItem = $menuArray[$i]['si'];
        for ($j = 0; $j < count($subItem); $j++) { /** Подпункты меню */
            $content .= '<li> * '.$subItem[$j]['id'].' <input type="text" name="menu_item'.$subItem[$j]['id'].'" 
            value="'.$subItem[$j]['menu_item'].'" onkeydown="nsm('.$subItem[$j]['id'].')" size="48" class="msi">';
            $content .= ' <input type="text" name="link'.$subItem[$j]['id'].'" value="'.$subItem[$j]['link'].'"
             onkeydown="nsm('.$subItem[$j]['id'].')" size="48" class="msi">
 <span class="dellItem" onclick="dmi(\''.$subItem[$j]['all_sub_items'].'\')">&nbsp;X</span>
 <span id="save'.$subItem[$j]['id'].'" class="savemi" onclick="umi('.$subItem[$j]['id'].')">SAVE</span></li>';
            //<img src="/resources/images/admin/save2.jpg" id="save'.$subItem[$j]['id'].'" class="rednew" onclick="umi('.$subItem[$j]['id'].')">

            $content .= '<ul>';
            if (isset($subItem[$j]['ssi'])) { /** Под-под-пункты меню */
                $subSubItem = $subItem[$j]['ssi'];
                for ($k = 0; $k < count($subSubItem); $k++) {
                    $content .= '<li> ** '.$subSubItem[$k]['id'].' <input type="text" name="menu_item'.$subSubItem[$k]['id'].'"
            value="'.$subSubItem[$k]['menu_item'].'" onkeydown="nsm('.$subSubItem[$k]['id'].')" size="48" class="mssi">';
                    $content .= ' <input type="text" name="link'.$subSubItem[$k]['id'].'" 
                    value="'.$subSubItem[$k]['link'].'" onkeydown="nsm('.$subSubItem[$k]['id'].')" size="48" class="mssi">
                    <span class="dellItem" onclick="dmi(\''.$subSubItem[$k]['all_sub_items'].'\')">&nbsp;X</span>
 <span id="save'.$subSubItem[$k]['id'].'" class="savemi" onclick="umi('.$subSubItem[$k]['id'].')">SAVE</span></li>';
                }

            }
            /** Добавление новых под-подпунктов */
            $content .= '<li> (New**) <input type="text" name="new_menu_item'.$subItem[$j]['id'].'" placeholder="Новый под-подпункт" size="48" class="mssi">';
            $content .= ' <input type="text" name="new_link'.$subItem[$j]['id'].'" placeholder="/link" size="48" class="mssi">';
            $content .= '<span class="but" onclick="ami('.$subItem[$j]['id'].')"> + </span></li>'; //Добавить&nbsp;под-подпункт&nbsp;меню
            $content .= '</ul>';
        }

    }
    /** Добавление новых подпунктов */
    $content .= '<li> (New*) <input type="text" name="new_menu_item'.$menuArray[$i]['id'].'" placeholder="Новый подпункт" size="48" class="msi">';
    $content .= ' <input type="text" name="new_link'.$menuArray[$i]['id'].'" placeholder="/link" size="48" class="msi">';
    $content .= '<span class="but" onclick="ami('.$menuArray[$i]['id'].')"> + </span></li>'; //
    // ami - add menu item
    $content .= '</ul>';

}
/** Добавление нового пункта */
$content .= '<li>(New) <input type="text" name="new_menu_item0" placeholder="Новый пункт" size="48" class="mi">';
    $content .= ' <input type="text" name="new_link0" placeholder="/link" size="48" class="mi">';
$content .= '<span class="but" onclick="ami(0)"> + </span></li>'; //Добавить&nbsp;подпункт&nbsp;меню
$content .= '</ul></form>';
//$content .= 'i='.$i . ' j='.$j . ' k='.$k . '<br/>';
return $content;

?>
