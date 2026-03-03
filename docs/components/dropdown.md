# Composants — Dropdown

---

## DropdownMenu (Backed Component)

**Namespace :** `AppoloDev\SFUIToolboxBundle\Twig\Components\Dropdown`
**Template :** `@SFUIToolbox/components/Dropdown/DropdownMenu.html.twig`

Menu déroulant avec bouton ellipsis `⋯` et Stimulus controller `dropdown`.

### Blocs Twig

| Bloc | Description |
|------|-------------|
| `dropdownButton` | Contenu du bouton déclencheur (par défaut : icône ellipsis) |
| `dropdownHeaderLabel` | Label optionnel en haut du menu |
| `dropdownItems` | Liste des éléments du menu |

### Exemple

```twig
{% component 'SFUIToolbox:Dropdown:DropdownMenu' %}
    {% block dropdownItems %}
        <a href="{{ path('flux_edit', {id: flux.id}) }}"
           class="flex items-center gap-2 px-3 py-1.5 text-sm hover:bg-accent rounded-sm">
            <twig:ux:icon name="lucide:pencil" class="size-4" />
            Modifier
        </a>

        <twig:SFUIToolbox:Dropdown:DropdownItemContainer>
            {# Séparateur automatique au-dessus #}
            <button type="button"
                    class="flex w-full items-center gap-2 px-3 py-1.5 text-sm text-destructive hover:bg-accent rounded-sm">
                <twig:ux:icon name="lucide:trash-2" class="size-4" />
                Supprimer
            </button>
        </twig:SFUIToolbox:Dropdown:DropdownItemContainer>
    {% endblock %}
{% endcomponent %}
```

**Comportements :**
- Clic sur le bouton → toggle du menu (Stimulus `dropdown#toggle`)
- Clic en dehors → fermeture (Stimulus `dropdown#closeOnClickOutside` via `click@window`)
- Positionnement : absolu par rapport au bouton

---

## DropdownItemContainer (Backed Component)

**Namespace :** `AppoloDev\SFUIToolboxBundle\Twig\Components\Dropdown`
**Template :** `@SFUIToolbox/components/Dropdown/DropdownItemContainer.html.twig`

Container d'items avec séparateur (`border-t`) automatique. Utile pour grouper des actions destructives séparément des actions normales.

### Props

| Prop | Type | Défaut | Description |
|------|------|--------|-------------|
| `allowDisplay` | `bool` | `true` | Condition d'affichage du groupe entier |

```twig
{# Groupe d'actions destructives (toujours affiché) #}
<twig:SFUIToolbox:Dropdown:DropdownItemContainer>
    <button ...>Supprimer</button>
</twig:SFUIToolbox:Dropdown:DropdownItemContainer>

{# Groupe conditionnel #}
<twig:SFUIToolbox:Dropdown:DropdownItemContainer :allowDisplay="is_granted('ROLE_ADMIN')">
    <a href="{{ path('admin_impersonate', {id: user.id}) }}">Se connecter en tant que</a>
</twig:SFUIToolbox:Dropdown:DropdownItemContainer>
```