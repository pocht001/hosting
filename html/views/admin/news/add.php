<!--Раздел Добавления новостей в админке.-->
<script src="/resources/js/admin/news.js"></script>
<?php
$content = '<h3>Тут можно добавить новость.</h3>';
$content.=' <form action="/admin/news/add" method="POST" enctype="multipart/form-data">
 <div id="new_added"> </div> <!--Сообщение об ошибке/успехе-->
 <div id="addnew">';// Блок с полями ввода новости

$content .= '<p>Тема новости*:<br/><textarea id="newTheme" name="newTheme" maxlength="100" autofocus></textarea></p>
<p>Текст новости*:<br/><textarea id="newText" name="newText" autofocus></textarea></p>';

$content .= '<p>Категория новостей*:<br/>
<select size="5" name="cathegory" id="cathegory">';
for ($i=0;$i<count($cathegories);$i++) {
    if ($cathegories[$i]['cath_ru']=='аналитика') $content .='<option disabled>';
    else $content .= '<option>';
    $content .=$cathegories[$i]['cath_ru'].'</option>';
}
$content .= '</select><input type="checkbox" id="isanalytic" name="isanalytic">
<label for="isanalytic">Аналитическая статья</label></p>';

$content .= '<table><tr><td class="tags">';
$content .= 'Теги новостей:<br/>
<select multiple="multiple" size="8" name="tags[]" id="tags">';
for ($i=0;$i<count($allTags); $i++) {
    $content .= '<option>'.$allTags[$i].'</option>';
}
$content .= '</select></td>';
$content .= '<td class="userTags"><div id="userTags">Можете добавить свои теги:<br/>';

for ($i=0;$i<$countUserTag;$i++) $content .= '<input type="text" class="userTag" name="userTag'.$i.'" maxlength="20">';

$content .= '</div></td></tr></table>';

$content .= '<div>Добавить картинку: <input type="file" name="file" ></div>';

$content.='<p><input type="submit" class="but" value="Создать новость"></p>
</div></form>
';

return $content;