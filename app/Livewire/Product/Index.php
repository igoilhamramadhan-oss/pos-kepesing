<?php

namespace App\Livewire\Product; // <-- Alamat baru karena ada di dalam folder Product

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Product; // Sesuaikan dengan nama file modelmu (Product atau Produk)
use Spatie\SimpleExcel\SimpleExcelReader; // Package yang baru kita install
use Livewire\Attributes\Title;

class Index extends Component
{
    use WithFileUploads, WithPagination;

    #[Title('Produk')]
    public $file_import;
    public $search = '';

    public function updatingSearch() {
        $this->resetPage();
    }

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

                // -- Fitur auto format header --
                $barisBaru = [];
                foreach($row as $HeaderLama => $isiData){
                    /* Proses cuci header :
                        Hilangkan spasi -> Huruf kecil -> Spapsi jadi underscore */
                        $headerBaru = str_replace(' ', '_', strtolower(trim($HeaderLama)));

                    // Simpan data ke array baru dengan nama header yang sudah rapi
                    $barisBaru[$headerBaru] = $isiData;
                }

                // Pakai $barisBaru, bukan $row lagi
                // Lewati baris kalau nama_obat kosong
                if (!isset($barisBaru['nama_obat'])) {
                    return; 
                }

                // Baris untuk investigasi (dump and die)
                // dd($barisBaru);

                // 3. Simpan ke database
                Product::create([
                    // 'id'        => $barisBaru['id'],
                    'sku'       => $barisBaru['sku'],
                    'nama_obat' => $barisBaru['nama_obat'],

                    'stock'      => $barisBaru['stok'] ?? ($barisBaru['stock'] ?? 0),
                    'kategori'  => $barisBaru['kategori'] ?? 'Tanpa Kategori',

                    'purchase_price'     => $barisBaru['purchase_price'] ?? 0,
                    'selling_price'     => $barisBaru['selling_price'] ?? 0,

                    'golongan'  => $barisBaru['golongan'] ?? '-',
                    'satuan'    => $barisBaru['satuan'] ?? 'pcs',
                    'kadaluarsa'=> $barisBaru['kadaluarsa'] ?? null
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