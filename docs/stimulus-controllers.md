# Stimulus Controllers

Tous les controllers sont dans `assets/js/controllers/` et doivent être importés et enregistrés manuellement dans le bootstrap Stimulus du projet parent (voir [installation.md](./installation.md)).

---

## sidebar

**Fichier :** `assets/js/controllers/sidebar_controller.js`
**Identifier :** `sidebar`

Gère l'ouverture/fermeture de la sidebar sur mobile.

### Targets

| Target | Rôle |
|--------|------|
| `panel` | Le panneau sidebar lui-même |
| `overlay` | L'overlay sombre derrière la sidebar |

### Actions

| Action | Comportement |
|--------|--------------|
| `sidebar#open` | Retire `-translate-x-full` du panel, retire `hidden` de l'overlay |
| `sidebar#close` | Ajoute `-translate-x-full` au panel, ajoute `hidden` à l'overlay |
| `sidebar#toggle` | Bascule entre open et close |

### Exemple HTML

```html
<div data-controller="sidebar">
    <!-- Bouton burger (mobile) -->
    <button data-action="click->sidebar#toggle">☰</button>

    <!-- Overlay -->
    <div data-sidebar-target="overlay" class="hidden fixed inset-0 bg-black/50 z-20"
         data-action="click->sidebar#close"></div>

    <!-- Panel -->
    <aside data-sidebar-target="panel" class="-translate-x-full lg:translate-x-0 transition-transform ...">
        <!-- contenu -->
    </aside>
</div>
```

---

## dropdown

**Fichier :** `assets/js/controllers/dropdown_controller.js`
**Identifier :** `dropdown`

Gère l'affichage d'un menu déroulant avec fermeture au clic extérieur.

### Targets

| Target | Rôle |
|--------|------|
| `menu` | Le menu déroulant |

### Actions

| Action | Comportement |
|--------|--------------|
| `dropdown#toggle` | Bascule la classe `hidden` sur le menu |
| `dropdown#close` | Ajoute `hidden` au menu |
| `dropdown#closeOnClickOutside` | Ferme si l'event target est en dehors de l'élément controller |

### Exemple HTML

```html
<div data-controller="dropdown"
     data-action="click@window->dropdown#closeOnClickOutside">

    <button data-action="click->dropdown#toggle">
        Options
    </button>

    <div data-dropdown-target="menu" class="hidden absolute right-0 top-full ...">
        <a href="#">Action 1</a>
        <a href="#">Action 2</a>
    </div>
</div>
```

---

## dialog

**Fichier :** `assets/js/controllers/dialog_controller.js`
**Identifier :** `dialog`

Gère les modals natives `<dialog>` HTML.

### Targets

| Target | Rôle |
|--------|------|
| `trigger` | Bouton(s) d'ouverture |
| `dialog` | L'élément `<dialog>` natif |

### Actions

| Action | Comportement |
|--------|--------------|
| `dialog#open` | Appelle `dialog.showModal()`, aria-expanded=true |
| `dialog#close` | Appelle `dialog.close()`, aria-expanded=false |
| `dialog#closeOnClickOutside` | Ferme si le clic cible directement `<dialog>` (backdrop) |

**Note :** La fermeture sur `Esc` est gérée nativement par l'élément `<dialog>`.

### Exemple HTML

```html
<div data-controller="dialog">
    <button data-dialog-target="trigger"
            data-action="click->dialog#open">
        Ouvrir la modal
    </button>

    <dialog data-dialog-target="dialog"
            data-action="click->dialog#closeOnClickOutside">
        <div class="p-6">
            <p>Contenu de la modal</p>
            <button data-action="click->dialog#close">Fermer</button>
        </div>
    </dialog>
</div>
```

---

## dismiss

**Fichier :** `assets/js/controllers/dismiss_controller.js`
**Identifier :** `dismiss`

Supprime l'élément controller du DOM. Utilisé pour fermer les toasts.

### Actions

| Action | Comportement |
|--------|--------------|
| `dismiss#dismiss` | Appelle `this.element.remove()` |

### Exemple HTML

```html
<div data-controller="dismiss" class="toast ...">
    <p>Modifications enregistrées.</p>
    <button data-action="click->dismiss#dismiss">✕</button>
</div>
```

---

## toggle-password

**Fichier :** `assets/js/controllers/toggle_password_controller.js`
**Identifier :** `toggle-password`

Ajoute un bouton œil/œil-barré sur un champ password pour afficher/masquer le contenu.

Normalement activé via `TogglePasswordTypeExtension` (option `toggle: true`) — voir [form-types.md](./form-types.md).

### Values

| Value | Type | Défaut | Description |
|-------|------|--------|-------------|
| `hiddenLabel` | `String` | `''` | Label du bouton quand le mot de passe est masqué |
| `visibleLabel` | `String` | `''` | Label quand visible |
| `hiddenIcon` | `String` | `'Default'` | Icône quand masqué (réservé) |
| `visibleIcon` | `String` | `'Default'` | Icône quand visible (réservé) |
| `buttonClasses` | `Array` | `[]` | Classes Tailwind du bouton |

### Comportement

Sur `connect()` :
1. Ajoute `pr-10` à l'input pour laisser de la place au bouton.
2. Crée un `<button>` avec les `buttonClasses` et l'insère après l'input.
3. Rend l'icône SVG `eye-off` (état initial : mot de passe masqué).

Sur clic du bouton :
1. Bascule `this.element.type` entre `'password'` et `'text'`.
2. Met à jour le SVG (eye ↔ eye-off).
3. Met à jour l'aria-label du bouton.

### Usage manuel (sans FormType)

```html
<div class="relative w-full">
    <input
        type="password"
        data-controller="toggle-password"
        data-toggle-password-button-classes-value='["absolute","inset-y-0","right-0","flex","items-center","pr-3","text-muted-foreground"]'
    />
</div>
```

---

## color-picker

**Fichier :** `assets/js/controllers/color_picker_controller.js`
**Identifier :** `color-picker`

Intègre la librairie [Pickr](https://github.com/Simonwep/pickr) sur un `<input type="color">`.

> **Non enregistré globalement.** À importer et enregistrer uniquement si vous utilisez des color pickers.

### Comportement

- Chargement **lazy** : Pickr est initialisé au premier clic sur l'input (pas au `connect()`).
- Positionnement : le picker s'ouvre à la position de l'input (position fixe calculée via `getBoundingClientRect`).
- Dispatche un event natif `change` sur l'input à chaque sélection de couleur → compatible avec les event listeners existants.
- Thème : `nano` sans opacité, avec input hexadécimal.

### Usage

```html
<input type="color" value="#3b58f3"
       data-controller="color-picker" />
```

### CSS requis

```js
// app.css
@import '../../../vendor/appolodev/sf-ui-toolbox/assets/css/pickr.css';
```