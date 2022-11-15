<?php

namespace App\Http\Controllers\Admin;

use App\Events\CreatePageEvent;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PagesMeta;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller {
    /**
     * Показывает список всех страниц
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $pages = Page::all();
        return view('admin.page.index', compact('pages'));
    }

    /**
     * Показывает форму для создания страницы
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $parents = Page::where('parent_id', 0)->get();
        $title = 'Создание новой страницы';
        
        return view('admin.page.create', compact('parents', 'title'));
    }

    /**
     * Сохраняет новую страницу в базу данных
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|max:100',
            'parent_id' => 'required|regex:~^[0-9]+$~',
            'slug' => 'required|max:100|unique:pages|regex:~^[-_a-z0-9]+$~i',
            'content' => '',
        ]);
        $page = Page::create($request->all());
        return redirect()
            ->route('admin.page.show', ['page' => $page->id])
            ->with('success', 'Новая страница успешно создана');
    }

    /**
     * Показывает информацию о странице сайта
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page) {
        return view('admin.page.show', compact('page'));
    }

    /**
     * Показывает форму для редактирования страницы
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page) {
        $parents = Page::where('parent_id', 0)->get();
        $title = 'Редактирование страницы';
        $meta = PagesMeta::where('page_id', $page->id)->where('field_type', 'admin_tab')->get();

        return view('admin.page.edit', compact('page', 'parents', 'title', 'meta'));
    }

    /**
     * Обновляет страницу (запись в таблице БД)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page) {
        $this->validate($request, [
            'name' => 'required|max:100',
            'parent_id' => 'required|regex:~^[0-9]+$~|not_in:'.$page->id,
            'slug' => 'required|max:100|unique:pages,slug,'.$page->id.',id|regex:~^[-_a-z0-9/]+$~i',
            'content' => '',
        ]);
        $page->update($request->all());
        return redirect()
            ->route('admin.page.show', ['page' => $page->id])
            ->with('success', 'Страница была успешно отредактирована');
    }

    /**
     * Сохраняет на диск изображения и заменяет атрибут src тегов img
     * <img src="data:image/png;base64,R0lGODlhEAAOALDD..." alt="" />
     * <img src="http://server.com/storage/page/123456.png" alt="" />
     *
     * @param string $content
     * @return string
     */
    private function saveImages($content) {
        $dom = new \DomDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        // loadHTML() считает, что строка в кодировке ISO-8859-1,
        // поэтому указываем явно, что строка в кодировке UTF-8
        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"/></head>';
        $html = $html . '<body>'.$content.'</body></html>';
        $dom->loadHtml($html);
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $img) {
            $data = $img->getAttribute('src');
            if (strpos($data, 'data') === false) {
                continue;
            }
            // <img src="data:image/jpeg;base64,R0lGODlhEAAOAL..." alt="" />
            // data:image/jpeg;base64, data:image/png;base64, data:image/gif
            list($type, $data) = explode(';', $data);
            list(, $ext) = explode('/', $type);
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);
            $name = md5(uniqid(rand(), true)) . '.' . $ext;
            Storage::disk('public')->put('page/' . $name, $data);
            $url = Storage::disk('public')->url('page/' . $name);
            $img->removeAttribute('data-filename');
            $img->removeAttribute('src');
            $img->setAttribute('src', $url);
        }
        $content = html_entity_decode($dom->saveXML($dom->documentElement));
        $content = str_replace(
            [
                '<html><head><meta charset="UTF-8"/></head><body>',
                '</body></html>',
            ],
            '',
            $content
        );
        $content = trim($content);
        return $content;
    }

    /**
     * Загружает изображение, которое было добавлено в wysiwyg-редакторе и
     * возвращает ссылку на него, чтобы в редакторе вставить <img src="…"/>
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadImage(Request $request) {
        $this->validate($request, ['image' => [
            'mimes:jpeg,png',
            'max:5000'
        ]]);
        $path = $request->file('image')->store('page', 'public');
        $url = Storage::disk('public')->url($path);
        return response()->json(['image' => $url]);
    }

    /**
     * Удаляет изображение, которое было удалено в wysiwyg-редакторе
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function removeImage(Request $request) {
        // $path = /storage/page/CW2xtBYIcXDx7d3oJRCLZoZtIhaSFWAS8Qa7WFL3.png
        $path = parse_url($request->image, PHP_URL_PATH);
        $path = str_replace('/storage/', '', $path);
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return 'Изображение было удалено';
        }
        return 'Не удалось удалить изображение';
    }

    /**
     * Удаляет изображения, которые связаны со страницей
     *
     * @param  string $content
     * @return void
     */
    private function removeImages($content) {
        $dom = new \DomDocument();
        $dom->loadHtml($content);
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            $pattern = '~/storage/page/([0-9a-z]+\.(jpeg|png|gif))~i';
            if (preg_match($pattern, $src, $match)) {
                $name = $match[1];
                if (Storage::disk('public')->exists('page/' . $name)) {
                    Storage::disk('public')->delete('page/' . $name);
                }
            }
        }
    }

    public function addCustom(Request $request)
    {
        function createUrlSlug($urlString)
        {
            $slug = preg_replace('/[^A-Za-z0-9-]+/', '_', $urlString);
            $slugMin = strtolower($slug);
            return $slugMin;
        }

        $name = $request->name;
        $slug = createUrlSlug($request->name);
        $type = $request->type;

        $data = [
            'page_id' => $request->page_id,
            'name' => $slug,
            'value' => $name,
            'field_type' => $request->field_type
        ];

        PagesMeta::create($data);

        return back();
    }

    public function addCustomFields(Request $request)
    {
        function createUrlSlug($urlString)
        {
            $slug = preg_replace('/[^A-Za-z0-9-]+/', '_', $urlString);
            $slugMin = strtolower($slug);
            return $slugMin;
        }

        // dd($request);

        foreach ($request->name as $i => $item) {
            if ($request->id[$i] != 0) {
                $createdMeta = PagesMeta::find($request->id[$i]);

                if ($request->val[$i] != $createdMeta->value) {
                    $createdMeta->value = $request->val[$i];
                    $createdMeta->update();
                }
            } else {

                if ($request->field_type[$i] == 'products') {
                    $resValue = implode(',',$request->products);
                } else {
                    $resValue = $request->val[$i];
                }

                $data = [
                    'page_id' => $request->page_id,
                    'name' => createUrlSlug($request->name[$i]),
                    'value' => $resValue,
                    'parent_id' => $request->parent_id,
                    'field_type' => $request->field_type[$i]
                ];
    
                PagesMeta::create($data);
            }
        }

        return back();
    }

    public function removeCustomFields(Request $request, $id)
    {
        PagesMeta::destroy($id);
        
        return response()->json('Ok');
    }

    /**
     * Удаляет страницу (запись в таблице БД)
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page) {
        if ($page->children->count()) {
            return back()->withErrors('Нельзя удалить страницу, у которой есть дочерние');
        }
        $this->removeImages($page->content);
        $page->delete();
        return redirect()
            ->route('admin.page.index')
            ->with('success', 'Страница сайта успешно удалена');
    }
}
