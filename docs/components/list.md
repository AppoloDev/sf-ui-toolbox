# Composants — List

---

## TableList (Backed Component)

**Namespace :** `AppoloDev\SFUIToolboxBundle\Twig\Components\List`
**Template :** `@SFUIToolbox/components/List/TableList.html.twig`

Composant de tableau paginé avec header, barre de recherche et footer.

### Props PHP

| Prop | Type | Description |
|------|------|-------------|
| `headerTitle` | `string\|null` | Titre du header (optionnel) |
| `tableColumns` | `array\|null` | En-têtes de colonnes (HTML brut autorisé) |
| `pagination` | `PaginationInterface\|null` | Objet KnpPaginator |

### Blocs Twig à surcharger

| Bloc | Description |
|------|-------------|
| `header_title` | Titre de la section (h2 ou équivalent) |
| `header_actions` | Boutons d'action à droite du header (ex: bouton Créer) |
| `search_bar` | Zone de recherche (intégrer `SearchBar` ici) |
| `search_extraFields` | Champs de filtre supplémentaires |
| `search_actions` | Boutons d'action de la barre de recherche |
| `table_header` | Balises `<th>` — généré automatiquement si `tableColumns` fourni |
| `table_items` | Boucle sur les items (à surcharger pour le rendu des lignes) |
| `table_item` | Rendu d'un item individuel |
| `emptyList` | Affiché quand la pagination est vide (intégrer `ListEmpty` ici) |
| `footer` | Pied du tableau (pagination généralement) |

### Exemple complet

```twig
{% component 'SFUIToolbox:List:TableList' with {
    pagination: pagination,
    tableColumns: ['Nom', 'Email', 'Rôle', '<span class="sr-only">Actions</span>'],
} %}
    {% block header_title %}
        <h2 class="text-lg font-semibold">Utilisateurs</h2>
    {% endblock %}

    {% block header_actions %}
        <twig:SFUIToolbox:Generic:Button link="{{ path('admin_user_create') }}" size="sm">
            <twig:ux:icon name="lucide:plus" />
            Nouvel utilisateur
        </twig:SFUIToolbox:Generic:Button>
    {% endblock %}

    {% block search_bar %}
        <twig:SFUIToolbox:Generic:SearchBar />
    {% endblock %}

    {% block table_items %}
        {% for user in pagination %}
            <tr>
                <td class="px-4 py-3 font-medium">{{ user.fullName }}</td>
                <td class="px-4 py-3 text-muted-foreground">{{ user.email }}</td>
                <td class="px-4 py-3">
                    <twig:SFUIToolbox:Generic:Badge :variant="user.isAdmin ? 'default' : 'secondary'"
                        :label="user.isAdmin ? 'Admin' : 'Utilisateur'" />
                </td>
                <td class="px-4 py-3 text-right">
                    {# Actions dropdown #}
                </td>
            </tr>
        {% endfor %}
    {% endblock %}

    {% block emptyList %}
        <twig:SFUIToolbox:List:ListEmpty />
    {% endblock %}

    {% block footer %}
        <twig:SFUIToolbox:Generic:Pagination
            :pagination="pagination"
            route="admin_user_list"
        />
    {% endblock %}
{% endcomponent %}
```

### Alignement des colonnes

Le template gère automatiquement l'alignement des `<th>` :
- **Première colonne** : `text-left`
- **Dernière colonne** : `text-right`
- **Colonnes intermédiaires** : `text-center`

---

## ListEmpty

**Template :** `@SFUIToolbox/components/List/ListEmpty.html.twig`

Composant d'état vide simplifié pour les tableaux. Affiche un message centré dans une cellule qui occupe toutes les colonnes.

```twig
{% block emptyList %}
    <twig:SFUIToolbox:List:ListEmpty />
{% endblock %}
```

Utilise le composant `Generic/Empty` en interne.