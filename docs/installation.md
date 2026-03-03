# Installation & Configuration

## Prérequis

- PHP ≥ 8.2
- Symfony 8.0+
- Tailwind CSS 4+ (côté projet parent)
- Node / pnpm (pour les assets JS)

## Installation Composer

```bash
composer require appolodev/sf-ui-toolbox
```

Le bundle est auto-découvert par Symfony Flex. Aucune déclaration manuelle dans `config/bundles.php` n'est nécessaire.

## Ce que le bundle configure automatiquement

`SFUIToolboxExtension::prepend()` injecte la configuration suivante **sans rien écrire dans les fichiers du projet** :

### Twig

```yaml
twig:
    paths:
        # Rend disponible le namespace @SFUIToolbox
        '<bundle>/templates': SFUIToolbox
    form_themes:
        - '@SFUIToolbox/form/shadcn.html.twig'
        - '@SFUIToolbox/form/toggle_password.html.twig'
```

### Twig Component

```yaml
twig_component:
    defaults:
        'AppoloDev\SFUIToolboxBundle\Twig\Components\':
            template_directory: '@SFUIToolbox/components/'
            name_prefix: 'SFUIToolbox'
```

### KnpPaginator (si présent)

```yaml
knp_paginator:
    template:
        pagination: '@SFUIToolbox/paginator/pagination.html.twig'
```

## Variables d'environnement requises par les layouts

Les layouts `sidebar.html.twig`, `auth.html.twig` et `auth_split.html.twig` s'appuient sur des **globales Twig** injectées par `appolodev/sf-toolbox` (le bundle backend complémentaire) :

| Variable | Env | Description |
|----------|-----|-------------|
| `siteTitle` | `SITE_TITLE` | Nom de l'application (affiché dans la sidebar et les layouts) |
| `themeColor` | `THEME_COLOR` | Couleur principale (non utilisée directement dans ce bundle) |
| `googleMapApiKey` | `GOOGLE_MAP_API_KEY` | Clé Maps (si Géolocalisation activée) |

Si `appolodev/sf-toolbox` n'est pas installé, déclarer ces globales manuellement :

```yaml
# config/packages/twig.yaml
twig:
    globals:
        siteTitle: '%env(SITE_TITLE)%'
```

## Assets JS

Le bundle expose des **Stimulus controllers** et des **Web Components** à importer dans le bundle JS du projet parent.

### 1. Stimulus controllers

Dans votre `bootstrap.js` (ou équivalent) :

```js
import { startStimulusApp } from 'vite-plugin-symfony/stimulus/helpers'
import DialogController      from '../../../vendor/appolodev/sf-ui-toolbox/assets/js/controllers/dialog_controller.js'
import SidebarController     from '../../../vendor/appolodev/sf-ui-toolbox/assets/js/controllers/sidebar_controller.js'
import DismissController     from '../../../vendor/appolodev/sf-ui-toolbox/assets/js/controllers/dismiss_controller.js'
import DropdownController    from '../../../vendor/appolodev/sf-ui-toolbox/assets/js/controllers/dropdown_controller.js'
import TogglePasswordController from '../../../vendor/appolodev/sf-ui-toolbox/assets/js/controllers/toggle_password_controller.js'

const app = startStimulusApp()
app.register('dialog',          DialogController)
app.register('sidebar',         SidebarController)
app.register('dismiss',         DismissController)
app.register('dropdown',        DropdownController)
app.register('toggle-password', TogglePasswordController)
```

> Le controller `color-picker` n'est pas enregistré globalement — l'importer uniquement si vous utilisez `ColorPicker`.

### 2. CSS TomSelect + Pickr

```js
// app.css ou équivalent
@import '../../../vendor/appolodev/sf-ui-toolbox/assets/css/tom-select.css';
@import '../../../vendor/appolodev/sf-ui-toolbox/assets/css/pickr.css'; // si color-picker utilisé
```

### 3. Web component tom-select

```js
import '../../../vendor/appolodev/sf-ui-toolbox/assets/js/components/tom-select.js'
```

## Double-copie (workflow dev)

Quand `sf-ui-toolbox` est référencé via **VCS** dans `composer.json` (path local), toute modification doit être répercutée sur **deux emplacements** :

| Emplacement | Usage |
|-------------|-------|
| `sf-ui-toolbox/` | Repo git local — source de vérité |
| `vendor/appolodev/sf-ui-toolbox/` | Copie installée — utilisée à l'exécution |

Après chaque modification dans `sf-ui-toolbox/`, copier manuellement le fichier modifié dans `vendor/` (ou relancer `composer install`), puis committer les deux repos séparément.