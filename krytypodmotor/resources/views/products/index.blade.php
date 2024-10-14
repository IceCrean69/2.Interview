<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produkty - Kryty pod motor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    
</head>
<body>
    <div class="container mt-4">
        <h1>Produkty - Kryty pod motor</h1>

        <form action="{{ route('products.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <select name="brand" class="form-select">
                        <option value="">Všechny značky</option> 
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="material" class="form-select">
                        <option value="">Všechny materiály</option>
                        @foreach($materials as $material)
                            <option value="{{ $material->id }}" {{ request('material') == $material->id ? 'selected' : '' }}>
                                {{ $material->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filtrovat</button>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('products.export', request()->query()) }}" class="btn btn-success">Export do CSV</a>
                </div>
            </div>
        </form>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>
                        <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'code', 'direction' => $sort === 'code' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                            Kód
                            @if($sort === 'code')
                                {!! $direction === 'asc' ? '&#9650;' : '&#9660;' !!}
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => $sort === 'name' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                            Název
                            @if($sort === 'name')
                                {!! $direction === 'asc' ? '&#9650;' : '&#9660;' !!}
                            @endif
                        </a>
                    </th>
                    <th>Značka</th>
                    <th>Materiál</th>
                    <th>
                        <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'price', 'direction' => $sort === 'price' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                            Cena
                            @if($sort === 'price')
                                {!! $direction === 'asc' ? '&#9650;' : '&#9660;' !!}
                            @endif
                        </a>
                    </th>
                    <th>Akce</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product -> code }}</td>
                        <td>{{ $product -> name }}</td>
                        <td>{{ $product -> brand -> name }}</td>
                        <td>{{ $product -> material -> name }}</td>
                        <td>{{ number_format($product -> price, 2, ',', ' ') }} Kč</td>
                        <td>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-primary">Upravit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $products -> links() }}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>