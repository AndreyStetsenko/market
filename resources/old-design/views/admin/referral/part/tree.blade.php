@php($level++)
@foreach($pages->where('parent_id', $parent) as $page)
    <tr>
        <td>{{ $page->id }}</td>
        <td>
            @if ($level)
                {{ str_repeat('—', $level) }}
            @endif
            <a href="{{ route('admin.page.show', ['page' => $page->id]) }}"
               style="font-weight:@if($level) normal @else bold @endif">
                {{ $page->name }}
            </a>
        </td>
        <td>{{ $page->slug }}</td>
        <td class="table-report__action w-56">
            <div class="flex justify-center items-center">
                <a href="{{ route('admin.page.edit', ['page' => $page->id]) }}">
                    <i data-feather="edit" class="w-4 h-4 mr-1"></i>
                </a>

                <form action="{{ route('admin.page.destroy', ['page' => $page->id]) }}"
                    method="post" onsubmit="return confirm('Удалить эту страницу?')" style="margin-bottom: 0">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                      <i data-feather="trash-2" class="w-4 h-4 mr-1 text-danger"></i>
                  </button>
              </form>
            </div>
        </td>
    </tr>
    @if (count($pages->where('parent_id', $parent)))
        @include('admin.page.part.tree', ['level' => $level, 'parent' => $page->id])
    @endif
@endforeach
