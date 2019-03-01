<?php
//В этом файле, в массиве $sidebar, хранится верстка левого и правого сайдбара с рекламами -
//Соответственно по индексам массива 'left' и 'right'.
$productsLeft=Products::getProducts('L');
$productsRight=Products::getProducts('R');
$cl=count($productsLeft);
$cr=count($productsRight);
$reclama = array();
$reclama['left'] = $reclama['right'] ='';

for ($i=0;$i<$cl;$i++) {
    $reclama['left'] .='
    <div id="reclama'.$i.'" class="sidebar" data-toggle="tooltip" data-placement="top" title="Купон на скидку '.
        $productsLeft[$i]['promocode'].' - примените и получите скидку 10%">
    <img src="/resources/images/sidebar/'.$productsLeft[$i]['photo'].'" class="rbimg"
    alt="'.$productsLeft[$i]['productName'].'" /><br>
        '.$productsLeft[$i]['productName'].' - <span id="treclama'.$i.'">'.$productsLeft[$i]['price'].'</span>грн. 
        Купить в <span class="seller">'.$productsLeft[$i]['seller'].'</span></div>
';
}

for ($i=0;$i<$cr;$i++) {
    $reclama['right'] .='
    <div id="reclama'.$productsRight[$i]['id'].'" class="sidebar" data-toggle="tooltip" data-placement="top" title="Купон на скидку '.
        $productsRight[$i]['promocode'].' - примените и получите скидку 10%">
    <img src="/resources/images/sidebar/'.$productsRight[$i]['photo'].'" class="rbimg" 
    alt="'.$productsRight[$i]['productName'].'" /><br>
        '.$productsRight[$i]['productName'].' - <span id="treclama'.$productsRight[$i]['id'].'">'.$productsRight[$i]['price'].'</span>грн. 
        Купить в <span class="seller">'.$productsRight[$i]['seller'].'</span></div>
';
}

return $reclama;