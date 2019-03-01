<!--Раздел редактирования комментариев в админке.-->
<script src="/resources/js/admin/news.js"></script>
<?php
if (!isset($newsItem['id'])) $content = 'Такой новости нет.<br/>';
else {
    $content = 'Редактируем новость id:'.$newsItem['id'].'.<br/>';
if ($newsItem['isanalytic']) $isanal=' checked'; else $isanal='';

/** Рисуем форму с полями ввода для редактирования новости */
    $content .='
    <form action="/admin/news/'.$newsId.'" method="post">
    
    <table width="100%">
    <tr> <!--Тема новости-->
    <td class="en"><p id="newTheme2">'.$newsItem['theme'].'</p> 
    <input type="text" id="newTheme1" name="theme" value="'.$newsItem['theme'].'" maxlength="100">
    </td><td><img src="/resources/images/admin/edit.jpg" class="rednew" onclick="edittheme()"> </td> 
    </tr><!--Кнопка режима редактирования из картинки-карандаша-->
    <tr><td class="en">
    <p id="newText2">'.nl2br($newsItem['text']).'</p>
    <textarea id="newText1" name="text">'.$newsItem['text'].'</textarea> <!-- Текст новости -->
    </td><td class="icons"><img src="/resources/images/admin/edit.jpg" class="redcom" onclick="edittext()"> </td>
    </tr>';/*Кнопка режима редактирования из картинки-карандаша*/

    /**  Выбор категории */
    $content .= '<tr><td>Категория новостей*:<br/> 
<select size="5" name="cathegory" id="cathegory">';
    for ($i=0;$i<count($cathegories);$i++) {
        if ($cathegories[$i]['cath_ru']==$newsItem['cathegory']) $content .= '<option selected>';
        elseif ($cathegories[$i]['cath_ru']=='аналитика') $content .='<option disabled>';
        else $content .= '<option>';
        $content .=$cathegories[$i]['cath_ru'].'</option>';
    }
    $content .= '</select>';

    /** Аналитическая статья или нет - определяется чекбоксом */
$content .='<input type="checkbox" id="isanalytic" name="isanalytic"'.$isanal.'>
<label for="isanalytic">Аналитическая статья</label>

<!-- Скрытое поле - для передачи id новости -->
<input type="hidden" name="id" value="'.$newsId.'">
</td></tr>';

    /** Кнопка для отправки формы */
    $content .= '<tr><td><input type="submit" class="but" value="Сохранить"></td></tr>
</table></form>
';

    /** Форма загрузки картинки для новости - на аджаксе. */
    $content.='<input id="sortpicture" type="file" name="file" />
<button id="upload" class="but" onclick="zf('.$newsId.', '.$uploadPictureName.')">Upload</button>';

    /** Отображаем картинки, с кнопкой удаления */
    $content.='<table>';
    for ($i=0;$i<count($newsItem['pictures']);$i++) {
        $content .= '<tr><td class = "newsImgconteiner">
                <img id="newsImg'.$newsItem['pictures'][$i].'" src = "/resources/images/news/'
            .$newsItem['pictures'][$i].'" class = newsImg>
                    
 <!-- Сообщение что картинка удалена, по-умолчанию оно не отображается -->
            <span class="dellImg" id="imgDel'.$newsItem['pictures'][$i].'">
            <b>Картинка удалена из новости.</b></span></td><td>
                '.$newsItem['pictures'][$i].'<br/>
                
 <!-- Кнопка удаления картинки из новости. Выполнена из картинки в виде корзины -->               
                <img class="redcom" class="message-ok" src="/resources/images/admin/korzina.jpg" 
                onclick="dellimg(\''.$newsItem['pictures'][$i].'\')">
                </td>
                </tr>';
    }
    $content.='</table>';

    /** Ссылка перехода на управление тегами данной страницы */
    $content .= '<p class="taglist">Теги данной новости: '.$newsItem['tags'].'<br/>';
    //$content .= '<a href="/admin/news/managetags/'.$newsId.'">УПРАВЛЕНИЕ ТЕГАМИ ЭТОЙ НОВОСТИ</a></p>';
    $content .= include(ROOT.'/views/admin/news/tag.php');

}
return $content;