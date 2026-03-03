# Form Types & Extensions

---

## TogglePasswordTypeExtension

**Namespace :** `AppoloDev\SFUIToolboxBundle\Form\Extension`
**Fichier :** `src/Form/Extension/TogglePasswordTypeExtension.php`
**Étend :** `PasswordType`

Extension qui ajoute un bouton afficher/masquer à tout champ `PasswordType`.
Auto-découvert via `autoconfigure: true` dans `services.yaml`.

### Options

| Option | Type | Défaut | Description |
|--------|------|--------|-------------|
| `toggle` | `bool` | `false` | Active le toggle. **Doit être `true`** pour que l'extension agisse. |
| `hidden_label` | `string\|TranslatableMessage\|null` | `null` | Label du bouton quand le mot de passe est masqué |
| `visible_label` | `string\|TranslatableMessage\|null` | `null` | Label du bouton quand le mot de passe est visible |
| `hidden_icon` | `string\|null` | `'Default'` | Nom d'icône quand masqué (réservé pour personnalisation) |
| `visible_icon` | `string\|null` | `'Default'` | Nom d'icône quand visible |
| `button_classes` | `string[]` | Voir ci-dessous | Classes Tailwind du bouton toggle |
| `toggle_container_classes` | `string[]` | `['relative', 'w-full']` | Classes du div wrapper |
| `toggle_translation_domain` | `string\|bool\|null` | `null` | Domaine de traduction pour les labels |

**Classes par défaut du bouton :**
```php
[
    'absolute', 'inset-y-0', 'right-0', 'flex', 'items-center',
    'pr-3', 'text-muted-foreground', 'hover:text-foreground',
    'focus:outline-none',
]
```

### Usage

```php
// src/Form/Auth/LoginType.php
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

$builder->add('password', PasswordType::class, [
    'toggle' => true,
]);
```

Avec labels personnalisés :

```php
$builder->add('password', PasswordType::class, [
    'toggle'        => true,
    'hidden_label'  => 'Afficher',
    'visible_label' => 'Masquer',
]);
```

Avec conteneur et bouton personnalisés :

```php
$builder->add('password', PasswordType::class, [
    'toggle'                  => true,
    'toggle_container_classes' => ['relative', 'w-full', 'max-w-sm'],
    'button_classes'           => ['absolute', 'right-2', 'top-2', 'text-gray-500'],
]);
```

### Fonctionnement interne

`buildView()` :
1. Vérifie que `toggle === true` — sinon ne fait rien.
2. Insère `toggle_password` dans `$view->vars['block_prefixes']` juste avant le dernier élément, déclenchant le bloc `toggle_password_widget` du form theme.
3. Ajoute `data-controller="toggle-password"` sur l'`<input>` (via `attr`).
4. Passe toutes les options comme data attributes :
   - `data-toggle-password-hidden-label-value`
   - `data-toggle-password-visible-label-value`
   - `data-toggle-password-hidden-icon-value`
   - `data-toggle-password-visible-icon-value`
   - `data-toggle-password-button-classes-value` (JSON)

Le bouton HTML est créé et inséré **côté client** par le Stimulus controller `toggle-password`.

---

## TomSelectType

**Namespace :** `AppoloDev\SFToolboxBundle\Form\FormType`
*(Fait partie de `appolodev/sf-toolbox`, le bundle backend complémentaire)*

`FormType` pour une liste de choix libres (valeurs saisies manuellement, pas liées à Doctrine).

### Options

| Option | Type | Défaut | Description |
|--------|------|--------|-------------|
| `configuration` | `array` | `[]` | Options passées au web component `<tom-select>` |
| `multiple` | `bool` | `false` | Activer la sélection multiple |
| `choices` | `array` | `[]` | Options disponibles (tableau simple ou clé/valeur) |

### Usage

```php
use AppoloDev\SFToolboxBundle\Form\FormType\TomSelectType;

$builder->add('tags', TomSelectType::class, [
    'multiple'      => true,
    'choices'       => ['PHP', 'Symfony', 'Twig', 'TypeScript'],
    'configuration' => ['maxItems' => 5],
]);
```

**Comportement multiple :** Quand `multiple: true`, un `StringToArrayTransformer` est ajouté — la valeur soumise est une chaîne `"a,b,c"` transformée en `['a', 'b', 'c']`.

### Template associé

Le block prefix est `tom_select` → le template du projet doit fournir un bloc `tom_select_widget` (ou utiliser celui fourni via `appolodev/sf-toolbox`).

---

## EntityTomSelectType

**Namespace :** `AppoloDev\SFToolboxBundle\Form\FormType`

Idem `TomSelectType` mais étend `EntityType` (Doctrine). Utilisé pour des relations liées à des entités.

```php
use AppoloDev\SFToolboxBundle\Form\FormType\EntityTomSelectType;

$builder->add('category', EntityTomSelectType::class, [
    'class'         => Category::class,
    'choice_label'  => 'name',
    'multiple'      => false,
    'configuration' => [],
]);
```

Les options `class`, `choice_label`, `query_builder` etc. sont celles d'`EntityType` standard. `configuration` est passé au web component `<tom-select>`.