# sf-ui-toolbox — Documentation

Shared Twig components, form widgets, JS controllers and layouts for Symfony 8+ / Tailwind CSS 4 projects.

---

## Table des matières

### Général
| Fichier | Contenu |
|---------|---------|
| [installation.md](./installation.md) | Installation, configuration, variables d'env, assets JS |
| [html-cva.md](./html-cva.md) | Pattern CVA (`html_cva()`) pour la composition de classes Tailwind |

### Formulaires (`form/`)
| Fichier | Contenu |
|---------|---------|
| [form/themes.md](./form/themes.md) | Thème shadcn (tous les blocs) + thème toggle_password |
| [form/types.md](./form/types.md) | TogglePasswordTypeExtension, TomSelectType, EntityTomSelectType |

### Composants Twig (`components/`)
| Fichier | Contenu |
|---------|---------|
| [components/layout.md](./components/layout.md) | Layouts HTML (sidebar, auth, auth_split) + composant Sidebar |
| [components/generic.md](./components/generic.md) | Button, Badge, Alert, Toast, Dialog, SweetAlert, SearchBar, SectionHeader, HelpCard, Pagination, Empty, Breadcrumb… |
| [components/list.md](./components/list.md) | TableList, ListEmpty |
| [components/dropdown.md](./components/dropdown.md) | DropdownMenu, DropdownItemContainer |
| [components/form-submit.md](./components/form-submit.md) | FormSubmit |

### JavaScript
| Fichier | Contenu |
|---------|---------|
| [stimulus-controllers.md](./stimulus-controllers.md) | sidebar, dropdown, dialog, dismiss, toggle-password, color-picker |
| [web-components.md](./web-components.md) | `<tom-select>` et plugin max-items |

---

## Structure du bundle

```
sf-ui-toolbox/
├── src/
│   ├── DependencyInjection/      # Auto-configuration Twig + form themes
│   ├── Form/Extension/           # TogglePasswordTypeExtension
│   └── Twig/Components/          # Backed Twig components (PHP)
│       ├── Layout/Sidebar.php
│       ├── Dropdown/DropdownMenu.php
│       ├── Dropdown/DropdownItemContainer.php
│       ├── Form/FormSubmit.php
│       └── List/TableList.php
├── templates/
│   ├── form/                     # Thèmes de formulaires
│   ├── layouts/                  # Templates HTML complets
│   ├── components/               # Templates Twig components
│   └── paginator/                # Override KnpPaginator
├── assets/
│   ├── css/                      # TomSelect + Pickr CSS
│   └── js/
│       ├── controllers/          # Stimulus controllers
│       └── components/           # Web components (tom-select.js)
└── config/
    └── services.yaml             # Autowiring
```

## Conventions

- **Composants Twig** : préfixe `SFUIToolbox` → `<twig:SFUIToolbox:Generic:Button>`
- **Chemins templates** : `@SFUIToolbox/...`
- **Namespace PHP** : `AppoloDev\SFUIToolboxBundle\...`
- **Stimulus** : identifiants kebab-case (`dialog`, `dropdown`, `toggle-password`, …)