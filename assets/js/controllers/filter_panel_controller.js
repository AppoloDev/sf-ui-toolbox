import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    static targets = ['panel', 'toggle']

    get _storageKey() {
        return `filter-panel:${window.location.pathname}`
    }

    connect() {
        const url = new URL(window.location.href)
        const hasActive = [...url.searchParams.entries()]
            .some(([key, val]) => !['q', 'page'].includes(key) && val !== '')
        const storedOpen = sessionStorage.getItem(this._storageKey) === '1'

        if ((hasActive || storedOpen) && this.hasPanelTarget) {
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
        if (open) {
            sessionStorage.setItem(this._storageKey, '1')
        } else {
            sessionStorage.removeItem(this._storageKey)
        }
    }
}
