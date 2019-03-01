<!--Раздел редактирования комментариев в админке.-->

<?php
$content .= '<table class="nl">
<tr>
<td>id</td><td>Тема</td><td>Категория</td><td>Дата публикации</td><td>Ред.</td>
</tr>
';
for ($i=0;$i<count($allNews);$i++) {
    $content .= '
<tr>
<td>'.$allNews[$i]['id'].'. </td>
<td><a href="/news/'.$allNews[$i]['id'].'">'.$allNews[$i]['theme'].'</a></td>
<td>'.$allNews[$i]['cathegory'].'</td>
<td>'.$allNews[$i]['publicDate'].'</td>
<td><a href="/admin/news/'.$allNews[$i]['id'].'"><img src="/resources/images/admin/edit.png" class="rednew" /></a></td>
</tr>
';
}
$content .= '</table>';
if ($paginator)
    $content .= '<div class="pagblock">'.$paginator->pag('/admin/news/edit/',$countPages, $page).'</div>';

return $content;
