<?php
/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 17.10.2018
 * Time: 1:42
 */
session_start();
include_once ROOT.'/models/News.php';
include_once ROOT . '/models/Tag.php';
include_once ROOT . '/models/Comments.php';
include_once ROOT.'/controllers/UserController.php';
include_once ROOT.'/models/Cathegories.php';

class NewsController
    {
        public function actionIndex($params = null)
    {
    $newsList = array();

        $cats = Cathegories::getCathegories();
        for ($i=0;$i<count($cats);$i++) {
            $newsList[$cats[$i]['cath_eng']]  = (array)News::getNewsListByCathegory($cats[$i]['cath_eng'],5);
        }

        $sliderList = News::sliderList(); // Подключаем слайдер к странице.

        $uc = new UserController();
        // Список топ-5 комментаторов
        $topCommentators = $uc->actionTopCommentators();
        $t3c=$this->top3ActiveTheme();

        require_once (ROOT.'/views/news/index.php');

    return true;
}

    /** Отображаем содержимое новости по её id, который передается в параметре 0
     */
    public function actionView($params = null)
    {
        $newsId = intval($params[0]);
     if ($newsId) {
         $pageComment=0;
         $offset=0;
         if (count($params)>1) { //Определяем страницу пагинации комментариев
             $pageComment = abs((int)$params[1]);
             if ($pageComment) $offset=($pageComment-1)*5;
             else $offset=0;
         }

         $newsItem = News::getNewsItemById($newsId);
         $readNow = rand(0,5);
         $readAll = News::haveReadNew($newsId);
         News::AddnewReaders($newsId,$readNow);
         $tagList = Tag::getTagsByNewsId($newsId);
         $commentsCount = (int)Comments::getCountCommentsByNewsId($newsId);
         $commentsList = Comments::getCommentsByNewsId($newsId, 5, $offset);
     }
        $sliderList = News::sliderList(); // Подключаем слайдер к странице.
    require_once (ROOT.'/views/news/newsItem.php');
        return true;
    }

    public function actionCathegory ($params)
    {
        $cathegory = $params[0];
        $page = 0;
        $offset=0;
        if (count($params)>1) {
            $page = abs((int)$params[1]);
            if ($page)
            $offset = ($page-1)*5;
            else $offset = 0;
        }
        $cathName = Cathegories::cathegoryName($cathegory);
        $newsListByCathegory = News::getNewsListByCathegory($cathegory,5,$offset);

        $sliderList = News::sliderList(); // Подключаем слайдер к странице.
        require_once (ROOT.'/views/news/newsCathegory.php');
        return true;
    }

    public function actionHowReadAdd($params = null) {

        $newsId = (isset($_POST['id'])) ? $_POST['id'] : 0;
        $readersAdd = (isset($_POST['readersAdd'])) ? $_POST['readersAdd'] : 0;

        $readAll = News::haveReadNew($newsId);
        News::AddnewReaders($newsId,$readersAdd);

        echo $readAll;
    }

    public function top3ActiveTheme() {
        $newsId = News::getNewsId();
        $max = array();
        $max[1]['count']=$max[2]['count']=$max[3]['count']=0;
        $max[1]['id']=$max[2]['id']=$max[3]['id']=0;
        $max[1]['theme']=$max[2]['theme']=$max[3]['theme']='';
        for ($i=0;$i<count($newsId); $i++) {
            $ccn = Comments::getCountCommentsByNewsId($newsId[$i],1);
            if ($ccn>$max[1]['count']) {
                $max[3]['count'] = $max[2]['count'];
                $max[2]['count'] = $max[1]['count'];
                $max[1]['count'] = $ccn;
                $max[3]['id'] = $max[2]['id'];
                $max[2]['id'] = $max[1]['id'];
                $max[1]['id'] = $newsId[$i];
                $max[3]['theme'] = $max[2]['theme'];
                $max[2]['theme'] = $max[1]['theme'];
                $max[1]['theme'] = News::getNewsItemById($newsId[$i])['theme'];
            } else if ($ccn>$max[2]['count']) {
                $max[3]['count'] = $max[2]['count'];
                $max[2]['count'] = $ccn;
                $max[3]['id'] = $max[2]['id'];
                $max[2]['id'] = $newsId[$i];
                $max[3]['theme'] = $max[2]['theme'];
                $max[2]['theme'] = News::getNewsItemById($newsId[$i])['theme'];
            } else if ($ccn>$max[3]['count']) {
                $max[3]['count'] = $ccn;
                $max[3]['id'] = $newsId[$i];
                $max[3]['theme'] = News::getNewsItemById($newsId[$i])['theme'];
            }
        }
        return $max;
    }

// Для служебных целей. Шобы даты новостям повыставлять.
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

}