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

    <!-- Buat Searching -->
    <div class="mb-4 flex justify-end">
        <div class="relative w-full md:w-1/3">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
            </div>
            <input type="text" wire:model.live="search" placeholder="Cari nama obat atau kategori..." 
                class="bg-white border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5 outline-none transition shadow-sm">
        </div>
    </div>
    
    <!-- Tabel -->
    <div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-xs font-bold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-4">SKU</th>
                        <th class="px-6 py-4">Nama & Kategori</th>
                        <th class="px-6 py-4 text-center">Stok</th>
                        <th class="px-6 py-4 text-center">Kadaluarsa</th>
                        <th class="px-6 py-4 text-right">Harga Beli</th>
                        <th class="px-6 py-4 text-right">Harga Jual</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                    @forelse($products as $product)
                    <tr class="hover:bg-indigo-50/60 transition duration-150 ease-in-out group">
                        
                        <td class="px-6 py-4 font-mono text-xs font-bold text-indigo-600 uppercase whitespace-nowrap">
                            {{ $product->sku }}
                        </td>
                        
                        <td class="px-6 py-4">
                            <p class="font-bold text-gray-900">{{ $product->nama_obat ?? $product->name }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $product->kategori }} &bull; {{ $product->golongan }}</p>
                        </td>
                        
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $product->stock < 10 ? 'bg-red-50 text-red-700 border-red-200' : 'bg-green-50 text-green-700 border-green-200' }}">
                                {{ $product->stock }} {{ $product->satuan }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            @php
                                $tanggal = \Carbon\Carbon::parse($product->kadaluarsa);
                                $isExpired = $tanggal->isPast();
                            @endphp
                            <span class="text-xs font-semibold px-2 py-1 rounded {{ $isExpired ? 'bg-red-100 text-red-700' : 'text-gray-600' }}">
                                {{ $tanggal->format('d M Y') }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-4 text-right text-gray-500">
                            Rp {{ number_format($product->purchase_price, 0, ',', '.') }}
                        </td>
                        
                        <td class="px-6 py-4 text-right font-bold text-gray-800">
                            Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                        </td>
                        
                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-3 opacity-80 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('products.edit', $product) }}" class="p-1.5 text-blue-600 hover:bg-blue-100 rounded-md transition" title="Edit">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin mau hapus barang ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-red-600 hover:bg-red-100 rounded-md transition" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400 bg-gray-50/50">
                            <i data-lucide="package-search" class="w-12 h-12 mx-auto mb-3 text-gray-300"></i>
                            <p class="text-base font-medium text-gray-500">Belum ada data barang.</p>
                            <p class="text-xs mt-1">Silakan tambah produk baru atau import dari file Excel.</p>
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