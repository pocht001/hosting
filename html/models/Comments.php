<?php
/**
 */
include_once ROOT.'/models/News.php';
include_once ROOT.'/components/Db.php';
include_once ROOT.'/models/Users.php';

class Comments
{
/** Получить количество комментариев по id новости */
    public static function getCountCommentsByNewsId($newsId, $isLastDay=0, $moderOnly=1)
    {
        $newsId = intval($newsId);
        $commentsList = array();
        if ($newsId) {
            $db = Db::getConnection();

            $query = 'SELECT COUNT(*) FROM comments WHERE newsId = ' . $newsId . ' AND answer_on = 0';
            if ($moderOnly) $query .= ' AND ismoderated = 1';
            if ($isLastDay) $query .= ' AND comments.date > DATE_SUB(CURDATE(), INTERVAL 1 DAY)';
            $result = $db->query($query);
        }
        $res = $result->fetch();
        return $res[0];
    }

    /** Получить список комментариев по id новости
     */
    public static function getCommentsByNewsId($newsId, $limit=0, $offset=0, $moderOnly=1) {
        $newsId = intval($newsId);
        $commentsList = array();
        if ($newsId) {
            $db = Db::getConnection();

            $query = 'SELECT * FROM comments WHERE newsId = '.$newsId.' AND answer_on = 0';
            if ($moderOnly) $query .= ' AND ismoderated = 1';
            $query .= ' ORDER BY likes DESC';
            if ($limit&&$offset) $query = $query.' LIMIT '.$offset.', '.$limit;
            elseif ($limit) $query = $query.' LIMIT '.$limit;
            $result = $db->query($query);
            $i=0;
            while ($row = $result->fetch()) {
                $commentsList[$i]['id'] = (int)$row['id'];
                $commentsList[$i]['text'] = $row['text'];
                $commentsList[$i]['newsId'] = $row['newsId'];
                $commentsList[$i]['date'] = $row['date'];
                $commentsList[$i]['commentatorId'] = $row['commentatorId'];
                $commentsList[$i]['likes'] = $row['likes'];
                $commentsList[$i]['dislikes'] = $row['dislikes'];
                $commentsList[$i]['answer_on'] = $row['answer_on'];
                $commentsList[$i]['ismoderated'] = $row['ismoderated'];
                $commentsList[$i]['commentatorName'] = Users::userInfById($row['commentatorId'])['login'];

                $i++;
            }
        }
        return $commentsList;
    }

    /** Получить список ответов на комментарий
     */
    public static function getAnswersByCommentId($answered_comment, $moderOnly=1) {
        $answerList = array();
        $answered_comment = intval($answered_comment);
        if ($answered_comment) {
            $db = Db::getConnection();

            $query = 'SELECT * FROM comments WHERE answer_on = '.$answered_comment;
            if ($moderOnly) $query .= ' AND ismoderated = 1';
            $query .= ' ORDER BY likes DESC';
            $result = $db->query($query);
            $i=0;

            while ($row = $result->fetch()) {
                $answerList[$i]['id'] = (int)$row['id'];
                $answerList[$i]['text'] = $row['text'];
                $answerList[$i]['newsId'] = $row['newsId'];
                $answerList[$i]['date'] = $row['date'];
                $answerList[$i]['commentatorId'] = $row['commentatorId'];
                $answerList[$i]['likes'] = $row['likes'];
                $answerList[$i]['dislikes'] = $row['dislikes'];
                $answerList[$i]['answer_on'] = $row['answer_on'];
                $answerList[$i]['ismoderated'] = $row['ismoderated'];
                $answerList[$i]['commentatorName'] = Users::userInfById($row['commentatorId'])['login'];

                $i++;
            }
        }
        return $answerList;
    }

    public static function getCommentsByUserId($userId, $limit=0, $offset=0) {
        $commentList = array();
        $userId = abs(intval($userId));
        if($userId) {
            $db = Db::getConnection();
            $query = 'SELECT * FROM comments WHERE commentatorId = '.$userId.' ORDER BY likes DESC';
            if ($limit&&$offset) $query = $query.' LIMIT '.$offset.', '.$limit;
            elseif ($limit) $query = $query.' LIMIT '.$limit;
            $result = $db->query($query);
            $i=0;

            while ($row = $result->fetch()) {
                $commentList[$i]['id'] = (int)$row['id'];
                $commentList[$i]['text'] = $row['text'];
                $commentList[$i]['newsId'] = $row['newsId'];
                $commentList[$i]['date'] = $row['date'];
                $commentList[$i]['commentatorId'] = $row['commentatorId'];
                $commentList[$i]['likes'] = $row['likes'];
                $commentList[$i]['dislikes'] = $row['dislikes'];
                $commentList[$i]['answer_on'] = $row['answer_on'];
                $commentList[$i]['ismoderated'] = $row['ismoderated'];
                $commentList[$i]['commentatorName'] = Users::userInfById($row['commentatorId'])['login'];
                $i++;
            }
        }
        return $commentList;
    }

    /** Добавить комментарий
     */
    public static function addComment($newsId, $userId, $commentText, $answer_on){
        $newsId = abs(intval($newsId));
        $userId = abs(intval($userId));
        $newsIds = News::getNewsId();
        if (!in_array ($newsId, $newsIds)) $newsId=0;
        //Запрос к б.д.
        if ($newsId && $userId && strlen($commentText)) {
            $commentText = filter_var($commentText, FILTER_SANITIZE_STRING);
            $ispolit=News::getNewsCathegoryById($newsId);
            if ($ispolit['cathegory']=='политика') $moderated=0; //Категория политика - добавляется немодерированной.
            else $moderated=1; //Другие категории - новость добавляется промодерированной.
            $db = Db::getConnection();
            $query = 'INSERT INTO comments (text, commentatorId, newsId, answer_on, ismoderated)
            VALUES ("'.$commentText.'", '.$userId.', '.$newsId.', '.$answer_on.', '.$moderated.')';

            $result = $db->query($query);
            if ($result) {
                $res  = $db->query("SELECT LAST_INSERT_ID()");
                $resultId = $res->fetchColumn();
                return $resultId;
            }
        }
        return false;
    }

    /** Проверяем соответствует ли id новости id комментария
     */
    public static function checkComment($newsId, $commentId) {
        $newsId = abs(intval($newsId));
        $commentId = abs(intval($commentId));
        if ($newsId && $commentId) {
            $db = Db::getConnection();
            $query = 'SELECT id from comments WHERE id = '.$commentId.' AND newsId = '.$newsId;
            $result = $db->query($query);
            $row = $result->fetch();
        }
        return $row['id'];
    }

    /** Получение кол-ва плюсов и минусов комментария
     */
    public static function getLikes($commentId) {
        $commentId = intval($commentId);
        $db = Db::getConnection();
        $query = 'SELECT likes, dislikes from comments WHERE id = '.$commentId;
        $result = $db->query($query);
        $row = $result->fetch();
        $ld['likes'] = $row['likes'];
        $ld['dislikes'] = $row['dislikes'];
        return $ld;
    }

    public static function like($commentId)
    {
        $commentId = intval($commentId);
        //Запрос к б.д.
        if ($commentId) {
            $db = Db::getConnection();
            $query = 'UPDATE comments SET likes=likes+1 WHERE id='.$commentId;
            $db->query($query);
            $result = self::getLikes($commentId);
        }
        return json_encode($result);
    }

    public static function dislike($commentId)
    {
        $commentId = intval($commentId);
        //Запрос к б.д.
        if ($commentId) {
            $db = Db::getConnection();
            $query = 'UPDATE comments SET dislikes=dislikes+1 WHERE id='.$commentId;
            $db->query($query);
            $result = self::getLikes($commentId);
        }
        return json_encode($result);
    }

    public static function getCountCommentsByUser($userId=0) {
        $userId=abs(intval($userId));
        if($userId) {
            $db = Db::getConnection();
            $result = $db->query('SELECT COUNT(*) FROM comments WHERE commentatorId=' . $userId);
            $res = $result->fetch();
            $count = (int)$res[0];
            return $count;
        }
        else return 0;
    }

public static function updateComment($commentId=0, $text=null) {
        if ($commentId && $text) {
            $db = Db::getConnection();
            $query = 'UPDATE comments SET text = \''.$text.'\' WHERE id ='.$commentId;
            $db->query($query);
            return true;
        } else return false;
}

public static function zapoltiaha() {
        $lorem = 'Cras vel blandit est. Integer ultrices urna ligula, quis lacinia dolor pharetra quis. Mauris quis laoreet ligula, a sollicitudin ipsum. Aliquam iaculis dui at semper malesuada. Curabitur at ipsum eu urna finibus finibus et id risus. Duis eget dui non mi blandit aliquam id quis tellus. Duis finibus sollicitudin aliquam. Nam nisi leo, varius sed dictum nec, rutrum quis lectus. Nullam tempor eleifend ex, sed mollis quam tristique vitae. Fusce sodales ante metus, nec cursus turpis eleifend vitae.
        ';

        $db = Db::getConnection();
        $text = explode('.',$lorem);
        $u=4;$nstart=22;
        for ($i=1;$i<count($text);$i++) { //count($text)
            $ni=$i+$nstart-1;
            $q='SELECT id from news WHERE id='.$ni;
            $q=$db->query($q);
            $res=$q->fetch();
            echo $res['id'];
            if ($res['id']==$ni)
            {
                $query = 'INSERT INTO comments (text, newsId, commentatorId, likes, dislikes)
VALUES ("'.$text[$i].".".'",'.$ni.','.$u.','.rand(0,6).','.rand(0,3).')';
                echo $query.'<br>';
                //$db->query($query);
            }
        $u++;
        //$ni++;
        if ($u>21) $u=4;
        //if ($ni>68) $ni=60;
        }
    return true;
}

public static function getNotModeratedComment() {
    $commentList = array();
        $db = Db::getConnection();
        $query = 'SELECT * FROM comments WHERE ismoderated=0 ORDER BY date DESC';
    $result = $db->query($query);
    $i=0;
    while ($row = $result->fetch()) {
        $commentList[$i]['id'] = (int)$row['id'];
        $commentList[$i]['text'] = $row['text'];
        $commentList[$i]['newsId'] = $row['newsId'];
        $commentList[$i]['date'] = $row['date'];
        $commentList[$i]['commentatorId'] = $row['commentatorId'];
        $commentList[$i]['likes'] = $row['likes'];
        $commentList[$i]['dislikes'] = $row['dislikes'];
        $commentList[$i]['answer_on'] = $row['answer_on'];
        $commentList[$i]['ismoderated'] = $row['ismoderated'];
        $commentList[$i]['commentatorName'] = Users::userInfById($row['commentatorId'])['login'];
        $i++;
    }
    return $commentList;
}

public static function moderation($commentId=0) {
        $result=null;
        if ($commentId) {
            $db = Db::getConnection();
            $query = 'UPDATE comments SET ismoderated = 1 WHERE id = '.$commentId;
            $result = $db->query($query);
        }
        return $result;
}

    public static function cancelmoderation($commentId=0) {
        $result=null;
        if ($commentId) {
            $db = Db::getConnection();
            $query = 'UPDATE comments SET ismoderated = 0 WHERE id = '.$commentId;
            $result = $db->query($query);
        }
        return $result;
    }

public static function getCountAllComments() {
    $db = Db::getConnection();
    $result = $db->query('SELECT COUNT(*) FROM comments');
    return $result->fetch();
}

    public static function getAllComment($limit=0, $offset=0) {
        $commentList = array();
        $db = Db::getConnection();
        $query = 'SELECT * FROM comments ORDER BY date DESC';
        if ($limit&&$offset) $query = $query.' LIMIT '.$offset.', '.$limit;
        elseif ($limit) $query = $query.' LIMIT '.$limit;
        $result = $db->query($query);
        $i=0;
        while ($row = $result->fetch()) {
            $commentList[$i]['id'] = (int)$row['id'];
            $commentList[$i]['text'] = $row['text'];
            $commentList[$i]['newsId'] = $row['newsId'];
            $commentList[$i]['date'] = $row['date'];
            $commentList[$i]['commentatorId'] = $row['commentatorId'];
            $commentList[$i]['likes'] = $row['likes'];
            $commentList[$i]['dislikes'] = $row['dislikes'];
            $commentList[$i]['answer_on'] = $row['answer_on'];
            $commentList[$i]['ismoderated'] = $row['ismoderated'];
            $commentList[$i]['commentatorName'] = Users::userInfById($row['commentatorId'])['login'];
            $i++;
        }
        return $commentList;
    }

}
