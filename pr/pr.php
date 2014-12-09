<?php

/**
 * Fonction utilisée pour le débuggage.
 * Formate le résultat différemment en fonction de ce qui est passé en argument (array, object, string, int, boolean, ...)
 * Attention, ne fonctionne pas si la fonction est appelée plusieurs fois sur la même ligne.
 * Voir la doc dans README.md pour plus d'infos
 *
 * @version 1
 */
function pr($o = '', $val = '!this_is_a_placeholder!') {

    $isCli = isCli();
    $isAjax = isAjax();
    $addHtml = !$isCli && !$isAjax;

    $label = '';

    // Récupération du nom de la variable (via la backtrace : un peu crade mais c'est pour du débuggage)
    if($val === '!this_is_a_placeholder!' && !empty($o)) {

        $bt = debug_backtrace();
        $src = file($bt[0]['file']);
        $line = $src[$bt[0]['line'] - 1];

        preg_match('#pr\((.+)\)#', $line, $match);

        $max = strlen($match[1]);
        $label = '';
        $c = 0;

        // On s'assure que le label a été bien parsé
        for ($i = 0; $i < $max; $i++) {
            if ($match[1][$i] === '(') {
                $c++;
            }
            else if ($match[1][$i] === ')') {
                $c--;
            }
            if ($c < 0) {
                break;
            }
            $label .=  $match[1][$i];
        }
    }

    // Si on a juste passé une chaîne à la fonction, on l'affiche simplement
    $firstChar = substr($label, 0, 1);
    if ($firstChar === false || ($firstChar === '\'' ||  $firstChar === '"')) {
        echo $o . "\n";
        return;
    }

    // Si on affiche le log dans une page web, on le wrappe dans un <pre>
    if ($addHtml) {
        echo '<pre class="debug-pr" style="color:black;font-family:monospace;" >';
        echo "<strong>$label: </strong>";
    }
    else {
        echo "$label: ";
    }

    // Dans le cas des booléens on affiche explicitement 'true' ou 'false'
    if ($o === true || $o === false) {
        echo ($o ? 'true' : 'false') . "\n";
    }
    // Dans le cas des tableaux ou des objets, on fait un print_r
    else if (is_object($o) || is_array($o)) {

        // Si c'est un tableau, on affiche en plus le nombre d'éléments
        if (is_array($o)) {
            echo '{' . count($o) . '} ';
        }

        echo print_r($o, true);
    }
    // Dans tous les autres cas, on fait un var_dump
    else {
        var_dump($o);
    }

    if ($addHtml) {
        echo '</pre>';
    }
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
