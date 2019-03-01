<!--Раздел модерации комментариев в админке.-->
<script src="/resources/js/admin/commentaries.js"></script>
<?php
$content = '<h3>Комментарии на модерации:</h3><br/>';
if (!count($nmc))
$content .= 'Непромодерированных комментариев нет.';
else {
    for ($i=0;$i<count($nmc);$i++) {
        if ($nmc[$i]['answer_on']) $ct = 'Ответ на комментарий ID: '.$nmc[$i]['answer_on'].' ';
        else $ct = 'Комментарий ';

        $content .= '<p class="nmc">
<span class="commentatribute"> '.
            $nmc[$i]['commentatorName'].
            ', '.$nmc[$i]['date'].
            '</span>. ID: '.$nmc[$i]['id'].'</br>
<span class="commenttext"> '.$nmc[$i]['text'].'</span><br/>
<img src="/resources/images/admin/mod.png" class="modcom" onclick="modcom('.$nmc[$i]['id'].')" />
<span class="commentatribute">'.$ct.'<a href="/news/'.$nmc[$i]['newsId'].'">новости. </a></span>
</p>';
}
}
return $content;
?>