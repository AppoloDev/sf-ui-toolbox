# Composants — Layout

---

## Layouts HTML complets

Trois layouts HTML complets sont disponibles dans `@SFUIToolbox/layouts/`.

---

### sidebar.html.twig

Layout principal avec sidebar de navigation.

**Usage :**

```twig
{# templates/_layout/company.html.twig #}
{% extends '@SFUIToolbox/layouts/sidebar.html.twig' %}
```

**Blocs disponibles :**

| Bloc | Description |
|------|-------------|
| `title` | Titre de page (balise `<title>` + header) |
| `sidebar` | Contenu de la sidebar (généralement `{% component 'SFUIToolbox:Layout:Sidebar' %}`) |
| `mainHeaderActions` | Boutons d'action dans le header principal (droite) |
| `body` | Contenu principal de la page |
| `stylesheets` | Balises CSS supplémentaires |
| `javascripts` | Balises JS supplémentaires |
| `help` | Slot d'aide dans la sidebar (bas de page, avant user card) |

**Fonctionnalités intégrées :**
- Script de détection dark mode (localStorage + `prefers-color-scheme`)
- Toast messages Symfony (`app.flashes`)
- Overlay mobile + panel sidebar animé (`-translate-x-full`)
- Header avec bouton burger (mobile)

---

### auth.html.twig

Layout centré pour les pages d'authentification (login, inscription, mot de passe oublié).

**Usage :**

```twig
{% extends '@SFUIToolbox/layouts/auth.html.twig' %}
```

**Blocs disponibles :**

| Bloc | Description |
|------|-------------|
| `title` | Titre de la carte |
| `subtitle` | Sous-titre optionnel (en dessous du titre) |
| `logo` | Remplacement du logo (défaut : `logo.svg`) |
| `language_switcher` | Sélecteur de langue |
| `body` | Formulaire / contenu |

**Layout :** Logo centré en haut, card `max-w-[28rem]` arrondie avec ombre.

---

### auth_split.html.twig

Layout split-screen : panneau de branding à gauche + formulaire à droite.

**Usage :**

```twig
{% extends '@SFUIToolbox/layouts/auth_split.html.twig' %}
```

**Blocs disponibles :**

| Bloc | Description |
|------|-------------|
| `title` | Titre du formulaire (panneau droit) |
| `subtitle` | Sous-titre du formulaire |
| `body` | Formulaire / contenu (panneau droit) |
| `branding` | Wrapper du panneau gauche |
| `branding_logo` | Logo dans le panneau gauche |
| `branding_title` | Titre de marque (défaut : `siteTitle`) |
| `branding_description` | Tagline |
| `language_switcher` | Sélecteur de langue |

**Layout :** Panneau gauche fond `bg-primary` (caché sur mobile), panneau droit formulaire centré. Décoration : formes circulaires floutées.

---

## Layout:Sidebar (Backed Component)

**Namespace :** `AppoloDev\SFUIToolboxBundle\Twig\Components\Layout`
**Template :** `@SFUIToolbox/components/Layout/Sidebar.html.twig`

Composant PHP qui gère l'état actif des liens de navigation en fonction de la route courante.

### Props

| Prop | Type | Défaut | Description |
|------|------|--------|-------------|
| `routePrefix` | `string` | `''` | Préfixe des routes (ex: `'admin'`, `'company'`) |
| `userName` | `string\|null` | `null` | Nom affiché dans la user card |
| `userRole` | `string\|null` | `null` | Sous-titre de la user card (rôle, société…) |
| `userInitials` | `string\|null` | `null` | Initiales de l'avatar (défaut : première lettre de `userName`) |
| `mainLinks` | `array` | `[]` | Structure des liens de navigation (voir ci-dessous) |

### Structure `mainLinks`

**Lien simple :**

```php
[
    'label'     => 'Tableau de bord',
    'route'     => 'admin_dashboard',
    'params'    => [],           // query string params optionnels
    'icon'      => 'lucide:home',
    'isGranted' => true,        // condition d'affichage
]
```

**Groupe collapsible (détails/summary natif) :**

```php
[
    'label'     => 'Gestion',
    'icon'      => 'lucide:settings',
    'isGranted' => true,
    'children'  => [
        ['label' => 'Utilisateurs', 'route' => 'admin_users', 'icon' => 'lucide:user', 'isGranted' => true],
        ['label' => 'Sociétés',     'route' => 'admin_companies', 'icon' => 'lucide:building', 'isGranted' => true],
    ],
]
```

**Logique active state :**
- `isActive = true` si la route courante correspond ET tous les `params` correspondent aux query params actuels.
- Pour les groupes : `isOpen = true` si au moins un enfant est actif.

### Exemple d'utilisation

```twig
{# Dans un layout #}
{% block sidebar %}
    {% component 'SFUIToolbox:Layout:Sidebar' with {
        routePrefix: 'company',
        userName:    app.user.fullName,
        userRole:    app.user.company.name,
        mainLinks:   mainLinks,
    } %}
{% endblock %}
```

```php
// Dans le controller ou un service
$mainLinks = [
    ['label' => 'Flux',      'route' => 'company_flux_list',   'icon' => 'lucide:play',   'isGranted' => true],
    ['label' => 'Appareils', 'route' => 'company_device_list', 'icon' => 'lucide:tv',     'isGranted' => true],
    ['label' => 'Médias',    'route' => 'company_media_list',  'icon' => 'lucide:image',  'isGranted' => true],
    ['label' => 'Thème',     'route' => 'company_theme_edit',  'icon' => 'lucide:palette','isGranted' => $this->isGranted('ROLE_MANAGER')],
];
```