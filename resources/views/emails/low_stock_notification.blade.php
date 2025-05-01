<!DOCTYPE html>
<html>
<head>
    <title>Peringatan Stok Minimum</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Peringatan Stok Minimum</h2>
    <p>Berikut daftar produk yang stoknya mencapai batas minimum:</p>
    
    <table>
        <thead>
            <tr>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Stok Saat Ini</th>
                <th>Stok Minimum</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['products'] as $product)
                <tr>
                    <td>{{ $product['kode_produk'] ?? 'N/A' }}</td>
                    <td>{{ $product['nama_produk'] ?? 'N/A' }}</td>
                    <td>{{ $product['stok'] ?? 'N/A' }}</td>
                    <td>{{ $product['min_stok'] ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <p>Silakan lakukan restock segera untuk menghindari kehabisan stok.</p>
    
    <p>Email ini dikirim otomatis pada: {{ $data['date'] }}</p>
</body>
</html>