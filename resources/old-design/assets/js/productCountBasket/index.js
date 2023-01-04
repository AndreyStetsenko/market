import axios from "axios";

export default class ProductCountBasket {
    constructor() {
        this.settings();
    }
    settings() {
        this.bindEvents();
        const product = document.querySelectorAll('.basket-product-item');
        // this.minus = document.querySelectorAll('.product-basket-minus');
        // this.plus = document.querySelectorAll('.product-basket-plus');
        // this.count = document.querySelectorAll('.product-basket-count');
    }
    bindEvents() {
        const product = document.querySelectorAll('.basket-product-item');

        product.forEach((el) => {
            const minus = el.querySelector('.product-basket-minus');
            const plus = el.querySelector('.product-basket-plus');
            const count = el.querySelector('.product-basket-count');

            minus.addEventListener('submit', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                console.log('Hi bitch');
            })
        });
    }
}