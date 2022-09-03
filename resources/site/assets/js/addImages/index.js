import Sortable from 'sortablejs';

window.Sortable = Sortable;

export default class AddImages {
    constructor() {
        this.settings();
        this.addImage();
        this.removeImage();
        this.elemDrag();
    }
    settings() {
        this.fileContainer = document.querySelector('.add-images-wrap');
        this.fileContainerParent = document.querySelector('.add-images');
        this.btn = document.querySelector('.form-file-btn');
        this.inputsMax = 6;
        this.previewImg = document.getElementById('get_file_2');
    }
    addImage() {
        this.btn.addEventListener('click', () => {
            this.checkImgNotNull();

            // Создаем блок в который вставляем все элементы
            const elemCont = document.createElement('li');
            elemCont.classList.add('form-file-add');
            elemCont.classList.add('d-none');
            // elemCont.setAttribute('draggable', true);
            let dataAttrBtn = document.querySelector('.form-file-btn').getAttribute('data-imgs');
            dataAttrBtn = parseInt(dataAttrBtn, 10);
            elemCont.setAttribute('id', `draggable-${dataAttrBtn + 1}`);

            // span внутри контейнера elemCont
            const contSpan = document.createElement('span');
            contSpan.classList.add('cont');

            // Иконка внутри контейнера contSpan
            const contSpanIco = document.createElement('i');
            contSpanIco.classList.add('fa');
            contSpanIco.classList.add('fa-plus');

            // input file внутри контейнера elemCont
            const elemInput = document.createElement('input');
            elemInput.classList.add('fileimg-inp');
            elemInput.setAttribute('type', 'file');
            elemInput.setAttribute('name', 'filename[]');

            // Кнопка удаления внутри elemCont
            const btnClose = document.createElement('button');
            btnClose.classList.add('remove');
            btnClose.setAttribute('type', 'button');

            // Иконка внутри кнопки btnClose
            const btnCloseIco = document.createElement('i');
            btnCloseIco.classList.add('fa');
            btnCloseIco.classList.add('fa-close');

            elemCont.appendChild(elemInput); // В основной контейнер вставляем input file
            elemCont.appendChild(contSpan); // В основной контейнер вставляем span
            contSpan.appendChild(contSpanIco); // В span вставляем иконку
            elemCont.appendChild(btnClose); // В основной контейнер вставляем btn close
            btnClose.appendChild(btnCloseIco); // В кнопку удаления вставляем иконку
            this.fileContainerParent.prepend(elemCont);

            elemInput.click();

            elemInput.addEventListener('change', () => {
                if (elemInput.files && elemInput.files[0]) {
                    this.fileContainer.prepend(elemCont);
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        elemCont.style.backgroundImage = `url(${e.target.result})`; // Добавляем картинку к блоку
                        elemCont.classList.add('true');
                        elemCont.classList.remove('d-none');

                        $('#get_file_2').attr('src', e.target.result);
                        $('#imgOnCheck').val('1');
                        $('#imgOnCheck-error').css('display', 'none');
                    };

                    reader.readAsDataURL(elemInput.files[0]);
                }

                const formFileAdd = document.querySelectorAll('.form-file-add');

                if (formFileAdd.length >= this.inputsMax) {
                    this.btn.classList.add('d-none');
                }
            });
        });
    }
    removeImage() {
        $(this.fileContainer).on('click', '.remove', function() {
            const parent = $(this).parent();
            const formFilesAdd = document.querySelector('.add-images-wrap');
            const formFileAdd = formFilesAdd.querySelectorAll('.form-file-add');
            // const allFiles = document.querySelectorAll('.fileimg-inp');

            parent.remove();

            formFileAdd.forEach((jo) => {
                if (jo.querySelector('input').files[0].name === parent.find('input')[0].files[0].name) {
                    const items = $('.add-images-wrap').find('.form-file-add').first().find('input');
                    if (items[1]?.files && items[1]?.files[0]) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            $('#get_file_2').attr('src', e.target.result);
                        };

                        reader.readAsDataURL(items[1].files[0]);
                    }
                } else {
                    const items = $('.add-images-wrap').find('.form-file-add').first().find('input');
                    if (items[0]?.files && items[0]?.files[0]) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            $('#get_file_2').attr('src', e.target.result);
                        };

                        reader.readAsDataURL(items[0].files[0]);
                    }
                }
            });

            $('.form-file-btn').removeClass('d-none');

            if (formFileAdd.length === 1) {
                $('#imgOnCheck').val('');
                $('#get_file_2').attr('src', 'https://market-n.test/site/images/collections/coll-item-3.jpg');
            }
        });
    }
    elemDrag() {
        const el = document.querySelector('.add-images-wrap');

        new Sortable(el, {
            animation: 150,
            ghostClass: 'ghost',

            onEnd() {
                const allFiles = document.querySelectorAll('.fileimg-inp');
                allFiles.forEach((item) => {
                    if (!item.files || !item.files[0]) {
                        item.parentElement.remove();
                    }
                });

                const items = $('.add-images-wrap').find('.form-file-add').find('input');

                if (items[0]?.files && items[0]?.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        $('#get_file_2').attr('src', e.target.result);
                    };

                    reader.readAsDataURL(items[0].files[0]);
                }
            }
        });
    }
    checkImgNotNull() {
        const allFiles = document.querySelectorAll('.fileimg-inp');
        allFiles.forEach((el) => {
            if (!el.files || !el.files[0]) {
                el.parentElement.remove();
            }
        });
    }
}
