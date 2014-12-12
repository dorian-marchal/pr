# Fonction `pr()`

Attention, à ne pas utiliser en production !

Cette fonction globale permet d'afficher des variables dans une page ou en ligne de commande. C'est un genre de mix entre `pr` et `var_dump`.
La fonction permet d'afficher le nom de la variable dumpée juste avant sa valeur.
Le code n'est pas très propre (par exemple, il est impossible d'appeler deux fois la fonction sur la même ligne) mais pour du débuggage, ça fait le job.

## Utilisation et exemples

*Tous les exemples ci-dessous apparaissent dans [le fichier d'exemple](exemple.php)*

### Afficher la valeur d'une expression

`pr` affiche l'expression passée en paramètre avant sa valeur.

*Exemple :*

```php
$maChaine = 'test';
pr($maChaine);
```

*Sortie :*

> __$maChaine:__ string(4) "test"


---

### Afficher un tableau ou un objet

Les objets et tableaux sont affichés avec la fonction `print_r`.
Dans le cas des tableaux, `pr` affiche le nombre d'éléments du tableau avant celui-ci.

---

### Afficher une simple chaîne de caractères

Pour faciliter le debuggage, si une chaîne de caractères est passée à la fonction, celle-ci est affichée simplement.
Ces deux lignes sont donc équivalentes :

```c
pr('ma chaîne de caractères');
echo "ma chaîne de caractères\n";
```


---

### Passer simplement à la ligne

Parfois, il peut être intéressant de séparer plusieurs groupes de `pr` (par exemple, pour afficher des groupes de valeurs dans une boucle et conserver une certaine lisibilité).

Ceci peut être fait simplement en appelant `pr` sans paramètre.

---

### Les différents formats de sorties

En fonction du contexte d'appel de la fonction, le format de sortie de `pr` est différent.
Aperçu de la sortie avec un des exemples ci-dessus :

- Depuis un appel AJAX
- Depuis la ligne de commande
- Tous les autres appels (sortie HTML)

---
