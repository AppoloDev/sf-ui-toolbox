# Composants — Form

---

## FormSubmit (Backed Component)

**Namespace :** `AppoloDev\SFUIToolboxBundle\Twig\Components\Form`
**Template :** `@SFUIToolbox/components/Form/FormSubmit.html.twig`

Barre d'actions de bas de formulaire : bouton Soumettre, bouton Réinitialiser et bouton Supprimer optionnel.

### Props

| Prop | Type | Défaut | Description |
|------|------|--------|-------------|
| `form` | `FormView\|null` | `null` | Objet FormView Symfony |
| `submitField` | `string` | `'submit'` | Nom du champ submit dans le formulaire |
| `deleteButtonLink` | `string\|null` | `null` | URL du bouton Supprimer (déclenche une `SweetAlert`) |
| `deleteSwalTitle` | `string` | `'Êtes-vous sûr ?'` | Titre de la confirmation |
| `deleteSwalText` | `string` | `'Vous êtes sur le point d'effectuer une action totalement irréversible …'` | Message de confirmation |

### Layout

```
┌───────────────────────────────────────────────┐
│  [Soumettre]  [Réinitialiser]      [Supprimer] │
└───────────────────────────────────────────────┘
```

- Gauche : bouton submit (style primary) + bouton reset (style outline)
- Droite : bouton Supprimer (style destructive) si `deleteButtonLink` fourni

### Exemple

```twig
{# Sans suppression #}
{% component 'SFUIToolbox:Form:FormSubmit' with { form: form } %}

{# Avec suppression #}
{% component 'SFUIToolbox:Form:FormSubmit' with {
    form:             form,
    deleteButtonLink: path('flux_delete', {id: flux.id}),
    deleteSwalTitle:  'Supprimer ce flux ?',
    deleteSwalText:   'Tous les slides associés seront perdus définitivement.',
} %}
```

### Notes

- Le bouton Supprimer déclenche une `SweetAlert` de confirmation avant d'exécuter l'action.
- Le bouton Réinitialiser appelle `form.reset()` natif via `type="reset"`.
- `submitField` doit correspondre au `name` du champ `SubmitType` dans le formulaire Symfony (pour que le thème shadcn lui applique le bon style).