/**
 * MAIN JS FILE
 */

/**
 * Components
 */
import "instant.page";
import Lazy from "./components/Lazy";
import Navigation from "./components/Navigation";

/**
 * Check if document is ready cross-browser
 * @param callback
 */
const ready = (callback) => {
    if (document.readyState !== "loading") {
        /**
         * Document is already ready, call the callback directly
         */
        callback();
    } else if (document.addEventListener) {
        /**
         * All modern browsers to register DOMContentLoaded
         */
        document.addEventListener("DOMContentLoaded", callback);
    } else {
        /**
         * Old IE browsers
         */
        document.attachEvent("onreadystatechange", function () {
            if (document.readyState === "complete") {
                callback();
            }
        });
    }
};

/**
 * Document ready callback
 */
ready(() => {
    /**
     * COMPONENTS
     */

    /**
     * Lazy
     * @type {Lazy}
     */
    const lazy = new Lazy();
    lazy.init();

    /**
     * Navigation
     * @type {Navigation}
     */
    const navigation = new Navigation();
    navigation.init();
});
