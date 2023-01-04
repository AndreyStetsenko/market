export default class LoadImg {
    constructor() {
        this.settings();
        this.bindEvents();
    }
    settings() {
        this.btn = document.getElementById('load-img');
        this.inp = document.getElementById('image');
        this.file_name = document.getElementById('file_name');
    }
    bindEvents() {
        $(this.btn).on('click', () => {
            $(this.inp).click();
        });

        $(this.inp).on('change', () => {
            this.file_name.innerHTML = '';

            this.inp.files.forEach((el) => {
                this.file_name.innerHTML += `<li>${el.name}</li>`;
            });

            if ($(this.inp).hasClass('error')) {
                $(this.inp).removeClass('error');
                $('.input-error-image').html('');
            }
        });
    }
}
