@php
    $emptyMessage = $emptyMessage ?? 'No records found.';
    $tableClasses = $tableClasses ?? 'table text-center table-hover align-middle';
    $theadClasses = $theadClasses ?? 'table-primary';
    $fields = $fields ?? [];
    $actionsView = $actionsView ?? null;
@endphp

<table class="{{ $tableClasses }}">
    <thead class="{{ $theadClasses }}">
        <tr>
            @foreach ($fields as $field)
                <th>{{ ucwords(str_replace('_', ' ', $field)) }}</th>
            @endforeach
            @if ($actionsView)
                <th>Actions</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @if (count($items) === 0)
            <tr>
                <td colspan="{{ count($fields) + ($actionsView ? 1 : 0) }}" class="text-center">
                    {{ $emptyMessage }}
                </td>
            </tr>
        @else
            @foreach ($items as $item)
                <tr>
                    @foreach ($fields as $field)
                        <td>{{ $item->$field }}</td>
                    @endforeach
                    @if ($actionsView)
                        <td>
                            @include($actionsView, ['item' => $item])
                        </td>
                    @endif
                </tr>
            @endforeach
        @endif
    </tbody>
</table>