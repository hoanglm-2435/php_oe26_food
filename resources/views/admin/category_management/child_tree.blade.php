<option value="{{ $child_category->id }}">{{ $level }} {{ $child_category->name }}</option>
@if ($child_category->childrens)
    <ul>
        @foreach ($child_category->childrens as $childCategory)
            @include('admin.category_management.child_tree', ['child_category' => $childCategory, 'level' => $level . '--'])
        @endforeach
    </ul>
@endif
