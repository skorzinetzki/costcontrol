<tr>
    <td>{{ $category->name }}</td>
    <td>
        @if ($category->hasSuperiorCategory())
            (in {{ $category->superiorCategory->name }})
        @endif
    </td>
    <td class="text-right">
        <span class="badge">{{ $category->subordinateCategories->count() }}</span>
    </td>
    <td>
        <a href="/categories/{{ $category->id }}" class="btn btn-default btn-sm" title="Show {{ $category->name }}"><span class="glyphicon glyphicon-list-alt"></span></a>
        <a href="/categories/{{ $category->id }}/edit" class="btn btn-default btn-sm" title="Edit {{ $category->name }}"><span class="glyphicon glyphicon-wrench"></span></a>
        <a href="/categories/{{ $category->id }}/delete" class="btn btn-danger btn-sm" title="Delete {{ $category->name }}"><span class="glyphicon glyphicon-trash"></span></a>
    </td>
</tr>