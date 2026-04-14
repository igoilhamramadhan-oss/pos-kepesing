<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-500">Kelola stok dan harga barang daganganmu di sini.</p>
        <a href="{{ route('products.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition shadow-md">
            <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah Produk
        </a>
    </div>

    <div class="mb-6 p-4 bg-white rounded-lg shadow-sm border border-gray-100">
        <form wire:submit="importData" class="flex items-end gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Data Produk (Excel/CSV)</label>
                <input type="file" wire:model="file_import" accept=".xlsx, .xls, .csv" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
            </div>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md font-medium transition shadow-sm">
                Mulai Import
            </button>
        </form>
        
        @error('file_import') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        @if (session()->has('pesan'))
            <div class="mt-3 text-sm text-green-600 bg-green-50 p-2 rounded border border-green-200">
                {{ session('pesan') }}
            </div>
        @endif
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-4 py-3 font-medium text-gray-600">SKU</th>
                    <th class="px-4 py-3 font-medium text-gray-600">Nama Barang</th>
                    <th class="px-4 py-3 font-medium text-gray-600">Stok</th>
                    <th class="px-4 py-3 font-medium text-gray-600 text-right">Harga Beli</th>
                    <th class="px-4 py-3 font-medium text-gray-600 text-right">Harga Jual</th>
                    <th class="px-4 py-3 font-medium text-gray-600 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-4 font-mono text-xs text-indigo-600 font-bold uppercase tracking-wider">
                        {{ $product->sku }}
                    </td>
                    <td class="px-4 py-4 text-gray-800 font-medium">
                        {{ $product->name }}
                    </td>
                    <td class="px-4 py-4">
                        <span class="px-2 py-1 {{ $product->stock < 10 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }} rounded-full text-xs font-semibold">
                            {{ $product->stock }} pcs
                        </span>
                    </td>
                    <td class="px-4 py-4 text-right text-gray-500 italic">
                        Rp {{ number_format($product->purchase_price, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-4 text-right font-semibold text-indigo-700">
                        Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-4">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('products.edit',$product) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin mau hapus barang ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-10 text-center text-gray-400">
                        <i data-lucide="package-search" class="w-12 h-12 mx-auto mb-2 opacity-20"></i>
                        Belum ada data barang. Yuk tambah dulu!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>