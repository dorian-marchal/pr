<?php

/**
 * Fonction utilisée pour le débuggage.
 * Formate le résultat différemment en fonction de ce qui est passé en argument (array, object, string, int, boolean, ...)
 * Voir la doc dans README.md pour plus d'infos
 *
 * @version 1
 */
function pr($o = "!this_is_a_placeholder!", $val = "!this_is_an_other_placeholder!") {

    if (php_sapi_name() == "cli") {
        $cli = true;
    } else {
        $cli = false;
    }

    $color = "#000";

    if($o === "!this_is_a_placeholder!") {
        echo $cli ? "\n" : "<br />";
        return;
    }

    //Récupération du nom de la variable (via le backtrace : un peu dégueu mais c'est pour du débuggage)
    if($val == "this_is_an_other_placeholder") {

        $bt = debug_backtrace();
        $src = file($bt[0]["file"]);
        $line = $src[ $bt[0]['line'] - 1 ];

        preg_match( "#pr\((.+)\)#", $line, $match );

        $max = strlen($match[1]);
        $varname = "";
        $c = 0;
        for($i = 0; $i < $max; $i++){
            if(     $match[1]{$i} == "(" ) $c++;
            elseif( $match[1]{$i} == ")" ) $c--;
            if($c < 0) break;
            $varname .=  $match[1]{$i};
        }
        $label = $varname;
    }

    //On présente le log sur une nouvelle ligne
    echo  $cli ? '' : "<pre class='debug-pr' style='position:relative;color:$color;font-family:monospace;' >";

    //Si la valeur passée est dans une variable, on affiche le nom de la variable
    if(substr($label, 0, 1) === '$' && !strpos($label, ' ')) {
        echo $cli ? "$label: " : "<strong>$label: </strong>";
    }

    //Dans le cas des booléens le cas est particulier
    if($o === true) {
        echo 'true';
    }
    else if($o === false) {
        echo  'false';
    }
    //Si la valeur à afficher n'est ni un objet, ni un tableau, ni un booléen, on l'affiche tel quelle
    else if(!is_object($o) && !is_array($o)) {

        //Si la valeur n'est pas passée dans une variable, on l'affiche tel quelle, sinon on fait un vardump
        if(substr($label, 0, 1) === '$' && !strpos($label, ' ')) {
            var_dump($o);
        }
        else {
            echo $o;
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
    echo $cli ? '' : '</pre>';
}
