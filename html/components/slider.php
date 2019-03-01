<?php
/**This is html of slider
 *
 */
if (isset($sliderList)) return $slider = '
<div id="block-for-slider">
    <div id="viewport">
        <ul id="slidewrapper">
            <li class="slide"><a href="/news/'.$sliderList[0]["id"].'"><img class="slide-img" src="/resources/images/news/'.
    $sliderList[0]["image"].'"><br>'.$sliderList[0]["theme"].'</a></li>        
            <li class="slide"><a href="/news/'.$sliderList[1]["id"].'"><img class="slide-img" src="/resources/images/news/'.
    $sliderList[1]["image"].'"><br>'.$sliderList[1]["theme"].'</a></li>
            <li class="slide"><a href="/news/'.$sliderList[2]["id"].'"><img class="slide-img" src="/resources/images/news/'.
    $sliderList[2]["image"].'"><br>'.$sliderList[2]["theme"].'</a></li>
            <li class="slide"><a href="/news/'.$sliderList[3]["id"].'"><img class="slide-img" src="/resources/images/news/'.
    $sliderList[3]["image"].'"><br>'.$sliderList[3]["theme"].'</a></li>
        </ul>

        <!--<div id="prev-next-btns">
            <div id="prev-btn"></div>
            <div id="next-btn"></div>
        </div>-->

        <ul id="nav-btns">
            <li class="slide-nav-btn"></li>
            <li class="slide-nav-btn"></li>
            <li class="slide-nav-btn"></li>
            <li class="slide-nav-btn"></li>
        </ul>
    </div>
</div>
'; else return '';
?>
