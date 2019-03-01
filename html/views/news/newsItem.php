<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Новости.</title>
    <link rel="stylesheet" href="/resources/css/news.css" type="text/css" >
    <link rel="stylesheet" href="/resources/css/menu.css" type="text/css" >
    <link rel="stylesheet" href="/resources/css/slider.css" type="text/css" >
    <link rel="stylesheet" href="/resources/css/paginator.css" type="text/css" >
    <link rel="stylesheet" href="/resources/css/comments.css" type="text/css" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="/resources/js/slider.js"></script>
    <script src="/resources/js/newsItem.js"></script>
    <script src="/resources/js/searchTag.js"></script>
    <script src="/resources/js/signIn.js"></script>
    <script src="/resources/js/paginator.js"></script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="/resources/js/recl.js"></script>

</head>
<body style="background-image: url(<?php echo BGBODY; ?>);">

<header id = "menucontainer" style="background-color: <?php echo BGHEAD; ?>;">
    <?php
    //Меню сделано в отдельном файле menu.php
    //Его и подключаем и содержимое выводим
    $menu = include(ROOT . '/components/menu1.php');

    //if (isset($_SESSION)) var_dump($_SESSION); echo "<br>";
    echo $menu;
    ?>
</header>

<table cellspacing="0" cellpadding="4" class="main">
    <tr>
        <td width="208">
            <?php
            //Рекламы левого и правого сайдбара хранятся в массиве, в файле sidebar.php
            $reclama = include(ROOT . '/components/reclama.php');
            echo $reclama['left'];
            ?>
        </td>

        <td>
            <div class="slider-container">
                <?php
                $slider = include(ROOT.'/components/slider.php');
                echo $slider;
                //<center>БАННЕРЫ</center>
                ?>
            </div>

            <div class="newsItem">
            <?php
            //Отображаем конкретную новость по её id
            if ($newsId) {
                if ($newsItem['id']) {
                    echo "<p class = 'newsCath'>Новость категории <b>".$newsItem['cathegory']."</b></br>";
                    if ($newsItem['isanalytic']) {
                        echo 'Аналитическая статья. </br></p>';
                    }
                    echo "<h2>".$newsItem['theme']."</h2>";

                    $sentences = explode('.',nl2br($newsItem['text']));
                    if (!isset($_SESSION['id']) && $newsItem['isanalytic'])
                    { echo "<p>";
                        for ($i=0;$i<5;$i++)
                            echo $sentences[$i].". ";
                        echo "</br><font color='#FFA500'>
Для просмотра полного контента аналитической статьи, пожалуйста авторизируйтесь.</font>";
                        echo "</p>";
                    }
                    else echo "<p>".nl2br($newsItem['text'])."</p>";

                    //Выводим изображения новости. Берем их в контроллере.
                    $countPictures = count($newsItem['pictures']);
                    for ($i=0;$i<$countPictures;$i++) {
                        echo '<p class = "newsImgconteiner">
                <img src = "/resources/images/news/'.$newsItem['pictures'][$i].'" class = newsImg></p>';
                    }

                    //Количество читающих сейчас новость
                    echo "<script>var newsId = ".$newsId.";</script>";
                    echo "<div id='readNow'>Эту новость сейчас читают: <b>"
                        .$readNow."</b> посетителей.</div>";
                    echo "<div id='readAll'>Её уже прочитали:<b>".$readAll."</b>.</div>";

                    //Список тегов по новости
                    //var_dump($tagList);
                    echo "<p>Список тегов данной новости: ";
                    if ($tagList[0]) { //var_dump($tagList);
                        for ($i=0;$i<count($tagList);$i++) {
                            echo "<a href='/tag/?tag=".$tagList[$i]."'>".$tagList[$i]."</a>";
                            if ($i<(count($tagList)-1)) echo ", ";
                            else echo ".";
                        }
                    }
                    else echo "нету тегов. Кто-то их поленился добавить.";
                    echo "</p>";

                    //Комментарии к новости:
                    $comments = include(ROOT.'/components/comments.php');
                    //echo $comments;
                }
                else $comments = "Нету такой новости. ERROR 404!<br>";

            } else $comments = "Нету такой новости. ERROR 404!<br>";
            echo $comments;
            ?></div>
        </td>

        <td width="208">
            <?php
            //Рекламы правого сайдбара (как и левого) берем из массива $sidebar в файле sidebar.php
            //Этот файл подключен в колонке левого сайдбара.
            echo $reclama['right'];
            ?>
        </td>
    </tr>
</table>
</body>
</html>