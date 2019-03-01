<?php
$content1 = '
<form action="/admin/cathegories/add" method="POST" enctype="multipart/form-data">
    <p>Введите названии категории новостей кириллицей, можно с цифрами, мин 3 символа:<br />
    <input type="text" name="cath_ru" pattern="[А-Яа-яЁё0-9]{3,}"></p>
    <p>Латыницей, для подстановку в адресную строку (от 3 символов, можно с цифрами):<br />
    <input type="text" name="cath_eng" pattern="[a-zA-Z0-9]{3,}"></p>
    <p><input type="submit" class="but" value="Добавить категорию."></p>
   </form>
';


$content1 .= '<div>Категории новостей, которые уже есть на портале:<br/><table>';
$content1 .= '<tr><td>Название категории</td><td>В адр строке</td><td>Количество новостей</td></tr>';
for ($i=0;$i<count($cathegories);$i++) {
    $content1 .= '<tr><td>'.$cathegories[$i]['cath_ru'].'</td>';
    $content1 .= '<td>'.$cathegories[$i]['cath_eng'].'</td>';

    $content1 .= '<td>'.$cathegories[$i]['count_news'].'</td></tr>';
};
$content1 .= '</table></div>';
return $content1;