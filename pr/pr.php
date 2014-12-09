<?php

/**
 * Fonction utilisée pour le débuggage.
 * Formate le résultat différemment en fonction de ce qui est passé en argument (array, object, string, int, boolean, ...)
 * Voir la doc dans README.md pour plus d'infos
 *
 * @version 1
 */
function pr($o = '', $val = '!this_is_a_placeholder!') {

    $isCli = isCli();
    $isAjax = isAjax();
    $addHtml = !$isCli && !$isAjax;

    $label = '';

    //Récupération du nom de la variable (via la backtrace : un peu crade mais c'est pour du débuggage)
    if($val === '!this_is_a_placeholder!' && !empty($o)) {

        $bt = debug_backtrace();
        $src = file($bt[0]['file']);
        $line = $src[$bt[0]['line'] - 1];

        preg_match('#pr\((.+)\)#', $line, $match);

        $max = strlen($match[1]);
        $label = '';
        $c = 0;

        for ($i = 0; $i < $max; $i++) {
            if ($match[1]{$i} == '(' ) {
                $c++;
            }
            else if ( $match[1]{$i} == ')' ) {
                $c--;
            }
            if ($c < 0) {
                break;
            }
            $label .=  $match[1]{$i};
        }
    }

    //On présente le log sur une nouvelle ligne
    echo  $addHtml ? '<pre class="debug-pr" style="color:black;font-family:monospace;" >' : '';

    //Si la valeur passée est dans une variable, on affiche le nom de la variable
    if(substr($label, 0, 1) === '$' && !strpos($label, ' ')) {
        echo $addHtml ? "<strong>$label: </strong>" : "$label: ";
    }

    //Dans le cas des booléens le cas est particulier
    if($o === true) {
        echo "true\n";
    }
    else if($o === false) {
        echo  "false\n";
    }
    //Si la valeur à afficher n'est ni un objet, ni un tableau, ni un booléen, on l'affiche tel quelle
    else if(!is_object($o) && !is_array($o)) {

        //Si la valeur n'est pas passée dans une variable, on l'affiche tel quelle, sinon on fait un vardump
        if(substr($label, 0, 1) === '$' && !strpos($label, ' ')) {
            var_dump($o);
        }
        else {
            echo $o . "\n";
        }
    }
    //Si la valeur est un tableau ou un objet, on fait un print_r
    else {

        //Si c'est un tableau, on affiche le nombre d'éléments
        if(is_array($o)) {
            echo '[' . count($o) . '] ';
        }

        echo print_r($o, true);
    }
    echo $addHtml ? '</pre>' : '';
}

/**
 * Retourne true si le script est exécuté depuis la ligne de commande.
 */
function isCli() {
    return php_sapi_name() === 'cli';
}

/**
 * Retourne true si le script est appelé en AJAX
 * /!\ Cette fonction n'est pas sûre.
 */
function isAjax() {

    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

    return $isAjax;
}

?>
