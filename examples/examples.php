<?php

require_once dirname(__FILE__) . '/../pr.php';

// Booléens
$bool = true;
pr($bool);
pr(true && false);

// Entiers / Flottants
$int = 4;
$float = 1.45;
pr($int);
pr($float);

// Chaînes de caractères
$maChaine = 'test';
pr($maChaine);

// On passe une ligne
pr();

// Chaîne simple (non wrappée dans une expression)
pr("Chaîne de $maChaine sans variable");

pr();

// Avec une fonction
function fonctionDeTest($e) {
    return $e;
}
pr(fonctionDeTest("fonction"));

// Concaténation et somme
pr(fonctionDeTest("debut") . ' ' . $maChaine);
pr($int + $float);

pr();

// Deux appels sur une seule ligne
$deux = 'deux appels sur une même ligne';
$aie = 'ça fonctionne mal, le label n\'est pas le bon !';
pr($deux);pr($aie);

pr();

//Objets et tableaux
$myObject = new DateTime('2012-12-21', new DateTimeZone('Europe/Paris'));
$myArray = array($maChaine, $int, $float, $myObject);
pr($myObject);
pr($myArray);

// Exemple avec la fonction ph (affichera de l'html, même via un appel AJAX)
ph($maChaine);
?>
