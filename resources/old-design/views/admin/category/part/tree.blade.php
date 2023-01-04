@php($level++)
@foreach ($items->where('parent_id', $parent) as $item)
    <tr class="intro-x">
        <td class="w-72">
            @if ($level)
                {{ str_repeat('—', $level) }}
            @endif
            <a href="{{ route('admin.category.show', ['category' => $item->id]) }}"
               style="font-weight:@if($level) normal @else bold @endif">
                {{ $item->name }}
            </a>
        </td>
        <td>
            {{ iconv_substr($item->content, 0, 50) }}
        </td>
        <td class="table-report__action w-56">
            <div class="flex justify-center items-center">
                <a href="{{ route('admin.category.edit', ['category' => $item->id]) }}">
                    <i data-feather="edit" class="w-4 h-4 mr-1"></i>
                </a>

                <form action="{{ route('admin.category.destroy', ['category' => $item->id]) }}"
                    method="post" onsubmit="return confirm('Удалить эту категорию?')" style="margin-bottom: 0">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                      <i data-feather="trash-2" class="w-4 h-4 mr-1 text-danger"></i>
                  </button>
              </form>
            </div>
        </td>
    </tr>
    @if (count($items->where('parent_id', $parent)))
        @include('admin.category.part.tree', ['level' => $level, 'parent' => $item->id])
    @endif
@endforeach
