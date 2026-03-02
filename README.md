# sf-ui-toolbox

Shared Twig components for Symfony / Tailwind CSS projects.

---

## `html_cva()` — Class Variance Authority for Twig

`html_cva()` is a Twig function (provided by this bundle) that mirrors the [`cva`](https://cva.style) pattern from the JS ecosystem. It generates a class string based on a base class and a set of variant maps.

### Signature

```twig
{% set style = html_cva(
    base: "...",       {# always-applied classes #}
    variants: {        {# variant groups #}
        groupName: {
            value1: "classes-for-value1",
            value2: "classes-for-value2",
        },
    },
) %}

{# Apply by passing the chosen variant values #}
<div class="{{ style.apply({groupName: 'value1'}, extraClasses) }}">
```

### Example — Button

```twig
{% set style = html_cva(
    base: "inline-flex items-center rounded-md text-sm font-medium transition-all",
    variants: {
        variant: {
            default:     'bg-primary text-primary-foreground hover:bg-primary/90',
            outline:     'border bg-background hover:bg-accent',
            ghost:       'hover:bg-accent hover:text-accent-foreground',
            destructive: 'bg-destructive text-white hover:bg-destructive/90',
        },
        size: {
            default: 'h-9 px-4 py-2',
            sm:      'h-8 px-3',
            lg:      'h-10 px-6',
            icon:    'size-9',
        },
    },
) %}

<button class="{{ style.apply({variant: 'outline', size: 'sm'}) }}">
    Click me
</button>
```

`style.apply(variants, extraClasses)` merges base + resolved variant classes + any extra classes passed by the caller (supports `tailwind_merge` via `attributes.render('class')`).

---

## Components

### Generic/Button

Props: `variant` (default/secondary/destructive/outline/ghost/link), `size` (default/sm/lg/icon/icon-sm/icon-lg), `as` (button|a), `link` (URL shorthand → renders `<a>`), `allowDisplay`.

```twig
<twig:SFUIToolbox:Generic:Button variant="outline" size="sm">
    Label
</twig:SFUIToolbox:Generic:Button>

{# As a link #}
<twig:SFUIToolbox:Generic:Button link="{{ path('route') }}" variant="ghost">
    Go somewhere
</twig:SFUIToolbox:Generic:Button>
```

### Generic/SectionHeader

Props: `icon`, `title`, `description`, `class`.

### Generic/HelpCard

Props: `title`, `description`, `link`, `linkLabel`.

### List/TableList

Blocks: `header_title`, `header_actions`, `search_bar`, `search_extraFields`, `search_actions`, `table_header`, `table_items`, `table_item`, `emptyList`, `footer`.

Props: `headerTitle`, `tableColumns`, `pagination`.
