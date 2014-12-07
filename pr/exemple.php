<?php

require_once('pr.php');

// Booléens
$bool = true;
pr($bool);
pr(false);

// Entiers / Flottants
$int = 4;
$float = 1.45;
pr($int);
pr($float);
pr(42);
pr(1.41421356237);

// Chaînes de caractères
$string = 'test';
pr($string);
pr("Autre chaîne de $string");

// On passe une ligne
pr();

//Objets et tableaux
$date = new DateTime('2012-12-21', new DateTimeZone('Europe/Paris'));
$array = array($string, $int, $float, $date);
pr($date);
pr($array);

?>
