import $ from 'jquery';
import 'jquery-validation';
import 'jquery-mask-plugin';

export default class productCreateValidate {
    constructor() {
        this.settings();
        this.validate();
        this.mask();
    }
    settings() {
        // Init form
        this.currentForm = document.querySelector('#checkout');

        // Init inputs
        this.name = document.getElementById('name');
        this.email = document.getElementById('email');
        this.phone = document.getElementById('phone');
        this.address = document.getElementById('address');
        this.comment = document.getElementById('comment');
    }
    validate() {
        const { currentForm } = this;

        const inpRequired = 'Это поле обязательно для заполнения';
        const inpName = 'Введите от 3 до 50 знаков';
        const inpEmail = 'Не верный формат Email адреса';
        const inpEmailRange = 'Введите от 3 до 50 знаков';
        const inpPhone = 'Введите от 10 до 12 цифр';
        const inpComment = 'Введите от 2 до 125 знаков';
        const inpAddress = 'Введите от 3 до 50 знаков';

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
                    rangelength: [2, 50]
                },
                email: {
                    required: true,
                    email: true,
                    rangelength: [3, 50]
                },
                phone: {
                    required: true,
                    rangelength: [11, 13]
                },
                address: {
                    required: true,
                    rangelength: [3, 50]
                },
                comment: {
                    required: true,
                    rangelength: [2, 125]
                }
            },
            messages: {
                name: {
                    required: inpRequired,
                    rangelength: inpName
                },
                email: {
                    required: inpRequired,
                    email: inpEmail,
                    rangelength: inpEmailRange
                },
                phone: {
                    required: inpRequired,
                    rangelength: inpPhone
                },
                address: {
                    required: inpRequired,
                    rangelength: inpAddress
                },
                comment: {
                    required: inpRequired,
                    rangelength: inpComment
                }
            }
        });
    }
    mask() {
        $(this.name).mask('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX', {
            translation: {
                X: { pattern: /[а-яА-ЯЁёєЄіІїЇґҐa-zA-Z0-9()-_., ]/ }
            }
        });
        $(this.email).mask('X', {
            translation: {
                X: { pattern: /[\w@\-.+]/, recursive: true }
            },
            reverse: true
        });
        $(this.phone).mask('+XXXXXXXXXXXX', {
            translation: {
                X: { pattern: /[0-9]/ }
            }
        });
    }
}
