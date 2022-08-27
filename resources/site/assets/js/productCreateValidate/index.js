import $ from 'jquery';
import 'jquery-validation';
import 'jquery-mask-plugin';

export default class productCreateValidate {
    constructor() {
        this.settings();
        this.validatePas();
        this.validate();
        this.mask();
    }
    settings() {
        // Init form
        this.currentForm = document.querySelector('#product-create');

        // Init inputs
        this.upload_file = document.getElementById('upload_file');
        this.name = document.getElementById('name');
        this.price = document.getElementById('price');
        this.category = document.getElementById('category_id');
        this.collection = document.getElementById('price');
        this.item_desc = document.getElementById('item_desc');
    }
    validatePas() {

    }
    validate() {
        const { currentForm } = this;
        // const submit = document.getElementById('submit');

        const inpRequired = 'Это поле обязательно для заполнения';
        const inpLength = 'Введите от 3 до 50 символов';
        const inpLengthPrice = 'Введите сумму до 999999 USD';
        const setCategory = 'Выберите категорию';
        const setDescription = 'Введите описание товара';
        const setImage = 'Добавьте изображение товара';
        // const fileImage = 'Загрузите изображение';

        $(currentForm).validate({
            debug: false,
            errorClass: 'error',
            errorElement: 'span',
            errorPlacement(error, element) {
                const errorContainer = element.closest('.form-group').find('.input-error');
                error.appendTo(errorContainer);
            },
            rules: {
                name: {
                    required: true,
                    rangelength: [3, 50]
                },
                price: {
                    required: true,
                    rangelength: [1, 9]
                },
                category_id: {
                    required: true
                },
                content: {
                    required: true
                },
                image: {
                    required: {
                        param: true,
                        depends() {
                            return $('#check_img').val() === '1';
                        }
                    }
                }
            },
            messages: {
                name: {
                    required: inpRequired,
                    rangelength: inpLength
                },
                price: {
                    required: inpRequired,
                    rangelength: inpLengthPrice
                },
                category_id: {
                    required: setCategory
                },
                content: {
                    required: setDescription
                },
                image: {
                    required: setImage
                }
            }
        });

        // $(currentForm).validate({

        // });
    }
    mask() {
        $(this.name).mask('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX', {
            translation: {
                X: { pattern: /[а-яА-ЯЁёєЄіІїЇґҐa-zA-Z0-9()-_., ]/ }
            }
        });
        $(this.price).mask('999999.99', {
            translation: {
                9: { pattern: /[0-9]/ }
            },
            reverse: true
        });
    }
}
