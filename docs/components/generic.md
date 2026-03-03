# Composants — Generic

Tous les composants Generic s'utilisent avec le préfixe `SFUIToolbox:Generic:`.

---

## Button

**Template :** `@SFUIToolbox/components/Generic/Button.html.twig`

### Props

| Prop | Type | Valeurs | Défaut |
|------|------|---------|--------|
| `variant` | `string` | `default` `secondary` `destructive` `outline` `ghost` `link` | `default` |
| `size` | `string` | `default` `sm` `lg` `icon` `icon-sm` `icon-lg` | `default` |
| `as` | `string` | `button` `a` | `button` |
| `link` | `string` | URL | — |
| `allowDisplay` | `bool` | — | `true` |

> Si `link` est défini, le composant rend un `<a>` (équivalent à `as="a"`).

### Variantes

| Variant | Apparence |
|---------|-----------|
| `default` | Fond `bg-primary`, texte blanc |
| `secondary` | Fond `bg-secondary`, texte `secondary-foreground` |
| `destructive` | Fond rouge `bg-destructive` |
| `outline` | Bordure, fond transparent |
| `ghost` | Transparent, hover uniquement |
| `link` | Texte souligné, sans fond |

### Tailles

| Size | Hauteur | Padding |
|------|---------|---------|
| `default` | `h-9` | `px-4 py-2` |
| `sm` | `h-8` | `px-3` |
| `lg` | `h-10` | `px-6` |
| `icon` | `size-9` | — |
| `icon-sm` | `size-8` | — |
| `icon-lg` | `size-10` | — |

### Exemples

```twig
<twig:SFUIToolbox:Generic:Button>
    Sauvegarder
</twig:SFUIToolbox:Generic:Button>

<twig:SFUIToolbox:Generic:Button variant="outline" size="sm">
    Annuler
</twig:SFUIToolbox:Generic:Button>

<twig:SFUIToolbox:Generic:Button variant="destructive" link="{{ path('delete') }}">
    Supprimer
</twig:SFUIToolbox:Generic:Button>

<twig:SFUIToolbox:Generic:Button variant="ghost" size="icon">
    <twig:ux:icon name="lucide:pencil" />
</twig:SFUIToolbox:Generic:Button>
```

---

## Badge

**Template :** `@SFUIToolbox/components/Generic/Badge.html.twig`

Badge inline arrondi (`rounded-full`).

### Props

| Prop | Valeurs |
|------|---------|
| `variant` | `default` `secondary` `destructive` `outline` `gray` `green` `red` `blue` `yellow` `orange` `indigo` `appolo` |
| `color` | Alias de `variant` |
| `label` | Texte (ou utiliser le slot) |

```twig
<twig:SFUIToolbox:Generic:Badge variant="green" label="Actif" />
<twig:SFUIToolbox:Generic:Badge variant="red">Inactif</twig:SFUIToolbox:Generic:Badge>
```

---

## BadgeYesNo

Affiche un booléen sous forme de badge Oui (vert) / Non (gris).

```twig
<twig:SFUIToolbox:Generic:BadgeYesNo :value="entity.isActive" />
```

---

## Alert

**Template :** `@SFUIToolbox/components/Generic/Alert.html.twig`

### Props

| Prop | Valeurs / Type |
|------|---------------|
| `variant` | `default` `destructive` `green` `orange` `blue` `indigo` |
| `color` | Alias de `variant` |
| `header` | `string` — titre |
| `description` | `string` — corps |
| `links` | `array<{label, link}>` — liens d'action optionnels |

```twig
<twig:SFUIToolbox:Generic:Alert
    variant="destructive"
    header="Erreur"
    description="Une erreur est survenue lors de l'opération."
/>

<twig:SFUIToolbox:Generic:Alert
    variant="blue"
    header="Information"
    description="Votre compte sera expiré dans 30 jours."
    :links="[{label: 'Renouveler', link: path('subscription_renew')}]"
/>
```

---

## Toast

**Template :** `@SFUIToolbox/components/Generic/Toast.html.twig`

Notification temporaire avec bouton de fermeture (`dismiss` controller).

### Props

| Prop | Valeurs |
|------|---------|
| `message` | `string` |
| `type` | `success` `error` `danger` `warning` |

Géré automatiquement par le layout `sidebar.html.twig` via les flash messages Symfony :

```php
// Controller
$this->addFlash('success', 'Modifications enregistrées.');
$this->addFlash('error', 'Une erreur est survenue.');
```

---

## SectionHeader

**Template :** `@SFUIToolbox/components/Generic/SectionHeader.html.twig`

En-tête de section avec icône, titre et description.

### Props

| Prop | Type | Description |
|------|------|-------------|
| `icon` | `string` | Nom d'icône Lucide (ex: `lucide:palette`) |
| `title` | `string` | Titre principal |
| `description` | `string` | Sous-titre |
| `class` | `string` | Classes supplémentaires sur le wrapper |

```twig
<twig:SFUIToolbox:Generic:SectionHeader
    icon="lucide:palette"
    title="Couleurs de marque"
    description="Définissez la palette de couleurs de votre identité visuelle."
/>
```

**Rendu :** Conteneur flex avec cercle `bg-primary/10` contenant l'icône, puis titre en `font-semibold` et description en `text-muted-foreground`.

---

## HelpCard

**Template :** `@SFUIToolbox/components/Generic/HelpCard.html.twig`

Carte d'aide sur fond primary (bleue).

### Props

| Prop | Type |
|------|------|
| `title` | `string` |
| `description` | `string` |
| `buttonLabel` | `string` |
| `buttonLink` | `string` (URL, défaut: `#`) |

```twig
{# Dans un block help du layout #}
{% block help %}
    <twig:SFUIToolbox:Generic:HelpCard
        title="Besoin d'aide ?"
        description="Consultez notre documentation ou contactez le support."
        buttonLabel="Documentation"
        buttonLink="https://docs.example.com"
    />
{% endblock %}
```

---

## SearchBar

**Template :** `@SFUIToolbox/components/Generic/SearchBar.html.twig`

Barre de recherche avec champ texte, bouton clear et bouton filtrer.

**Fonctionnement :**
- Paramètre de recherche : `name="q"` (compatible avec `app.request.query.get('q')`)
- Bouton **Clear** : redirige vers la route courante sans le paramètre `q` (conserve les autres params)
- Bouton **Filtrer** : soumet le formulaire

```twig
{# S'utilise généralement dans le bloc search_bar de TableList #}
{% block search_bar %}
    <twig:SFUIToolbox:Generic:SearchBar />
{% endblock %}
```

---

## Pagination

**Template :** `@SFUIToolbox/components/Generic/Pagination.html.twig`

Barre de pagination Précédent / Suivant.

### Props

| Prop | Type | Défaut | Description |
|------|------|--------|-------------|
| `pagination` | `PaginationInterface` | — | Objet KnpPaginator |
| `route` | `string` | — | Nom de route pour les liens |
| `item_label` | `string` | `'élément'` | Label singulier des items |

```twig
<twig:SFUIToolbox:Generic:Pagination
    :pagination="pagination"
    route="company_flux_list"
    item_label="flux"
/>
```

**Affichage :** `Affichage de X sur Y éléments` + boutons Précédent/Suivant avec passage des query params existants (filtre `q`, etc.).

---

## Dialog (Modal native)

**Template :** `@SFUIToolbox/components/Generic/Dialog.html.twig`

Basé sur l'élément `<dialog>` natif HTML avec le Stimulus controller `dialog`.

### Sous-composants

| Composant | Description |
|-----------|-------------|
| `Dialog` | Wrapper principal (`data-controller="dialog"`) |
| `Dialog/Trigger` | Bouton d'ouverture |
| `Dialog/Content` | Corps de la modal |
| `Dialog/Header` | En-tête |
| `Dialog/Title` | Titre |
| `Dialog/Description` | Description |
| `Dialog/Footer` | Pied avec boutons |
| `Dialog/Close` | Bouton de fermeture |

```twig
<twig:SFUIToolbox:Generic:Dialog id="confirm-dialog">
    <twig:SFUIToolbox:Generic:Dialog:Trigger>
        <twig:SFUIToolbox:Generic:Button variant="outline">
            Ouvrir
        </twig:SFUIToolbox:Generic:Button>
    </twig:SFUIToolbox:Generic:Dialog:Trigger>

    <twig:SFUIToolbox:Generic:Dialog:Content>
        <twig:SFUIToolbox:Generic:Dialog:Header>
            <twig:SFUIToolbox:Generic:Dialog:Title>Confirmation</twig:SFUIToolbox:Generic:Dialog:Title>
            <twig:SFUIToolbox:Generic:Dialog:Description>
                Êtes-vous sûr de vouloir continuer ?
            </twig:SFUIToolbox:Generic:Dialog:Description>
        </twig:SFUIToolbox:Generic:Dialog:Header>

        <twig:SFUIToolbox:Generic:Dialog:Footer>
            <twig:SFUIToolbox:Generic:Dialog:Close>Annuler</twig:SFUIToolbox:Generic:Dialog:Close>
            <twig:SFUIToolbox:Generic:Button>Confirmer</twig:SFUIToolbox:Generic:Button>
        </twig:SFUIToolbox:Generic:Dialog:Footer>
    </twig:SFUIToolbox:Generic:Dialog:Content>
</twig:SFUIToolbox:Generic:Dialog>
```

**Comportements :**
- Fermeture sur clic en dehors (backdrop)
- Fermeture sur `Esc` (natif `<dialog>`)
- Animation d'ouverture/fermeture via classes CSS

---

## SweetAlert (Dialog de confirmation)

**Template :** `@SFUIToolbox/components/Generic/SweetAlert.html.twig`

Dialog de confirmation d'action destructive (suppression, etc.).

### Props

| Prop | Type | Description |
|------|------|-------------|
| `allowDisplay` | `bool` | Condition d'affichage |
| `swalTitle` | `string` | Titre du dialog |
| `swalText` | `string` | Message de confirmation |
| `confirmLink` | `string` | URL de navigation (GET) à déclencher à la confirmation |
| `confirmFormId` | `string` | ID d'un `<form>` caché à soumettre (POST + CSRF) |
| `confirmLabel` | `string` | Texte du bouton confirmer (défaut : traduction `i_confirm`) |

```twig
{# Suppression via formulaire POST #}
<form id="delete-form-{{ entity.id }}" method="post" action="{{ path('delete', {id: entity.id}) }}" class="hidden">
    <input type="hidden" name="_token" value="{{ csrf_token('delete' ~ entity.id) }}">
    <input type="hidden" name="_method" value="DELETE">
</form>

<twig:SFUIToolbox:Generic:SweetAlert
    swalTitle="Supprimer cet élément ?"
    swalText="Cette action est irréversible."
    confirmFormId="delete-form-{{ entity.id }}"
/>
```

**Traductions auto :** `cancel` et `i_confirm` sont traduits automatiquement via le domaine `messages`.

---

## Empty State

Composants pour les états vides (liste sans résultat).

```twig
<twig:SFUIToolbox:Generic:Empty>
    <twig:SFUIToolbox:Generic:Empty:Media>
        <twig:ux:icon name="lucide:inbox" class="size-10 text-muted-foreground" />
    </twig:SFUIToolbox:Generic:Empty:Media>
    <twig:SFUIToolbox:Generic:Empty:Header>
        <twig:SFUIToolbox:Generic:Empty:Title>Aucun résultat</twig:SFUIToolbox:Generic:Empty:Title>
        <twig:SFUIToolbox:Generic:Empty:Description>
            Aucun élément ne correspond à votre recherche.
        </twig:SFUIToolbox:Generic:Empty:Description>
    </twig:SFUIToolbox:Generic:Empty:Header>
    <twig:SFUIToolbox:Generic:Empty:Content>
        <twig:SFUIToolbox:Generic:Button link="{{ path('create') }}">
            Créer un élément
        </twig:SFUIToolbox:Generic:Button>
    </twig:SFUIToolbox:Generic:Empty:Content>
</twig:SFUIToolbox:Generic:Empty>
```

---

## Breadcrumb

Fil d'ariane accessible.

```twig
<twig:SFUIToolbox:Generic:Breadcrumb>
    <twig:SFUIToolbox:Generic:Breadcrumb:List>
        <twig:SFUIToolbox:Generic:Breadcrumb:Item>
            <twig:SFUIToolbox:Generic:Breadcrumb:Link href="{{ path('admin_dashboard') }}">
                Tableau de bord
            </twig:SFUIToolbox:Generic:Breadcrumb:Link>
        </twig:SFUIToolbox:Generic:Breadcrumb:Item>
        <twig:SFUIToolbox:Generic:Breadcrumb:Separator />
        <twig:SFUIToolbox:Generic:Breadcrumb:Item>
            <twig:SFUIToolbox:Generic:Breadcrumb:Page>Sociétés</twig:SFUIToolbox:Generic:Breadcrumb:Page>
        </twig:SFUIToolbox:Generic:Breadcrumb:Item>
    </twig:SFUIToolbox:Generic:Breadcrumb:List>
</twig:SFUIToolbox:Generic:Breadcrumb>
```