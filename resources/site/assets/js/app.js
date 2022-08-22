import ProductCreateValidate from './productCreateValidate';

export default class Main {
    constructor() {
        this.settings();
    }
    settings() {
        this.bindEvents();
    }
    bindEvents() {
        new ProductCreateValidate();
    }
}

new Main();