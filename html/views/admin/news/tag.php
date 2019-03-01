<!--Раздел редактирования тегов новости  в админке.-->
<script src="/resources/js/admin/news.js"></script>
<?php
$c=count($tagList);
$content1 = '
<b>Управление тегами новости id: '.$newsId.'</b><br/>';
$content1 .= '<button onclick="saveEditedTags('.$newsId.')">Сохранить изменения тегов</button>';
$content1 .= '<table>';
for ($i=0;$i<$c;$i++) {
    $content1 .= '<tr><td class="nmc">
<input type="text" class="inptag" onkeypress="nst('.$i.')" id="tag_'.$i.'" maxlength="40" value="'.$tagList[$i].'"/></td>
<td><img class="redcom" src="/resources/images/admin/korzina.jpg" onclick="delltag('.$i.')"></td>
<td class="icons"><img class="savetag" id="saved'.$i.'" src="/resources/images/admin/save.jpg" />
<img class="savetag2" id="savetag'.$i.'" src="/resources/images/admin/save2.jpg" /></td>
</tr>';
}
$content1 .= '<tr><td class="nmc"><b>Можете добавить новые теги:</b></td><td class="icons"> </td></tr>';
for ($i=$c;$i<$c+5;$i++) {
    $content1 .= '<tr><td class="nmc">
<input type="text" class="inptag" onkeypress="nst('.$i.')" id="tag_'.$i.'" maxlength="40" placeholder="новый тег"/></td>
<td><img class="redcom" src="/resources/images/admin/korzina.jpg" onclick="delltag('.$i.')"></td>
<td class="icons"><img class="savetag" id="saved'.$i.'" src="/resources/images/admin/save.jpg" />
<img class="savetag2" id="savetag'.$i.'" src="/resources/images/admin/save2.jpg" /></td>
</tr>';
}
$content1 .= '</table>';
$content1 .= '<button onclick="saveEditedTags('.$newsId.')"><img class="saveButton" src="/resources/images/admin/diskette3.jpg">
Сохранить изменения тегов</button>';



//<img class="savetag2" id="savetag'.$i.'" src="/resources/images/admin/save2.jpg" onclick="savetag('.$i.',\''.$tagList[$i].'\')" />
//<img class="redcom" src="/resources/images/admin/korzina.jpg" onclick="delltag(\''.$tagList[$i].'\')">
return $content1;