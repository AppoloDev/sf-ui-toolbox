# Web Components

---

## `<tom-select>`

**Fichier :** `assets/js/components/tom-select.js`

Web component wrappant la librairie [TomSelect](https://tom-select.github.io/). Gère aussi bien la sélection simple que la sélection multiple, avec plugins optionnels.

### Import

```js
import '../../../vendor/appolodev/sf-ui-toolbox/assets/js/components/tom-select.js'
```

### Attributs HTML

| Attribut | Type | Défaut | Description |
|----------|------|--------|-------------|
| `options` | JSON | `{}` | Configuration TomSelect (voir ci-dessous) |
| `addText` | `string` | `'Ajouter'` | Texte du bouton "créer" |
| `noMatchText` | `string` | `'Aucun résultat'` | Texte si aucun résultat |

### Options TomSelect (via attribut `options`)

| Clé | Type | Défaut | Description |
|-----|------|--------|-------------|
| `maxItems` | `number\|null` | `1` | `1` = sélection simple, `null` = illimité |
| `maxItemsCount` | `number\|null` | `null` | Nombre max d'items affichés dans le contrôle avant badge "+N" |
| `options` | `array\|object` | `[]` | Options disponibles (tableau de strings ou `{value: label}`) |
| `create` | `bool` | `false` | Autoriser la création de nouvelles valeurs |
| `plugins` | — | auto | Voir ci-dessous |

### Plugins activés automatiquement

| Plugin | Condition | Comportement |
|--------|-----------|--------------|
| `dropdown_input` | Toujours | Champ de recherche dans le dropdown |
| `remove_button` | `maxItems > 1` ou null | Bouton ✕ sur chaque item sélectionné |
| `checkbox_options` | `maxItems > 1` ou null | Checkboxes dans le dropdown (multi-select) |
| `maxItemPlugin` | `maxItemsCount` défini | Cache les items au-delà du count, affiche badge "+N" |

### Exemples

**Sélection simple (choix parmi une liste) :**

```twig
{# Dans un template Twig #}
<tom-select>
    <select name="country">
        <option value="">Choisir un pays</option>
        <option value="fr">France</option>
        <option value="be">Belgique</option>
    </select>
</tom-select>
```

**Sélection multiple avec badge :**

```twig
<tom-select options='{"maxItems": null, "maxItemsCount": 2}'>
    <select name="tags[]" multiple>
        <option value="php">PHP</option>
        <option value="symfony">Symfony</option>
        <option value="react">React</option>
    </select>
</tom-select>
```

**Avec valeurs dynamiques :**

```twig
<tom-select options='{{ {maxItems: null, options: choices}|json_encode }}'>
    <input type="text" name="items" value="{{ values|join(',') }}">
</tom-select>
```

### CSS requis

```js
@import '../../../vendor/appolodev/sf-ui-toolbox/assets/css/tom-select.css';
```

Le fichier CSS reset les styles de `.ts-wrapper` pour éviter la double bordure (TomSelect copie les classes CSS de l'input original vers `.ts-wrapper` par design).

### Compatibilité avec les FormTypes Symfony

Avec `TomSelectType` / `EntityTomSelectType`, le template de formulaire génère automatiquement le markup `<tom-select>` avec les bonnes options. Pas besoin d'écrire le HTML manuellement.

---

## Plugin `maxItemPlugin`

**Fichier :** `assets/js/components/plugins/max-items.js`

Plugin interne pour TomSelect. Masque les items sélectionnés au-delà d'un seuil et affiche un badge "+N élément(s)".

### Configuration

```js
// Automatiquement activé si maxItemsCount est défini dans les options TomSelect
{
    maxItemsCount: 2  // Affiche max 2 items, le reste en badge
}
```

**Comportement responsive :** Sur écrans ≤ 1366px, seul 1 item est affiché (le reste en badge), quelle que soit la valeur de `maxItemsCount`.

### Événements écoutés

- `item_add` : Met à jour le badge après ajout
- `item_remove` : Met à jour le badge après suppression