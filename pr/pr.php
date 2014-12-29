<?php

/**
 * Fonction utilisée pour le débuggage.
 * Formate le résultat différemment en fonction de ce qui est passé en argument (array, object, string, int, boolean, ...)
 * Attention, ne fonctionne pas si la fonction est appelée plusieurs fois sur la même ligne.
 * Voir la doc dans README.md pour plus d'infos
 *
 * @version 1
 */
function pr($o = '', $calledByPh = false) {

    $enableTerminalColor = true;

    $isCli = isCli();
    $isAjax = isAjax();
    $addHtml = !$isCli && (!$isAjax || $calledByPh);
    $addTerminalColor = $enableTerminalColor && $isCli;

    $valueIsObject = is_object($o);
    $valueIsArray = is_array($o);

    $label = '';

    // Récupération du nom de la variable (via la backtrace : un peu crade mais c'est pour du débuggage)
    $bt = debug_backtrace();

    // Si pr est appelée via pa, on récupère le second niveau de la backtrace
    $btIndex = $calledByPh ? 1 : 0;

    $src = file($bt[$btIndex]['file']);
    $line = $src[$bt[$btIndex]['line'] - 1];

    preg_match('#p[rh]\((.*)\)#', $line, $match);
    $label = $match[1];

    $firstChar = substr($label, 0, 1);

    // Si la fonction a été appelée sans paramètre, on passe juste une ligne
    if ($firstChar === false) {
        // Un <br> en html
        if ($addHtml) {
            echo '<br>';
        }
        // Un \n ailleurs
        else {
            echo "\n";
        }
        return;
    }
    // Sinon, si on a juste passé une chaîne à la fonction, on l'affiche simplement
    else if ($firstChar === '\'' ||  $firstChar === '"') {
        // Un <br> en html
        if ($addHtml) {
            echo "$o<br>";
        }
        // Un \n ailleurs
        else {
            echo "$o\n";
        }
        return;
    }

    // Si on affiche le log dans une page web, on le wrappe dans un <pre>
    if ($addHtml) {
        echo '<pre class="debug-pr" style="color:black;font-family:monospace;" >';
        echo "<strong>$label: </strong>";
    }
    // Sinon, si on doit ajouter des couleurs pour le shell
    else if ($addTerminalColor) {
        echo "\033[1;34m$label:\033[0m ";
    }
    else {
        echo "$label: ";
    }

    // Dans le cas des tableaux ou des objets, on fait un print_r
    if ($valueIsObject || $valueIsArray) {

        // Si c'est un tableau, on affiche en plus le nombre d'éléments
        if ($valueIsArray) {
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
 * Appelle pr en forçant l'HTML
 */
function ph($o = '') {
    pr($o, true);
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
