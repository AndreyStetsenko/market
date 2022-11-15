jQuery(document).ready(function($) {
    /*
     * Общие настройки ajax-запросов, отправка на сервер csrf-токена
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    /*
     * Автоматическое создание slug при вводе name (замена кириллицы на латиницу)
     */
    $('input[name="name"]').on('input', function() {
        var map = {
            'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D', 'Е': 'E', 'Ё': 'Yo', 'Ж': 'Zh',
            'З': 'Z', 'И': 'I', 'Й': 'J', 'К': 'K', 'Л': 'L', 'М': 'M', 'Н': 'N', 'О': 'O',
            'П': 'P', 'Р': 'R', 'С': 'S', 'Т': 'T', 'У': 'U', 'Ф': 'F', 'Х': 'H', 'Ц': 'C',
            'Ч': 'Ch', 'Ш': 'Sh', 'Щ': 'Sh', 'Ъ': '', 'Ы': 'Y', 'Ь': '', 'Э': 'E', 'Ю': 'Yu',
            'Я': 'Ya',
            'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo', 'ж': 'zh',
            'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o',
            'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'c',
            'ч': 'ch', 'ш': 'sh', 'щ': 'sh', 'ъ': '', 'ы': 'y', 'ь': '', 'э': 'e', 'ю': 'yu',
            'я': 'ya',
        };
        var text = $(this).val();
        for (var k in map) {
            text = text.replace(RegExp(k, 'g'), map[k]);
        }
        text = text.replace(/[^- _a-zA-Z0-9]/g, '');
        text = text.replace(/\s+/g, '-');
        text = text.replace(/-+/g, '-');
        $('input[name="slug"]').val(text);
    });
    /*
     * Подключение wysiwyg-редактора для редактирования контента страницы
     */
    // $('textarea[id="editor"]').summernote({
    //     lang: 'ru-RU',
    //     height: 300,
    //     callbacks: {
    //         /*
    //          * При вставке изображения загружаем его на сервер
    //          */
    //         onImageUpload: function(images) {
    //             for (var i = 0; i < images.length; i++) {
    //                 uploadImage(images[i], this);
    //             }
    //         },
    //         /*
    //          * При удалении изображения удаляем его на сервере
    //          */
    //         onMediaDelete: function(target) {
    //             removeImage(target[0].src);
    //         }
    //     }
    // });
    // /*
    //  * Загружает на сервер вставленное в редакторе изображение
    //  */
    // function uploadImage(image, textarea) {
    //     var data = new FormData();
    //     data.append('image', image);
    //     $.ajax({
    //         data: data,
    //         type: 'POST',
    //         url: '/admin/page/upload/image',
    //         cache: false,
    //         contentType: false,
    //         processData: false,
    //         dataType: 'json',
    //         success: function(data) {
    //             $(textarea).summernote('insertImage', data.image, function ($img) {
    //                 $img.css('max-width', '100%');
    //             });
    //         },
    //         error: function (reject) {
    //             $.each(reject.responseJSON.errors, function (key, value) {
    //                 alert(value);
    //             });
    //         }
    //     });
    // }
    /*
     * Удаляет на сервере удаленное в редакторе изображение
     */
    function removeImage(src) {
        $.ajax({
            data: {'image': src, '_method': 'DELETE'},
            type: 'POST',
            url: '/admin/page/remove/image',
            cache: false,
            success: function(data) {
                console.log(data);
            }
        });
    }

    /**
     * Добавление кастомных полей на страницу
     */
    // $('#addCustom').on('click', () => {
    //     const val_custom = $('#val_custom').val();
        
    //     addCustomVals(val_custom);
    // });

    // function addCustomVals(val_custom) {
    //     var route = "/admin/page/add/custom-field";

    //     $.ajax({
    //         url: route,
    //         headers: {
    //             'X-Requested-With': 'XMLHttpRequest',
    //             'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    //         },
    //         data: {
    //             page_id: $('#cust_page_id').val(),
    //             type: $('#cust_type').val(),
    //             val_custom
    //         },
    //         method: 'POST',
    //         success: (res) => {                    
    //             console.log(res);

    //             const navTabs = $('#nav-tab');
    //             var tab = `<button class="nav-link active" id="${res.name}" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">${val_custom}</button>`;

    //             navTabs.html(tab);
    //         },
    //         error: (err) => {
    //             console.log(err);
    //         }
    //     });
    // }

    var itemX = 0;
    const btnCreate = document.querySelectorAll('.create-field');

    btnCreate.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();

            const btnData = btn.getAttribute('data-field');

            addInput(btnData);
        });
    });

    function addInput(btnData) {

        var field = '<input type="text" name="val[]" class="form-control ml-2" placeholder="Значение">';

        switch (btnData) {
            case 'string':
                field = '<input type="text" name="val[]" class="form-control ml-2" placeholder="Значение">';
                break;

            case 'longtext':
                field = '<textarea name="val[]" class="form-control ml-2" placeholder="Значение"></textarea>';
                break;

            case 'img':
                field = '<input type="file" name="val[]" class="form-control ml-2" placeholder="Значение">';
                break;

            case 'products':
                var rand = getRandomInt(938234);
                loadProducts(rand);
                field = `
                <select class="js-example-basic-multiple ml-2 form-control" id="mu-${rand}" name="products[]" multiple=""></select>`;
                break;
        
            default:
                field = '<input type="text" name="val[]" class="form-control ml-2" placeholder="Значение">';
                break;
        }

        if (itemX < 25) {
            var str = `
            <div class="flex mt-3">
                <input type="text" name="name[]" class="form-control" placeholder="Имя" value="">
                ${field}
                <input type="hidden" name="field_type[]" value="${btnData}">
                <input type="hidden" name="id[]" value="0">
            </div>
            <div id="input${(itemX + 1)}"></div>`;

            document.getElementById('input' + itemX).innerHTML = str;
            itemX++;

            console.log(btnData);
        } else {
            alert('STOP it!');
        }
    }

    const btnDelete = document.querySelectorAll('.remove-field');

    btnDelete.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();

            const btnData = btn.getAttribute('data-delete');

            removeMeta(btnData);
        });
    });

    function removeMeta(id) {
        var route = "/admin/page/remove/custom-fields/" + id;

        $.ajax({
            url: route,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            success: (res) => {                    
                console.log(res);
                $('#meta-' + id).html('');
            },
            error: (err) => {
                console.log(err);
            }
        });
    }

    function getRandomInt(max) {
        return Math.floor(Math.random() * max);
    }

    function loadProducts(rand) {
        var route = "/products/get";

        $.ajax({
            url: route,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            method: 'GET',
            success: (res) => {                    
                res.products.forEach(el => {
                    $('#mu-' + rand).prepend(`<option value="${el.id}">${el.name}</option>`);
                });
            },
            error: (err) => {
                console.log(err);
            }
        });
    }
});