import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    static targets = ['panel', 'toggle']

    connect() {
        // Auto-open if filter params (other than q/page) are present in URL
        const url = new URL(window.location.href)
        const hasActive = [...url.searchParams.entries()]
            .some(([key, val]) => !['q', 'page'].includes(key) && val !== '')
        if (hasActive && this.hasPanelTarget) {
            this._setOpen(true)
        }
    }

    toggle() {
        this._setOpen(this.panelTarget.classList.contains('hidden'))
    }

    _setOpen(open) {
        this.panelTarget.classList.toggle('hidden', !open)
        if (this.hasToggleTarget) {
            this.toggleTarget.toggleAttribute('data-active', open)
        }
    }
}
