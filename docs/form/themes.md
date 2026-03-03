# Form Themes

Deux thèmes de formulaires sont auto-enregistrés par le bundle.

---

## shadcn.html.twig

Thème global inspiré de [shadcn/ui](https://ui.shadcn.com/). S'applique automatiquement à **tous les formulaires Symfony** du projet.

### Blocs implémentés

| Bloc | Élément | Classes principales |
|------|---------|-------------------|
| `form_widget_simple` | `<input>` (texte, email, number, password…) | `h-10 rounded-md border border-input bg-background px-3 py-2 text-sm` |
| `textarea_widget` | `<textarea>` | `min-h-[80px] rounded-md border border-input bg-background px-3 py-2 text-sm` |
| `choice_widget_collapsed` | `<select>` | `h-10 rounded-md border border-input bg-background` |
| `checkbox_widget` | `<input type="checkbox">` | `size-4 accent-primary rounded` |
| `radio_widget` | `<input type="radio">` | `size-4 accent-primary` |
| `file_widget` | `<input type="file">` | Styling du bouton natif + zone drop |
| `form_label` | `<label>` | `text-sm font-medium leading-none` + astérisque `*` si `required` |
| `form_errors` | `<div role="alert">` | `text-destructive text-sm` — liste si plusieurs erreurs |
| `form_help` | `<p>` | `text-muted-foreground text-sm` |
| `form_row` | `<div>` | `space-y-2` — ordre : label, widget, help, erreurs |
| `checkbox_row` | `<div>` | `flex items-start gap-2` — checkbox à gauche, label + help à droite |
| `button_widget` | `<button>` | `bg-primary text-primary-foreground h-10 px-4 py-2 rounded-md` |
| `submit_widget` | `<button type="submit">` | Délègue à `button_widget` |
| `choice_widget_expanded` | Groupe radio/checkbox | `flex items-center gap-2` par option |

### États d'erreur

Quand un champ a des erreurs (`errors|length > 0`), les classes suivantes sont ajoutées automatiquement :

```
border-destructive focus-visible:ring-destructive
```

### Personnaliser les classes d'un champ

Passer `attr.class` dans l'option du champ — les classes sont **ajoutées** après les classes du thème :

```php
->add('email', EmailType::class, [
    'attr' => ['class' => 'font-mono'],
])
```

---

## toggle_password.html.twig

Thème complémentaire pour les champs mot de passe avec bouton afficher/masquer. Voir [form-types.md](./form-types.md#togglepasswordtypeextension) pour l'utilisation côté PHP.

### Bloc : `toggle_password_widget`

Enveloppe le champ `password` dans un container relatif (pour positionner le bouton en absolu) :

```twig
{%- block toggle_password_widget -%}
    <div class="{{ toggle_container_classes|join(' ') }}">
        {{- block('password_widget') -}}
    </div>
{%- endblock -%}
```

Classes par défaut du container : `relative w-full`.

Le bouton œil est injecté **côté JS** par le Stimulus controller `toggle-password` — il n'est pas dans le HTML serveur.

### Ordre d'application des thèmes

Symfony applique les thèmes **du dernier au premier** dans la liste. L'ordre d'enregistrement est :

1. `shadcn.html.twig` — thème de base
2. `toggle_password.html.twig` — surcharge uniquement `toggle_password_widget`

Le bloc `toggle_password_widget` est inséré avant le dernier élément de `block_prefixes` du champ (`TogglePasswordTypeExtension::buildView` le fait via `array_splice`).