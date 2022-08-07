<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Helpers\ImageSaver;

class CollectionController extends Controller
{
    private $imageSaver;

    public function __construct(ImageSaver $imageSaver) {
        $this->imageSaver = $imageSaver;
    }

    public function create() {
        return view('site.user.collection.create');
    }

    public function store(Request $request) {
        $collection = new Collection();
        $collection->user_id = auth()->user()->id;
        $collection->name = $request->name;
        $collection->slug = $request->slug;
        $collection->description = $request->content;
        $collection->image = $this->imageSaver->upload($request, null, 'collection');
        $collection->status = 1;
        $collection->save();

        return redirect()
            ->route('user.profile', auth()->user()->id)
            ->with('success', 'Новая коллекция успешно создана');
    }

    public function edit(Collection $collection) {
        return view('site.user.collection.edit', compact('collection'));
    }

    public function update(Request $request, Collection $collection) {
        $collection->name = $request->name;
        $collection->slug = $request->slug;
        $collection->description = $request->content;
        if ($request->image) $collection->image = $this->imageSaver->upload($request, null, 'collection');
        $collection->status = 1;
        $collection->update();

        return redirect()
            ->route('user.collection.edit', $collection->id)
            ->with('success', 'Коллекция успешно обновлена');
    }
}
