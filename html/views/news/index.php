<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Новости.</title>

    <link rel="stylesheet" href="/resources/css/news.css" type="text/css" >
    <link rel="stylesheet" href="/resources/css/slider.css" type="text/css" >
    <link rel="stylesheet" href="/resources/css/menu.css" type="text/css" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="/resources/js/slider.js"></script>
    <script src="/resources/js/searchTag.js"></script>
    <script src="/resources/js/signIn.js"></script>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="/resources/js/recl.js"></script>

</head>
<body style="background-image: url(<?php echo BGBODY; ?>);">
TRa-ta-ta
<div>
    <header id = "menucontainer" style="background-color: <?php echo BGHEAD; ?>;">
    <?php
    //Меню сделано в отдельном файле menu.php
    //Его и подключаем и содержимое выводим
    $menu = include(ROOT . '/components/menu1.php');
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
            <div>
                <?php
                $slider = include(ROOT.'/components/slider.php');
                echo '<br>'.$slider;
                ?>
            </div>

            <?php
            echo "<p><h2>Категории новостей:</h2></p>";
            // Выводим блоки с категориями новостей, а в них - темы новостей в категориях
            // со ссылками на новости по id
            for ($i=0;$i<count($cats);$i++) {
                $cathParam = $cats[$i]['cath_eng'];
                $cathDB = $cats[$i]['cath_ru'];
                ?>
                <div class="newsCath">
                    <h2><a href="/news/<?php echo $cathParam; ?>" class="cathDB"><?php echo"$cathDB"; ?></a></h2>

                    <?php
                    for ($j=0;$j<count($newsList[$cathParam]);$j++) {
                    $title = $newsList[$cathParam][$j]['theme'];
                    ?> <p><a href = "/news/<?php echo $newsList[$cathParam][$j]['id']; ?>"> <?php echo $title.'</a></p>';
                            }
                            ?>
                </div>
                <?php
            }
            /*окончание вывода блоков*/ ?>

            <div id="tp">
                <div id = "top5commentators" class="tops">
                    <?php //ТОП-5 комментаторов
                    echo "<b>ТОП-5 комментаторов: </b></br><table class='top5'><tr><td>Комментатор</td><td>Оставил <br>комментариев</td></tr>";
                    for ($i=1;$i<6;$i++) {
                        echo "<tr><td><a href='/usercomments/".$topCommentators[$i]['userId']."'>
                ".$topCommentators[$i]['commentator']."</a></td><td>
                <a href='/usercomments/".$topCommentators[$i]['userId']."'>".$topCommentators[$i]['count']."</a></td></tr>";
                    }

                    ?> </table></div>
<div id="top3themes" class="tops"><b>ТОП-3 активных темы</b><br>
    <table class='top5'><tr><td>Тема</td><td>Комментариев за <br>последние сутки</td></tr>
        <?php // ТОП-3 активные темы
        for ($i=1;$i<4;$i++) {
            if ($t3c[$i]['count'])
            echo "<tr><td><a href='/news/".$t3c[$i]['id']."'>
                ".$t3c[$i]['theme']."</a></td><td>
                <a href='/news/".$t3c[$i]['id']."'>".$t3c[$i]['count']."</a></td></tr>";
        }
        ?>
    </table>    </div></div>

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