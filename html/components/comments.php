<?php
/**Массив блоков ответов на комментарии
 */
$k=0;
for ($i=0;$i<count($commentsList);$i++) {
    $answers[$i] = '';
    $answerList[$i] = Comments::getAnswersByCommentId($commentsList[$i]['id']);

    $answers[$i] .= '<br><textarea placeholder="Ответ на комментарий" class="ansText"></textarea>';

    if (isset($_SESSION['id'])) {
    $answers[$i] .= '<br><input TYPE="button" class="show_ans_textarea" value="Ответить"
onClick="show_ans_textarea(' . $i . ')">';
    if ($newsItem['cathegory'] == 'политика')
        $answers[$i] .= '<span class="commentatribute">Ответ отобразится только после одобрения модератором.</span>';
    $answers[$i] .= '<input TYPE="button" class="addanswer" value="Ответить"
onClick="addanswer(' . $commentsList[$i]['id'] . ',' . $_SESSION['id'] . ',' . $i . ',' . $newsId . ')">';
}
if (count($answerList[$i])) {
    $answers[$i].='</br>_____________';
    $answers[$i].='Ответы:<div class="answers">';
    for ($j=0;$j<count($answerList[$i]);$j++) {
        $ans= $answerList[$i][$j];
        //var_dump($ans); echo "<br>";
        $answers[$i].= '<p><span class="commentatribute">'.
            $ans['commentatorName'].
            ', '.$ans['date'].
            '</span></br><span class = "commenttext">'.
            $ans['text'].'</span></br>
            
            <span class="like" onclick="like('.$ans['id'].','.$k.',1)"> 
            <img src="/resources/images/comments/plus.png" class="like" />
            <span class="la">'.$ans['likes'].'</span></span>
            
            <span class="like" onclick="dislike('.$ans['id'].','.$k.',1)"> 
            <img src="/resources/images/comments/minus.png" class="like" />
            <span class="dla">'.$ans['dislikes'].'</span></span></p>
';
        $k++;
    }
    $answers[$i].='</div>';
}

}

/** Блок комментариев
 */
$comments = 'Комментарии к новости:';
if (isset($_SESSION['id'])) {
    $comments .= '<span id="addedComment"><br><textarea placeholder="Оставить комментарий" id="comText"></textarea><br>';
    $comments .= '<input TYPE="button" name="publicComment" id="publicComment" value="Комментировать" 
onClick="addcomment(' . $newsId . ',' . $_SESSION['id'] . ',comText.value)"></span>';
    if ($newsItem['cathegory'] == 'политика') $comments .= '<span class="commentatribute"> 
Комментарии новостей категории политика появляются только после одобрения модератором.</span>';
}
if (count($commentsList)) {
    for ($i=0;$i<count($commentsList);$i++) {
        $comments.= '<div class="comment">
                    <span class="commentatribute">'.
            $commentsList[$i]['commentatorName'].
            ', '.$commentsList[$i]['date'].
            '</span></br>
                    <span class = "commenttext">'.
            $commentsList[$i]['text'].'</span></br>
            <span class="like" onclick="like('.$commentsList[$i]['id'].','.$i.',0)"> 
            <img src="/resources/images/comments/plus.png" class="like" />
            <span class="l">'.$commentsList[$i]['likes'].'</span></span>
            
            <span class="like" onclick="dislike('.$commentsList[$i]['id'].','.$i.',0)"> 
            <img src="/resources/images/comments/minus.png" class="like" />
            <span class="dl">'.$commentsList[$i]['dislikes'].'</span></span>
            '.$answers[$i].'
            </div>';
    }
    //По количеству комментариев определяем количество страниц и нужен ли пагинатор
    if ($commentsCount>5) {
        $countPages = ceil($commentsCount/5);
        $paginator2 = new Paginator();
        $pag = '<span id="pagblock">'.$paginator2->pag('/news/'.$newsId.'/',$countPages, $pageComment).'</span>';
        $comments.=$pag;
    }
}
else $comments.='</br>Нету комментариев. </br>';
//$comment.='</p>';

return $comments;