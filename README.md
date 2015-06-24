# Fonction `pr()`

Cette fonction globale permet d'afficher des variables dans une page ou en ligne de commande. C'est un genre de mix entre `pr` et `var_dump`.
La fonction permet d'afficher le nom de la variable dumpée juste avant sa valeur.
Le code n'est pas très propre (par exemple, il est impossible d'appeler deux fois la fonction sur la même ligne) mais pour du débuggage, ça fait le job.

## Utilisation et exemples

*Tous les exemples ci-dessous apparaissent dans [le fichier d'exemple](examples/examples.php)*

### Afficher la valeur d'une expression

`pr` affiche l'expression passée en paramètre avant sa valeur.

*Exemple :*

```php
$maChaine = 'test';
pr($maChaine);
```

*Sortie :*

```
$maChaine: string(4) "test"
```


---

### Afficher un tableau ou un objet

Les objets et tableaux sont affichés avec la fonction `print_r`.
Dans le cas des tableaux, `pr` affiche le nombre d'éléments du tableau avant celui-ci.

*Exemple :*

```php
$myObject = new DateTime('2012-12-21', new DateTimeZone('Europe/Paris'));
$myArray = array('test', 4, 1.45, $myObject);
pr($myArray);
```

*Sortie :*

```
$myArray: {4} Array
(
    [0] => test
    [1] => 4
    [2] => 1.45
    [3] => DateTime Object
        (
            [date] => 2012-12-21 00:00:00
            [timezone_type] => 3
            [timezone] => Europe/Paris
        )
)
```

---

### Afficher une simple chaîne de caractères

Pour faciliter le debuggage, si une chaîne de caractères est passée à la fonction, celle-ci est affichée simplement.
Ces deux lignes sont donc équivalentes :

```php
pr('ma chaîne de caractères');
echo "ma chaîne de caractères\n";
```

*Sortie :*

```
ma chaîne de caractères
```

---

### Passer simplement à la ligne

Parfois, il peut être intéressant de séparer plusieurs groupes de `pr` (par exemple, pour afficher des groupes de valeurs dans une boucle et conserver une certaine lisibilité).

Ceci peut être fait simplement en appelant `pr` sans lui passer de paramètre.

---

### Les différents formats de sorties

En fonction du contexte d'appel de la fonction, le format de sortie de `pr` est différent.
Aperçu de la sortie avec un des exemples ci-dessus :

- __Depuis un appel AJAX__

La sortie est simple pour ne pas encombrer l'affichage dans l'onglet "Réseau" du navigateur.

![Sortie AJAX](http://www.dorian-marchal.com/assets/ajax-output.png)

- __Depuis la ligne de commande__

Des couleurs sont ajoutées pour mieux séparer le label de la valeur.

![Sortie Terminal](http://www.dorian-marchal.com/assets/terminal-output.png)

- __Tous les autres appels (sortie HTML)__

La sortie est wrappée dans une balise `pre` pour conserver l'indentation de `print_r`. De plus, la classe `.debug-pr` permet de styliser les logs en CSS.

![Sortie HTML](http://www.dorian-marchal.com/assets/html-output.png)

---
