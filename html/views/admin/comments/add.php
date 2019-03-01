<!--Раздел редактирования комментариев в админке.-->
<script src="/resources/js/admin/commentaries.js"></script>
<?php
$content = '<h3>Тут можно добавить комментарий.</h3>';
$content.=' 
 <div id="message_added"> </div> <!--Сообщение об ошибке/успехе-->
 <div id="addcomment">
<p>Комментируемая новость. id: тема<br/>
<select size="8" name="newsId" id="newsId">';
for ($i=count($newsList)-1;$i>=0;$i--) {
    $content .= '<option value="'.$newsList[$i]['id'].'">'.$newsList[$i]['id'].' : '.$newsList[$i]['theme'].'</option>';
}
$content .= '</select></p>';
$content .= '<p>Текст комментария:<br/>
<textarea id="comText" name="comText" autofocus></textarea></p>';
$content .= 'Комментируем от имени пользователя: admin<br/>
<!-- Сначала обрабатываем данные полей в javascript, чтобы вытянуть id комментируемой новости из строки и отреагировать 
на незаполненные поля, а оттуда отправляем ajax-ом запрос добавления комментария в CommentController -->
  <p><button class="subscribe" onclick="addc(newsId,comText)">Добавить комментарий.</button></p>
</div>
';
return $content;