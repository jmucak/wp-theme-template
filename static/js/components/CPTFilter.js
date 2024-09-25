export default class CPTFilter {
    constructor(data = {}) {
        this.DOM = {
            container: ".js-cpt-filter-container",
            filter: ".js-cpt-filter",
        }

        this.container = document.querySelector(this.DOM.container);
        this.filters = document.querySelectorAll(this.DOM.filter);
    }

    init() {
        if (this.container) {

        }
    }
}