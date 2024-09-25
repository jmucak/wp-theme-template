import axios from "axios";
import BaseFilter from "./BaseFilter";

export default class CPTFilter extends BaseFilter {
    constructor(data = {}) {
        super();

        this.DOM = {
            container: ".js-cpt-filter-container",
            filter: ".js-cpt-filter",
            pagination: ".js-pagination-item",
            search: ".js-search"
        }

        this.container = document.querySelector(this.DOM.container);
        this.url = frontend_rest_object.rest_url + frontend_rest_object.route_cpt;
    }

    init() {
        if (this.container) {
            this.postType = this.container?.dataset.postType;
            this.relation = this.container?.dataset.relation;
            this.permalink = this.container?.dataset.permalink;

            this.initPagination();
            this.initFilters();
        }
    }

    initPagination() {
        let pagination = document.querySelectorAll(this.DOM.pagination);

        if (pagination) {
            pagination.forEach((link) => {
                link.addEventListener("click", (ev) => {
                    ev.preventDefault();

                    this.ajaxCall({
                        paged: link.dataset.val,
                    });
                });
            })
        }
    }

    initSearch() {
        let search = document.querySelector(this.DOM.search);

        if (search) {
            search.addEventListener("keyup", (ev) => {
                ev.preventDefault();

                console.log(search.value);
            });
        }
    }

    initFilters() {
        let filters = document.querySelectorAll(this.DOM.filter);

        if (filters) {
            filters.forEach((filter) => {
                if (filter.tagName.toLowerCase() === "select") {
                    filter.addEventListener("change", (ev) => {

                        this.ajaxCall({
                            paged: 1,
                            genre: ev.target.value,
                        });
                    });
                } else if (filter.tagName.toLowerCase() === 'input' && filter.type === 'checkbox') {
                    filter.addEventListener("change", (ev) => {

                        this.ajaxCall({
                            paged: 1,
                            genre: filter.value,
                        });
                    });
                }
            });
        }
    }

    getFilters() {
        let filters = document.querySelectorAll(this.DOM.filter);
        let data = [];

        if (filters) {
            filters.forEach((filter) => {
                if (filter.tagName.toLowerCase() === "select") {
                    console.log(filter.options[filter.selectedIndex].value);

                    data.push({
                        type: "genre",
                        value: filter.options[filter.selectedIndex].value
                    });
                } else if (filter.tagName.toLowerCase() === 'input' && filter.type === 'checkbox') {
                    if (filter.checked) {
                        let value = filter.value;
                        if (data.type === "genre" && !data.value.includes(filter.value)) {
                            value += "," + data.value;
                        }

                        if(data.type === "genre" && data.value.includes(filter.value)) {
                            return;
                        }

                        data.push({
                            type: "genre",
                            value: value,
                        });
                    }
                }
            });
        }

        // Create an object to group values by type
        const result = data.reduce((acc, current) => {
            // If the type doesn't exist in the accumulator, initialize it
            if (!acc[current.type]) {
                acc[current.type] = current.value;
            } else if (!acc[current.type].includes(current.value)) {
                // If the value is not already in the list, append it
                acc[current.type] += `,${current.value}`;
            }
            return acc;
        }, {});

        // Convert the object back into an array of objects
        // console.log();

        return Object.keys(result).map(key => ({
            type: key,
            value: result[key]
        }));
    }

    ajaxCall(data = {}) {
        if (this.isFilterInProgress()) {
            return;
        }

        this.disableFilter();

        data.post_type = this.postType;
        data.relation = this.relation;
        data.permalink = this.permalink;

        let filters = this.getFilters();

        if (filters) {
            filters.forEach((filter) => {
                data[filter.type] = filter.value;
            });
        }


        axios.get(this.url, {
            params: data
        }).then((res) => {
            this.afterAjaxCall(res.data);
        });
    }

    afterAjaxCall(data) {
        if (data.html) {
            this.container.innerHTML = data.html;
        }

        if (data.url) {
            this.updateUrls({}, data.url);
        }

        this.enableFilter();
        this.initPagination();
        this.initFilters();
    }
}