<?php

namespace App\Livewire\Product; // <-- Alamat baru karena ada di dalam folder Product

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Product; // Sesuaikan dengan nama file modelmu (Product atau Produk)
use Spatie\SimpleExcel\SimpleExcelReader; // Package yang baru kita install

class Index extends Component
{
    use WithFileUploads, WithPagination;

    public $file_import;
    public $search = '';

    public function importData()
    {
        // 1. Validasi
        $this->validate([
            'file_import' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        $path = $this->file_import->getRealPath();

        // 2. Proses Import Spatie
        SimpleExcelReader::create($path)
            ->getRows()
            ->each(function(array $row) {
                // Lewati baris kalau nama_obat kosong
                if (!isset($row['nama_obat'])) {
                    return; 
                }

                // 3. Simpan ke database
                Product::create([
                    'id'        => $row['id'],
                    'sku'       => $row['sku'],
                    'nama_obat' => $row['nama_obat'],
                    'stok'      => $row['stok'] ?? 0,
                    'kategori'  => $row['kategori'] ?? 'Tanpa Kategori',
                    'purcase_price'     => $row['purcase_price'],
                    'selling_price'     => $row['selling_price'],
                    'golongan'  => $row['golongan'],
                    'satuan'    => $row['satuan'],
                    'kadaluarsa'=> $row['kadaluarsa']
                    // TODO: Ayo Igo, lengkapi field golongan, stok, dan satuan di sini ya!
                ]);
            });

        $this->reset('file_import');
        session()->flash('pesan', 'Data produk berhasil diimport!');
    }

    public function render()
    {
        $produk = Product::where('nama_obat', 'like', '%' . $this->search . '%')
                        ->orWhere('kategori', 'like', '%' . $this->search . '%')
                        ->paginate(10);

        // Perhatikan alamat view-nya juga ikut masuk ke dalam folder 'product'
        return view('livewire.product.index', [
            'products' => $produk
        ])->layout('layouts.app');  
    }
}