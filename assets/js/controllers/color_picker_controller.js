import { Controller } from '@hotwired/stimulus';
import Pickr from '@simonwep/pickr';

/**
 * Replaces the native browser color picker on an <input type="color">
 * with Pickr. Dispatches a native `change` event (bubbles) when the color changes.
 *
 * Usage: <input type="color" value="#2B26D9" data-controller="color-picker">
 */
export default class extends Controller {
    connect() {
        this.element.addEventListener('click', this._handleClick = (e) => {
            e.preventDefault();
            if (!this._pickr) this._initPickr();
            const rect = this.element.getBoundingClientRect();
            this._anchor.style.left = `${rect.left}px`;
            this._anchor.style.top  = `${rect.bottom + 8}px`;
            this._pickr.setColor(this.element.value || '#000000', false);
            this._pickr.show();
        });
    }

    disconnect() {
        this._pickr?.destroyAndRemove();
        this._anchor?.remove();
        this.element.removeEventListener('click', this._handleClick);
    }

    _initPickr() {
        this._anchor = document.createElement('div');
        this._anchor.style.cssText = 'position:fixed;left:-9999px;top:-9999px;width:1px;height:1px;pointer-events:none;';
        document.body.appendChild(this._anchor);

        this._pickr = Pickr.create({
            el: this._anchor,
            useAsButton: true,
            appendToBody: true,
            theme: 'nano',
            default: this.element.value || '#000000',
            components: {
                preview: true,
                opacity: false,
                hue: true,
                interaction: { hex: true, input: true, save: false, clear: false },
            },
        });

        this._pickr.on('change', (color) => {
            const hex = color.toHEXA().toString().slice(0, 7).toUpperCase();
            this.element.value = hex;
            this.element.dispatchEvent(new Event('change', { bubbles: true }));
        });
    }
}
