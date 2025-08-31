<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Items Export - {{ date('Y-m-d') }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; margin-bottom: 20px; }
        .filters { margin-bottom: 20px; }
        .filters div { margin-bottom: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>MDM System - Items Export</h1>
        <p>Generated on: {{ date('Y-m-d H:i:s') }}</p>
    </div>

    @if($search || $status)
    <div class="filters">
        <h3>Applied Filters:</h3>
        @if($search)
        <div><strong>Search:</strong> {{ $search }}</div>
        @endif
        @if($status)
        <div><strong>Status:</strong> {{ $status }}</div>
        @endif
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Status</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $item->code }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->brand->name ?? 'N/A' }}</td>
                <td>{{ $item->category->name ?? 'N/A' }}</td>
                <td>{{ $item->status }}</td>
                <td>{{ $item->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: center; font-size: 11px;">
        <p>Total Items: {{ $items->count() }}</p>
    </div>
</body>
</html>
