import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = {
        hiddenLabel:   { type: String, default: '' },
        visibleLabel:  { type: String, default: '' },
        hiddenIcon:    { type: String, default: 'Default' },
        visibleIcon:   { type: String, default: 'Default' },
        buttonClasses: { type: Array,  default: [] },
    };

    connect() {
        this._visible = false;

        this.element.classList.add('pr-10');

        this._button = document.createElement('button');
        this._button.type = 'button';
        this._button.tabIndex = -1;

        if (this.buttonClassesValue.length) {
            this._button.classList.add(...this.buttonClassesValue);
        }

        this._render();
        this._button.addEventListener('click', () => this._toggle());
        this.element.insertAdjacentElement('afterend', this._button);
    }

    _toggle() {
        this._visible = !this._visible;
        this.element.type = this._visible ? 'text' : 'password';
        this._render();
    }

    _render() {
        const iconStr = this._visible ? this.visibleIconValue : this.hiddenIconValue;
        const label   = this._visible ? this.visibleLabelValue : this.hiddenLabelValue;

        this._button.innerHTML = (iconStr === 'Default' || !iconStr)
            ? (this._visible ? this._eyeSvg() : this._eyeOffSvg())
            : iconStr;

        if (label) {
            this._button.insertAdjacentHTML('beforeend', `<span class="sr-only">${label}</span>`);
        }

        this._button.setAttribute('aria-label', label || (this._visible ? 'Masquer le mot de passe' : 'Afficher le mot de passe'));
    }

    _eyeSvg() {
        return `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>`;
    }

    _eyeOffSvg() {
        return `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" y1="2" x2="22" y2="22"/></svg>`;
    }
}