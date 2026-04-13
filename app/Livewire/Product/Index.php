<?php

namespace App\Livewire\Product; // <-- Alamat baru karena ada di dalam folder Product

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product; // Sesuaikan dengan nama file modelmu (Product atau Produk)
//use Spatie\SimpleExcel\SimpleExcelReader; // Package yang baru kita install

class Index extends Component
{
    use WithFileUploads;

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
                    'sku'       => $row['sku']->unique(),
                    'nama_obat' => $row['nama_obat'],
                    'kategori'  => $row['kategori'] ?? 'Tanpa Kategori',
                    'harga'     => $row['harga'] ?? 0,
                    'golongan'  => $row['golongan'],
                    'stok'      => $row['stok'] ?? 0,
                    'satuan'    => $row['satuan']
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
                        ->get();

        // Perhatikan alamat view-nya juga ikut masuk ke dalam folder 'product'
        return view('livewire.product.index', [
            'data_produk' => $produk
        ])->layout('layouts.app');  
    }
}