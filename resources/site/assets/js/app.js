// import ProductCreateValidate from './productCreateValidate';
import ProductCountBasket from './productCountBasket';

export default class Main {
    constructor() {
        this.settings();
    }
    settings() {
        this.bindEvents();
    }
    bindEvents() {
        // new ProductCreateValidate();
        new ProductCountBasket();
    }
}

new Main();