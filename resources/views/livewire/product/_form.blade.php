<!-- Input SKU -->
<div>
    <label for="sku" class="block text-sm font-semibold text-gray-700 mb-2">Kode SKU / Barcode</label>
    <input type="text" 
        name="sku" 
        id="sku" 
        value="{{ old('sku',$product->sku) }}"
        placeholder="Misal: BRG-001"
        class="w-full px-4 py-3 rounded-xl border @error('sku') border-red-500 @else border-gray-200 @enderror focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
    @error('sku')
        <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
            <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}
        </p>
    @enderror
</div>

<!-- Input Nama Produk -->
<div>
    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk</label>
    <input type="text" 
        name="name" 
        id="name" 
        value="{{ old('name',$product->name) }}"
        placeholder="Masukkan nama barang lengkap"
        class="w-full px-4 py-3 rounded-xl border @error('name') border-red-500 @else border-gray-200 @enderror focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
    @error('name')
        <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
            <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}
        </p>
    @enderror
</div>

{{-- Input stok --}}
<div>
    <label for="stock" class="block text-sm font-semibold text-gray-700 mb-2">Stok Produk</label>
    <input type="number" 
        name="stock" 
        id="stock" 
        value="{{ old('stock',$product->stock) }}"
        placeholder="Masukkan nama barang lengkap"
        class="w-full px-4 py-3 rounded-xl border @error('stock') border-red-500 @else border-gray-200 @enderror focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
    @error('stock')
        <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
            <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}
        </p>
    @enderror
</div>

<div class="grid grid-cols-2 gap-4">
    <div class="">
        <label for="purchase_price" class="block text-sm font-semibold text-gray-700 mb-2">Harga beli</label>
        <input type="text" 
            name="purchase_price" 
            id="purchase_price" 
            value="{{ old('purchase_price',$product->purchase_price) }}"
            placeholder="Masukkan harga beli"
            class="rupiah w-full px-4 py-3 rounded-xl border @error('purchase_price') border-red-500 @else border-gray-200 @enderror focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
        @error('purchase_price')
            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}
            </p>
        @enderror
    </div>
    <div class="">
        <label for="selling_price" class="block text-sm font-semibold text-gray-700 mb-2">Harga jual</label>
        <input type="text" 
            name="selling_price" 
            id="selling_price" 
            value="{{ old('selling_price',$product->selling_price) }}"
            placeholder="Masukkan harga jual"
            class="rupiah w-full px-4 py-3 rounded-xl border @error('selling_price') border-red-500 @else border-gray-200 @enderror focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
        @error('selling_price')
            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}
            </p>
        @enderror
    </div>
</div>