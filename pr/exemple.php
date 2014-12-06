<?php

require_once('pr.php');

//Booléens
$bool = true;
pr($bool);
pr(false);

//On passe une ligne
pr();

//Entiers / Flottants / String dans des variables
$int = 4;
$float = 1.45;
$string = 'Chaîne de test';
pr($int);
pr($float);
pr($string);

//Entiers / Flottants / String hors variables
pr(4);
pr(1.45);
pr('Chaîne de test');

//Objets et tableaux
$array = array("toast", 15, 28, new DateTime('2012-12-21', new DateTimeZone('Europe/Paris')));
pr($array);

?>
