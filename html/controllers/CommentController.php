<?php
session_start();
include_once ROOT.'/models/Comments.php';
include_once ROOT.'/models/Users.php';
/**
 */

class CommentController
{
    public function actionGetCommentsByNewsId($params=null) {
        // Получить список комментариев по id новости
        $newsId = $params[0];
        if (isset($newsId)) $commentsList = Comments::getCommentsByNewsId($newsId);
        echo json_encode($commentsList);
        return true;
    }

    public function actionGetAnswersByCommentId($params=null) {
        // Получить список ответов на комментарий по id комментария
        $answered_comment = $params['0'];
        if (isset($answered_comment)) $answersList = Comments::getAnswersByCommentId($answered_comment);
        echo json_encode($answersList);
        return true;
    }

    public function actionGetCommentsByUserId($params=null) {
        // Получить комментарии, оставленные юзером
        $commentatorId = $params[0];
        $page = 0;
        $offset=0;
        if (count($params)>1) {
            $page = abs((int)$params[1]);
            if ($page)
                $offset = ($page-1)*5;
            else $offset = 0;
        }
        $cun = Comments::getCountCommentsByUser($commentatorId);
        $commentator = Users::userInfById($commentatorId);
        if (isset($commentatorId)) $userComment = Comments::getCommentsByUserId($commentatorId, 5, $offset);
        require_once (ROOT.'/views/comment/userComments.php');
        return true;
    }

    public function actionAddComment($params=null) {
        // Добавить комментарий к новости
        $newsId = $params[1];
        $userId = (isset($_POST['userid'])) ? $_POST['userid'] : 0;//$params[2]; //$_SESSION['id'];
        $answerOn = (isset($_POST['answer_on'])) ? intval($_POST['answer_on']) : 0;
        $res = "{\"result\":\"false\"}";
        if ($user = Users::userInfById($userId)) {
            if (isset($_POST['commentText'])) {
                $commentText = nl2br($_POST['commentText']);

                if (!$answerOn) $result = Comments::addComment($newsId, $userId, $commentText, 0);
                elseif ($check = Comments::checkComment($newsId,$answerOn))
                    $result = Comments::addComment($newsId, $userId, $commentText, $answerOn);
                else {
                    $res = "{\"result\":\"false\", \"error\":\"news comment mismatch\"}";
                    $result = 0;
                }
                if ($result)
                $res = "{\"result\":\"true\", \"comment_id\":\"".$result."\"}";
            }
        }
        echo $res;
        return true;
    }

public function actionUpdateComment($params=null) {
    $commentId=$params[1];
    if ($commentId) {

        if (isset($_POST['commentText'])) {
            $commentText = nl2br($_POST['commentText']);
            Comments::updateComment($commentId, $commentText);
            return true;
    }
}}

    public function actionDeleteComment($params=null) {
        return true;
    }

    public function actionGetLikes($params=null) {
        //$like,_$dislike, $newsId, $userId
        // Получить количество плюсов (лайков) и минусов (дизлайков) комментария
        $commentId = intval($params[1]);
        $likeDislike = array();
        if ($commentId) {
            $likeDislike = Comments::getLikes($commentId);
            echo json_encode($likeDislike);
        }
        return true;
    }

    public function actionAddLike($params=null) {
        // Плюсонуть комментарий (добавить лайк)
        $commentId = $params[1];
        $res = Comments::like($commentId);
        echo $res;
        return true;
    }

    public function actionAddDislike($params=null) {
        // Минуснуть комментарий (добавить дизлайк)
        $commentId = $params[1];
        $res = Comments::dislike($commentId);
        echo $res;
        return true;
    }

    public function actionModeration($params=null) {
        $commentId=$params[1];
        if ($_SESSION['admin_id']) {
            $res = Comments::moderation($commentId);
            if ($res)
            echo '{"result":"true", "commentId":"'.$commentId.'"}';
        }
        return true;
    }

    public function actionModerationcancel($params=null) {
        $commentId=$params[1];
        if ($_SESSION['admin_id']) {
            $res = Comments::cancelmoderation($commentId);
            if ($res)
                echo '{"result":"true", "commentId":"'.$commentId.'"}';
        }
        return true;
    }

}