import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['menu'];

    toggle() {
        this.menuTarget.classList.toggle('hidden');
    }

    close() {
        this.menuTarget.classList.add('hidden');
    }

    closeOnClickOutside({ target }) {
        if (!this.element.contains(target)) {
            this.close();
        }
    }
}