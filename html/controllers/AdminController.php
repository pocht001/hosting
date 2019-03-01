<?php
session_start();
/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 17.10.2018
 * Time: 1:44
 */
include_once ROOT.'/models/Admins.php';
include_once ROOT.'/models/Comments.php';
include_once ROOT.'/models/News.php';
include_once ROOT.'/models/Cathegories.php';
include_once ROOT.'/models/Tag.php';

class AdminController
{
    public function actionMain($params = null) {
        $message='';
        $content = 'Главная страница админки. <br/>Перейди в нужный раздел и твори чудеса.';
        require_once (ROOT.'/views/admin/index.php');
        return true;
    }

    public function actionCathegories($params = null) {
        $cathegories = Cathegories::getCathegories();
        for ($i=0;$i<count($cathegories);$i++) {
            //не получилось вставить подсчет новостей в модель категорий - ошибку пдо выдает мол too many pdo connections
            $cathegories[$i]['count_news'] = News::getCountNews($cathegories[$i]['cath_eng'])[0];
        }
        $content = 'Админка. Раздел категорий новостей.<br />';
        $content .= include(ROOT.'/views/admin/cathegories/cathMain.php');
        require_once (ROOT.'/views/admin/index.php');
        return true;
    }

    public function actionCathAdd() {
        $message1 = '';
        //Если была отправка формы
        if (count($_POST)) { //разгребаем входные данные для запроса в базу
            if(isset($_POST['cath_ru']) && isset($_POST['cath_eng'])) {
                $res=Cathegories::addCathegory($_POST['cath_ru'],$_POST['cath_eng']);
                //var_dump($res);
                if ((int)$res) $message1.='<p class="message-ok">Категория "'.$_POST['cath_ru'].'" добавлена. ID:'.$res.'</p>';
                else $message1 .= '<p class="message-error">Категория не добавлена. '.$res.'</p>';
            }
        }
        $content = include(ROOT.'/views/admin/cathegories/cathAdd.php');
        require_once (ROOT.'/views/admin/index.php');
        return true;
    }

    public function actionNewsMain($params = null) {
        $message = '';
        $content = "Админка. Раздел новостей.";
        if (isset($params[1])) {
        }
        require_once(ROOT . '/views/admin/index.php');
        return true;
    }

    public function actionNewsAdd () {
        $message = '';
        $content = "Админка. Раздел добавления новостей.";
        $cathegories = Cathegories::getCathegories();
                $allTags = Tag::getAllTags();
                $countUserTag = 5;

                //Если была отправка формы
                if (count($_POST)) { //разгребаем входные данные для запроса в базу
                    if (isset($_POST['isanalytic'])) $isanalytic=1; //чекбокс isanalytic
                    else $isanalytic=0;
                    $tagstring=''; //перечисляем выбранные в списке теги через запятую в строке
                    if (isset($_POST['tags'])) {
                        for ($i=0;$i<count($_POST['tags']);$i++) {
                            $t=(trim($_POST['tags'][$i]));
                            if (strlen($t)) $tagstring.=$t;
                            if ($i<(count($_POST['tags'])-1)) $tagstring .= ', ';
                        }
}
$userTag = array(); //Добавляем введенные пользователем теги в общий список тегов, через запятую
for ($j=0;$j<$countUserTag;$j++) {
    $t=trim($_POST['userTag'.$j]);
    if (strlen($t)) {
        if (strlen($tagstring)) $tagstring.=', ';
        $tagstring .= $t;
    }
}
if (strlen($_POST['newTheme'])&&strlen($_POST['newText'])&&isset($_POST['cathegory'])) {
    $addNew=News::addNewsItem($_POST['newTheme'],$_POST['newText'],$_POST['cathegory'],$isanalytic,$tagstring);
    if ($addNew) $message.= '<p class="message-ok">Новость добавлена. id:'.$addNew.'. </p>';
    else $message.= '<p class="message-error">Новость добавлена не была. Проверьте входные данные</p>';
    //если файлы выбраны
    if(isset($_FILES['file'])) {
        // проверяем, можно ли загружать изображение
        $check = News::can_upload($_FILES['file']);

        if (!strlen($check)) $message.="<strong>Файл не выбран.</strong>";
        elseif (strlen($check)<=4) {

            // загружаем изображение на сервер
            News::make_upload($_FILES['file'],ROOT.'/resources/images/news/' .$addNew.'-1.'.$check);
            $message.= "<strong>Файл успешно загружен!</strong>";
        } else $message.= "<strong>".$check."</strong>";
    }
} else  $message.= '<p class="message-error">Новость добавлена не была. Проверьте входные данные</p>';
}
//header("Cache-Control: no-store,no-cache,mustrevalidate");
//header("Location: ".ROOT."/admin/news/add");
$content = include(ROOT . '/views/admin/news/add.php');
        require_once(ROOT . '/views/admin/index.php');
        return true;
}

public function actionNewsEdit($params = null) {
    $message = '';
    $content = "Админка. Раздел редактирования новостей.";
    $countNews = (int)News::getCountNews()[0];
    //var_dump($params);
    $page=0; $offset=0;
    $paginator=null;
    if (isset($params[2])) $page=(int)$params[2];
    else $page=0;
    if ($page)
        $offset = ($page-1)*20;
    else $offset = 0;
    $allNews = News::getNewsList(20,$offset);
    $countPages = ceil($countNews/20);
    //По количеству комментариев определяем нужен ли пагинатор.
    if ($countPages>1) $paginator = new Paginator();
    $content = include(ROOT . '/views/admin/news/editPage.php');
    require_once(ROOT . '/views/admin/index.php');
    return true;
}

public static function actionEditNewsItem($params=0) {
        $message = '<p id="message"></p>';
        $newsId=(int)abs($params[1]);
    $newsItem=News::getNewsItemById($newsId);
    $cathegories = Cathegories::getCathegories();
    $allTags = Tag::getAllTags();
    $tagList = Tag::getTagsByNewsId($newsId);//$newsItem['tags'];
    $lastPicture = end($newsItem['pictures']);
    if (strlen($lastPicture))
    $uploadPictureName=explode('.',explode($newsId.'-',$lastPicture)[1])[0]+1;
    else $uploadPictureName = 0;

    //Если была отправка формы
    if (count($_POST)) {
        $editedNew = News::updateNewsItem($_POST);
        if ($editedNew) {
            $message .='<p id="message" class="message-ok">Новость изменена успешно. </p>';
        }
        //else $message .= '<p id="message" class="message-error">Новость изменена не была. </p>';
    }
    $content = include(ROOT.'/views/admin/news/editItem.php');
        require_once (ROOT.'/views/admin/index.php');
        return true;
}

public function actionAddFile($params=null) {
        $newsId=$params[1];
        if (isset($_POST['fname'])) $fname=$_POST['fname'];
    if(isset($_FILES['file'])) {
        // проверяем, можно ли загружать изображение
        $check = News::can_upload($_FILES['file']);
        if (!strlen($check)) $message.="<strong>Файл не выбран.</strong>";
        elseif (strlen($check)<=4) {

            // загружаем изображение на сервер
            News::make_upload($_FILES['file'],ROOT.'/resources/images/news/' .$newsId.'-'.$fname.'.'.$check);
            $message= "<strong>Файл успешно загружен!</strong>";
        } else $message= "<strong>".$check."</strong>";

    } echo $message;
}

    public function actionCommentsMain() {
        $content = 'Админка. Раздел комментариев<br/>';
        require_once(ROOT . '/views/admin/index.php');
        return true;
    }

    public function actionCommentsModeration() {
        $content = 'Админка. Раздел модерации комментариев<br/>';
            $nmc = Comments::getNotModeratedComment();
            $content = include(ROOT.'/views/admin/comments/moderation.php');
        require_once (ROOT.'/views/admin/index.php');
        return true;
        }

        public function actionCommentsEdit() {
            $countComment = (int)Comments::getCountAllComments()[0];
            $page=0; $offset=0;
            $paginator=null;
            if (isset($params[2])) $page=(int)$params[2];
            else $page=0;
            if ($page)
                $offset = ($page-1)*20;
            else $offset = 0;
            $commentList = Comments::getAllComment(20, $offset);
            $countPages = ceil($countComment/20);
            //По количеству комментариев определяем нужен ли пагинатор.
            if ($countPages>1) $paginator = new Paginator();
            $content = include(ROOT.'/views/admin/comments/edit.php');
            require_once (ROOT.'/views/admin/index.php');
            return true;
        }

        public function actionCommentsAdd() {
            $newsList=array();
            $newsList = News::getNewsList();

            $content = include(ROOT.'/views/admin/comments/add.php');
            require_once (ROOT.'/views/admin/index.php');
            return true;
        }

    public function actionRb($params=null) {
        $message = ''; //Список рекламных блоков, с возможностью удалить их
        $products = Products::getProducts('A',0);
        $ca=count($products);
        $content = include(ROOT . '/views/admin/rb/activate.php');
        require_once (ROOT.'/views/admin/index.php');
        return true;
    }

    public function actionRbStatus($params=null) {
        // id рекламного блока
        if (isset($_POST['rbId']) && isset($_POST['status'])) {
            $rbId=abs((int)$_POST['rbId']);
            $status=abs((int)$_POST['status']); // статус отображения рекламного блока: 1-показывать, 0-не показывать
            if ($rbId) {
                $result=Products::setStatusProduct($rbId,$status);
            } else $result='Error. Status has not been change.';
        } else $result='Error. Input data incorrect.';
        var_dump($result);
    return $result;
    }

    public function actionRbAdd($params = null) {
        $message = '';
        //Если была отправка формы
        if (count($_POST)) { //разгребаем входные данные для запроса в базу

            if (isset($_POST['active'])) $active=1; //отобразить ли товар сразу на сайте
            else $active=0;

            // Название товара
            if (isset($_POST['productName'])) {
                $productName=trim($_POST['productName']);
            } else $productName='';

            // Цена товара
            if (isset($_POST['price'])) {
                $price=abs((int)$_POST['price']);
            } else $price=0;

            // Продавец
            if (isset($_POST['seller'])) {
                $seller=trim($_POST['seller']);
            } else $seller='';

            // Боковая сторона
            if (isset($_POST['side'])) {
                $side=trim($_POST['side']);
            } else $side='';

            if (strlen($productName) && strlen($seller) && $price && strlen($side)) {
                $addedRB=Products::addProduct($productName, $price, $seller, $side, 'default.jpg', $active);
                //var_dump($addedRB);
                if ($addedRB) {
                    $message.= '<p class="message-ok">Рекламный продукт добавлен. id:'.$addedRB.'. </p>';
                    if(isset($_FILES['file'])) {
                        // проверяем, можно ли загружать изображение
                        $check = News::can_upload($_FILES['file']);

                        if (!strlen($check)) $message.="<strong>Файл не выбран.</strong>";
                        elseif (strlen($check)<=4) {

                            // загружаем изображение на сервер
                            $fileName = 'rb'.$addedRB.'.'.$check;
                            News::make_upload($_FILES['file'],ROOT.'/resources/images/sidebar/'.$fileName);
                            $message.= "<strong>Файл успешно загружен!</strong>";
                            $photo=Products::addPhoto($addedRB,$fileName);
                        } else $message.= "<strong>".$check."</strong>";
                    }
                }
                else $message.= '<p class="message-error">Рекламный продукт не был добавлен. Проверьте входные данные</p>';
                //если файлы выбраны

            } else  $message.= '<p class="message-error">Реклама добавлена не была. Проверьте входные данные</p>';

        }
//header("Cache-Control: no-store,no-cache,mustrevalidate");
//header("Location: ".ROOT."/admin/news/add");
        $content = include(ROOT . '/views/admin/rb/add.php');
        require_once (ROOT.'/views/admin/index.php');
        return true;
    }

    public function actionMenu($params = null) {
        $message='';
        $menuArray=Config::getMenu();
        $content = include(ROOT . '/views/admin/menu.php');
        require_once (ROOT.'/views/admin/index.php');
        return true;
    }

    /** Управление фоном страниц и меню */
    public function actionBackground($params = null) {
        $message='';
        if(isset($_FILES['file'])) { /** Если файл был отправлен */
            // проверяем, можно ли загружать изображение
            $check = News::can_upload($_FILES['file']);

            if (!strlen($check)) $message.="<strong>Файл не выбран.</strong>";
            elseif (strlen($check)<=4) {

                // загружаем изображение на сервер
                $fileName = '/resources/images/backgrounds/custombg.'.$check;
                News::make_upload($_FILES['file'],ROOT.$fileName);
                $message.= "<p class='message-ok'><strong>Файл успешно загружен!</strong> ";
                $dbwr = Config::setBgImg($fileName);
                $message.= $dbwr.' </p>';

            } else $message.= "<p class='message-error'> <strong>".$check."</strong> </p>";
        }
        $content = include(ROOT . '/views/admin/bg.php');
        require_once (ROOT.'/views/admin/index.php');
        return true;
    }

    /** устанавливаем картинку фона страниц дефолтной */
    public function actionDefBg() {
        if ($_SESSION['admin_id']) {
            $res = Config::setBgImg('/resources/images/stock-textures.jpg');
            if ($res)
                echo $res;
        } else echo "Только авторизированные админы могут фон картинки менять. А ты кто такой?";
        return true;
    }

    /** устанавливаем цвет фона хедера */
    public function actionHbg() {
        if ($_SESSION['admin_id'] && isset($_POST['hcolor'])) {
            $res = Config::setHBg($_POST['hcolor']);
            if ($res)
                echo $res;
        } else echo "Только авторизированные админы могут фон картинки менять. А ты кто такой?";
        return true;
    }

    public function actionAddMenuItem() {
        if (isset($_POST['sub_item'])) $subItem=abs((int)$_POST['sub_item']);
        $menuItem = $_POST['menu_item'];
        $link = $_POST['link'];
        if (strlen($menuItem) && strlen($link)) {
            $addResult = Config::addMenuItem($subItem, $menuItem, $link);
        }
        else $addResult = 0;
        echo $addResult;
    }

    public function actionUpdateMenuItem() {
        if (isset($_POST['mId'])) $mId=abs((int)$_POST['mId']);
        $menuItem = $_POST['menu_item'];
        $link = $_POST['link'];
        if (strlen($menuItem) && strlen($link)) {
            $addResult = Config::updateMenuItem($mId, $menuItem, $link);
        }
        else $addResult = 0;
        echo $addResult;
    }

    public function actionDeleteFile() {
        if (isset($_POST['fileName'])) $fileName=$_POST['fileName'];
        $resDel = News::dellFile($fileName);
        echo $resDel;
    }

    public function actionDelMenuItems() {
        var_dump($items=$_POST['mId']);
        if (isset($items)) {
            echo $res=Config::deleteMenuItems($items);
        } else echo "not correct parameters";
    }

    public function actionManageTags($params=null) {
        $newsId=(int)$params[2];
        $tagList=Tag::getTagsByNewsId($newsId);
        $message='';
        $content = include(ROOT.'/views/admin/news/tag.php');
        require_once (ROOT.'/views/admin/index.php');
        return true;
    }

}
