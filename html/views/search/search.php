<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Расширенный поиск по сайту.</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Новости.</title>
    <link rel="stylesheet" href="/resources/css/search.css" type="text/css" >
    <link rel="stylesheet" href="/resources/css/news.css" type="text/css" >
    <link rel="stylesheet" href="/resources/css/menu.css" type="text/css" >
    <link rel="stylesheet" href="/resources/css/paginator.css" type="text/css" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
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

            <div id="searchFilter">

                <form action="/search/searchonsite" method="POST">

                    <div class="searchFilter">
                        <?php
                        $c=count($cathegories);
                        $s = ($c>=8) ? 8 : $c ?>
                        Категории новостей:<br />
                        <select multiple="multiple" size="<?php echo $s; ?>" name="cathegories[]">
                            <?php
                            for ($i=0; $i<$c; $i++) {
                                echo '<option>'.$cathegories[$i]['cath_ru'].'</option>';
                            }
                            ?>
                        </select></div>

                    <div class="searchFilter">Теги новостей:</br>
                <select multiple="multiple" size="8" name="tags[]">
                    <?php
                    for ($i=0;$i<count($allTags);$i++) {
                        echo '<option>'.$allTags[$i].'</option>';
                    }
                    ?>
                </select></div>

                    <div class="searchFilter1">
                        Период публикации.</br>
                        От:<input type="date" name="date_begin"></br>
                        До:<input type="date" name="date_end"></br></div><br/>

                    <input type=submit value="Искать" id="goSearch">
                </form>
            </div>

            <?php //if (isset($filter)) { var_dump($filter); echo "</br>"; }

            if (!isset($searchResult['message'])) {
                $cr=count($searchResult);
                for ($i=0;$i<$cr;$i++) {
                    echo '<p><a href="/news/'.$searchResult[$i]['id'].'">'.$searchResult[$i]['theme'].'</a><br/>
<span class="sRAttr"> 
            '.$searchResult[$i]['publicDate'].'. Категория: '.$searchResult[$i]['cathegory'];
                    if ($searchResult[$i]['isanalytic']) echo ' (А)';
                    echo '</span></p>';
                }
                //var_dump ($searchResult);
            }
            else echo $searchResult['message'].". <br/>";
            ?>
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