<?php
include_once ROOT.'/models/Comments.php';
//include_once ROOT.'/models/Products.php';

class AaController {
    public function actionAa() {
       // Comments::zapoltiaha();
        //News::dateInserta();
        //$a=Cathegories::addCathegory('спорт', 'djgur');
        //$a=Products::getProducts();
        //$a=Config::getMenu();
        //var_dump($a); echo "<br/><br/>";
        //var_dump($a['subIndexes']); echo "<br/><br/>";
        //if (in_array(13,$a['subIndexes'])) echo 'ddddddddd<br/>';
	$a=Config::Jest();
	var_dump($a);
      }
}