import ProductCreateValidate from './productCreateValidate';
import LoadImg from './loadImg';
// import transliteration from './transliteration';
// import ProductCountBasket from './productCountBasket';

export default class Main {
    constructor() {
        this.settings();
    }
    settings() {
        this.bindEvents();
    }
    bindEvents() {
        new ProductCreateValidate();
        // new ProductCountBasket();
        new LoadImg();
        // transliteration();
    }
}

new Main();
