# sf-ui-toolbox

Shared Twig components, form widgets, Stimulus controllers and HTML layouts for **Symfony 8+ / Tailwind CSS 4** projects.

Basé sur [shadcn/ui](https://ui.shadcn.com/) et [CVA](https://cva.style). Auto-configuré via `SFUIToolboxExtension`.

---

## Ce que le bundle fournit

| Catégorie | Contenu |
|-----------|---------|
| **Form themes** | Thème shadcn complet (inputs, selects, checkboxes, labels, erreurs) + toggle password |
| **Layouts HTML** | `sidebar`, `auth`, `auth_split` |
| **Composants Twig** | Button, Badge, Alert, Toast, Dialog, SweetAlert, TableList, Dropdown, SearchBar, Pagination… |
| **Stimulus controllers** | `sidebar`, `dropdown`, `dialog`, `dismiss`, `toggle-password`, `color-picker` |
| **Web components** | `<tom-select>` (single + multi-select avec plugins) |
| **CSS** | TomSelect theming, Pickr overrides |

---

## Installation

```bash
composer require appolodev/sf-ui-toolbox
```

Le bundle est auto-découvert. Aucune configuration manuelle n'est nécessaire.

Pour les assets JS, importer les controllers et web components dans votre bundle Stimulus :

```js
import DialogController         from '../../../vendor/appolodev/sf-ui-toolbox/assets/js/controllers/dialog_controller.js'
import SidebarController        from '../../../vendor/appolodev/sf-ui-toolbox/assets/js/controllers/sidebar_controller.js'
import DismissController        from '../../../vendor/appolodev/sf-ui-toolbox/assets/js/controllers/dismiss_controller.js'
import DropdownController       from '../../../vendor/appolodev/sf-ui-toolbox/assets/js/controllers/dropdown_controller.js'
import TogglePasswordController from '../../../vendor/appolodev/sf-ui-toolbox/assets/js/controllers/toggle_password_controller.js'

app.register('dialog',          DialogController)
app.register('sidebar',         SidebarController)
app.register('dismiss',         DismissController)
app.register('dropdown',        DropdownController)
app.register('toggle-password', TogglePasswordController)
```

---

## Utilisation rapide

### Composants Twig

```twig
{# Bouton primary #}
<twig:SFUIToolbox:Generic:Button>Sauvegarder</twig:SFUIToolbox:Generic:Button>

{# Bouton outline small #}
<twig:SFUIToolbox:Generic:Button variant="outline" size="sm">Annuler</twig:SFUIToolbox:Generic:Button>

{# Badge statut #}
<twig:SFUIToolbox:Generic:Badge variant="green" label="Actif" />

{# En-tête de section #}
<twig:SFUIToolbox:Generic:SectionHeader
    icon="lucide:palette"
    title="Couleurs de marque"
    description="Palette de l'identité visuelle."
/>
```

### Toggle Password

```php
// Dans un FormType
$builder->add('password', PasswordType::class, ['toggle' => true]);
```

### TableList

```twig
{% component 'SFUIToolbox:List:TableList' with {pagination: pagination} %}
    {% block table_items %}
        {% for item in pagination %}
            <tr><td>{{ item.name }}</td></tr>
        {% endfor %}
    {% endblock %}
{% endcomponent %}
```

---

## Documentation complète

La documentation détaillée est dans le dossier [`docs/`](./docs/index.md) :

- [Installation & Configuration](./docs/installation.md)
- [Pattern html_cva()](./docs/html-cva.md)
- **Formulaires**
  - [Thèmes (shadcn + toggle_password)](./docs/form/themes.md)
  - [Form Types & Extensions](./docs/form/types.md)
- **Composants**
  - [Layouts (sidebar, auth, auth_split)](./docs/components/layout.md)
  - [Generics (Button, Badge, Alert, Dialog…)](./docs/components/generic.md)
  - [List (TableList, ListEmpty)](./docs/components/list.md)
  - [Dropdown (DropdownMenu, DropdownItemContainer)](./docs/components/dropdown.md)
  - [Form (FormSubmit)](./docs/components/form-submit.md)
- **JavaScript**
  - [Stimulus Controllers](./docs/stimulus-controllers.md)
  - [Web Components (tom-select)](./docs/web-components.md)