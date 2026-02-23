import TomSelect from "tom-select";
import maxItemPlugin from "./plugins/max-items";

class TomSelectElement extends HTMLElement {
    connectedCallback() {
        const input = this.querySelector('select') || this.querySelector('input');
        if (!input) return;

        const conf = JSON.parse(this.getAttribute('options') || '{}');
        const addText = this.getAttribute('addText') ?? 'Ajouter';
        const noMatchText = this.getAttribute('noMatchText') ?? 'Aucun résultat';

        let options = {
            plugins: ['dropdown_input'],
            maxOptions: null,
            maxItems: conf.maxItems ?? 1,
            create: this.hasAttribute('create'),
            dropdownParent: 'body',
            render: {
                option_create: (data, escape) =>
                    `<div class="create">${addText} : <strong>${escape(data.input)}</strong>&hellip;</div>`,
                no_results: () =>
                    `<div class="no-results">${noMatchText}</div>`,
            },
            ...conf,
        };

        if (conf.options) {
            if (Array.isArray(conf.options)) {
                options.options = conf.options.map(e => ({ text: e, value: e }));
            } else {
                options.options = Object.entries(conf.options).map(([label, value]) => ({
                    text: label,
                    value: value,
                }));
            }
        }

        if (options.maxItems === null || options.maxItems > 1) {
            options.plugins.push('remove_button');
            options.plugins.push('checkbox_options');
        }

        if (conf.maxItemsCount) {
            options.plugins.push('maxItemPlugin');
            options.maxItemsCount = conf.maxItemsCount;
        }

        TomSelect.define('maxItemPlugin', maxItemPlugin);
        this.instance = new TomSelect(input, options);
    }

    disconnectedCallback() {
        this.instance?.destroy();
    }
}

window.customElements.define('tom-select', TomSelectElement);