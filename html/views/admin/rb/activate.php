<script src="/resources/js/admin/rb.js"></script>
<?php
$content = 'Админка. Раздел рекламных блоков.<br/>
Рекламные блоки левого сайдбара:<br/>';
$content .= '<table><tr><td>id</td><td>Фото</td><td>Название товара</td><td>Продавец</td>
<td>Цена</td><td>L/R</td><td>Отображается</td></tr>';
for ($i=0;$i<$ca;$i++) { // activate button
    $ab=($products[$i]['active']) ? 'Отображается.
<br/><img src="/resources/images/admin/mod.png" class="redcom"
 onclick="setStatusProduct('.$products[$i]['id'].',0)">' :

'Не отображается.<br/><img src="/resources/images/admin/notmod.png" class="redcom"
 onclick="setStatusProduct('.$products[$i]['id'].',1)">';
    $content .= '<tr><td>'.$products[$i]['id'].'</td>
    <td><img src="/resources/images/sidebar/'.$products[$i]['photo'].'" class="rbimg1"></td>
    <td>'.$products[$i]['productName'].'</td>
    <td>'.$products[$i]['seller'].'</td>
    <td>'.$products[$i]['price'].'</td>
    <td>'.$products[$i]['side'].'</td>
    <td>'.$ab.'</td>
</tr>';
}
$content .= '</table>';

return $content;