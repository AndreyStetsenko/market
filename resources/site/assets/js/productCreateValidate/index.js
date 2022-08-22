import "jquery";

export default class productCreateValidate {
    constructor() {
        this.settings();
    }
    settings() {
        this.bindEvents();
    }
    bindEvents() {
        const form = document.getElementById('product-create');

        form.addEventListener('submit', (e) => {
            e.preventDefault();

            var alerts = form.querySelectorAll('.alert-err');
            this.removeAlerts(alerts);

            var name = form.querySelector('input[name="name"]');
            var price = form.querySelector('input[name="price"]');
            var content = form.querySelector('textarea[name="content"]');
            var image = form.querySelector('input[name="image"]');
            var category = form.querySelector('select[name="category_id"]');

            image?.value === '' ? this.checkValid('Добавьте изображение товара', image) : '';
            name?.value === '' ? this.checkValid('Поле не может быть пустым', name) : '';
            content?.value === '' ? this.checkValid('Поле не может быть пустым', content) : '';
            price?.value === '' ? this.checkValid('Поле не может быть пустым', price) : '';
            category?.value === '0' ? this.checkValid('Поле не может быть пустым', category) : '';
        })
    }
    alertError(cont) {
        var alert = `
        <div class="alert alert-danger alert-err">
            ${cont}
        </div>
        `;

        return alert;
    }
    checkValid(cont, input) {
        input.insertAdjacentHTML('afterEnd', this.alertError(cont));
    }
    removeAlerts(alerts) {
        alerts.forEach(el => {
            el.remove();
        });

        if ( alerts.length === 0 ) {
            console.log(alerts.length);
        }
    }
}