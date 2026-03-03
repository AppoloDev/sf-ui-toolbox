# Pattern CVA — `html_cva()`

`html_cva()` est une fonction Twig fournie par le package [`tales-from-a-dev/twig-tailwind-extra`](https://github.com/tales-from-a-dev/twig-tailwind-extra). Elle implémente le pattern [Class Variance Authority](https://cva.style) pour Twig.

---

## Principe

CVA permet de définir un composant avec des **variants** typés, et de générer proprement la chaîne de classes CSS en fonction des variants choisis à l'usage.

```
classes finales = base + variant[groupA][valeurA] + variant[groupB][valeurB] + extraClasses
```

---

## Signature

```twig
{% set style = html_cva(
    base: "classes-de-base",
    variants: {
        nomDuGroupe: {
            valeur1: "classes-si-valeur1",
            valeur2: "classes-si-valeur2",
        },
    },
    defaultVariants: {
        nomDuGroupe: 'valeur1',
    },
) %}
```

**Application :**

```twig
{{ style.apply({nomDuGroupe: 'valeur2'}, 'classes-extra') }}
```

---

## Paramètres

| Paramètre | Type | Description |
|-----------|------|-------------|
| `base` | `string` | Classes toujours présentes (quel que soit le variant) |
| `variants` | `object` | Groupes de variants. Chaque groupe = une dimension de variation. |
| `defaultVariants` | `object` | Valeurs par défaut si un groupe n'est pas spécifié dans `apply()` |

**`apply(variants, extraClasses)`**

| Paramètre | Type | Description |
|-----------|------|-------------|
| `variants` | `object` | Valeurs choisies pour chaque groupe |
| `extraClasses` | `string` | Classes libres ajoutées à la fin (utile pour les classes passées par le parent) |

---

## Exemple — Button

```twig
{% set style = html_cva(
    base: "inline-flex items-center justify-center rounded-md text-sm font-medium transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50",
    variants: {
        variant: {
            default:     'bg-primary text-primary-foreground hover:bg-primary/90',
            secondary:   'bg-secondary text-secondary-foreground hover:bg-secondary/80',
            destructive: 'bg-destructive text-white hover:bg-destructive/90',
            outline:     'border border-input bg-background hover:bg-accent hover:text-accent-foreground',
            ghost:       'hover:bg-accent hover:text-accent-foreground',
            link:        'text-primary underline-offset-4 hover:underline',
        },
        size: {
            default: 'h-9 px-4 py-2',
            sm:      'h-8 px-3 gap-1.5',
            lg:      'h-10 px-6',
            icon:    'size-9',
            'icon-sm': 'size-8',
            'icon-lg': 'size-10',
        },
    },
    defaultVariants: {
        variant: 'default',
        size:    'default',
    },
) %}

<button class="{{ style.apply({variant: variant, size: size}, extraClass) }}">
    {{ block('content') }}
</button>
```

---

## Exemple — Badge

```twig
{% set style = html_cva(
    base: "inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold transition-colors",
    variants: {
        variant: {
            default:     'bg-primary text-primary-foreground',
            secondary:   'bg-secondary text-secondary-foreground',
            destructive: 'bg-destructive text-white',
            outline:     'border text-foreground',
            green:       'bg-green-100 text-green-800',
            red:         'bg-red-100 text-red-800',
            blue:        'bg-blue-100 text-blue-800',
            yellow:      'bg-yellow-100 text-yellow-800',
            orange:      'bg-orange-100 text-orange-800',
        },
    },
    defaultVariants: {
        variant: 'default',
    },
) %}
```

---

## Avantages vs classes conditionnelles

**Sans CVA (fragile, verbeux) :**

```twig
<button class="
    inline-flex items-center rounded-md text-sm
    {% if variant == 'outline' %}border bg-background{% endif %}
    {% if variant == 'default' %}bg-primary text-white{% endif %}
    {% if size == 'sm' %}h-8 px-3{% else %}h-9 px-4{% endif %}
    {{ extraClass }}
">
```

**Avec CVA (déclaratif, maintenable) :**

```twig
<button class="{{ style.apply({variant: variant, size: size}, extraClass) }}">
```

---

## Intégration avec `tailwind_merge`

CVA produit une chaîne de classes. Si des classes entrent en conflit (ex: l'appelant passe `h-12` alors que la base définit `h-9`), utiliser `tailwind_merge` pour résoudre les conflits :

```twig
{# Le composant Button le fait automatiquement via attributes.render('class') #}
<button class="{{ style.apply({variant: variant, size: size}, attributes.render('class')) }}">
```

`tailwind_merge` (fourni par `twig/html-extra`) applique les règles de spécificité Tailwind — la dernière classe d'un groupe gagne.
