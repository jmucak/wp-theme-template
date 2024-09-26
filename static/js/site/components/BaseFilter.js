export default class BaseFilter {
    constructor() {
        if (this.constructor === BaseFilter) {
            throw new Error("This is abstract class!");
        }

        this.Base = {
            body: "body",
            isFilterDisabled: "is-filter-disabled",
        };

        this.body = document.querySelector(this.Base.body);
    }

    disableFilter() {
        this.body.classList.add(this.Base.isFilterDisabled);
    }

    enableFilter() {
        this.body.classList.remove(this.Base.isFilterDisabled);
    }

    isFilterInProgress() {
        return this.body.classList.contains(this.Base.isFilterDisabled);
    }

    updateUrls(stateData, url) {
        history.pushState(stateData, document.title, url);
    }
}
