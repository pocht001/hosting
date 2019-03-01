<!--Раздел редактирования комментариев в админке.-->
<script src="/resources/js/admin/commentaries.js"></script>
<?php

//editpopup - окно с редактируемым комментарием
$editpopup = ' 
    <div id="overlay" onclick="cancelEdit()"></div>
<div class="popup" id="popup1">
	<span id="close" onclick="cancelEdit()">X</span>
  <p><textarea id="comText"></textarea></p>
  <input type="hidden" id="cih"> <!-- это для установки id новости в функцию editcomment js -->
  <p><button class="subscribe" onclick="editcomment()">Подтвердить редактирование.</button></p>
</div>
    ';

//content - на данной странице это комментарии к новостям, сортированные по убыванию id
$content = '<h3>Все комментарии:</h3><br/>';
if (!count($commentList))
    $content .= 'Комментариев нет.<br/>';
else {
    $content .= '<table>';

    for ($i=0;$i<count($commentList);$i++) {
    if ($commentList[$i]['answer_on']) $ct = 'Ответ на комментарий ID: '.$commentList[$i]['answer_on'].' '; // $ct - comments type
    else $ct = 'Комментарий ';
    if ($commentList[$i]['ismoderated'])
        $modImage = '<img class="redcom" src="/resources/images/admin/mod.png" onclick="cancelmod('.$commentList[$i]['id'].')" />';
        //$mod = '/resources/images/admin/mod.png';
    else $modImage = '<img class="redcom" src="/resources/images/admin/notmod.png" onclick="modcom('.$commentList[$i]['id'].')" />';
        //$mod = '/resources/images/admin/notmod.png';
        $content .= '<tr><td class="nmc">
<span class="commentatribute"> '.$commentList[$i]['commentatorName'].
            ', '.$commentList[$i]['date'].'</span> ID: '.$commentList[$i]['id'].'</br>
<div class="commenttext" id="edcom'.$commentList[$i]['id'].'"> '.$commentList[$i]['text'].'</div><br/>
<span class="commentatribute">'.$ct.'<a href="/news/'.$commentList[$i]['newsId'].'">новости. </a>
likes: '.$commentList[$i]['likes'].'; dislikes: '.$commentList[$i]['dislikes'].'.</span></td>
<td class="icons"><img class="redcom" src="/resources/images/admin/edit.png" onclick="ec('.$commentList[$i]['id'].')" />
</td><td class="icons">'.$modImage.'</td></tr>';
    }
    $content .= '</table>';
    if ($paginator)
        $content .= '<div class="pagblock">'.$paginator->pag('/admin/comments/edit/',$countPages, $page).'</div>';

    $content .= $editpopup;
}
return $content;
?>