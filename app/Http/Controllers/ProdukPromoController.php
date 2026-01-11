<?php

namespace App\Http\Controllers;

use App\Models\ProdukPromo;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukPromoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itempromo = ProdukPromo::orderBy('id', 'DESC')->paginate(20);
        $data = array('title' => 'Data Produk Promo',
                      'itempromo' => $itempromo
                    );
        return view('promo.index', $data)->with('no', (request()->input('page', 1) - 1) * 20);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $itemproduk = Produk::orderBy('nama_produk', 'desc')->where('status', 'publish')->get();
        $data = array('title' => 'Tambah Produk Promo',
                      'itemproduk' => $itemproduk
                    );
        return view('promo.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'produk_id' => 'required',
            'harga_awal' => 'required',
            'harga_akhir' => 'required',
            'diskon_persen' => 'required',
            'diskon_nominal' => 'required',
        ]);

        $cek_promo = ProdukPromo::where('produk_id', $request->produk_id)->first();
        if ($cek_promo) {
            return back()->with('error', 'Produk sudah memiliki promo');
        }else{
            $itemuser = $request->user();
            $inputan = $request->all();
            $inputan['user_id'] = $itemuser->id;
            $itempromo = ProdukPromo::create($inputan);
            return redirect()->route('promo.index')->with('success', 'Data produk promo berhasil ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProdukPromo $produkPromo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProdukPromo $produkPromo)
    {
        $itempromo = ProdukPromo::findOrFail($produkPromo->id);
        $data = array('title' => 'Edit Produk Promo',
                      'itempromo' => $itempromo
                    );
        return view('promo.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'produk_id' => 'required',
            'harga_awal' => 'required',
            'harga_akhir' => 'required',
            'diskon_persen' => 'required',
            'diskon_nominal' => 'required',
        ]);

        $itempromo = ProdukPromo::findOrFail($id);
        $cekpromo = ProdukPromo::where('produk_id', $request->produk_id)
                    ->where('id', '!=', $itempromo->id)
                    ->first();

        if ($cekpromo) {
            return back()->with('error', 'Data sudah ada');
        } else {
            $itemuser = $request->user();
            $inputan = $request->all();
            $inputan['user_id'] = $itemuser->id;
            $itempromo->update($inputan);
            return redirect()->route('promo.index')->with('success', 'Data berhasil diupdate');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProdukPromo $produkPromo)
    {
        $itempromo = ProdukPromo::findOrFail($produkPromo->id);
        if ($itempromo->delete()) {
            return back()->with('success', 'Data produk promo berhasil dihapus');
        } else {
            return back()->with('error', 'Data produk promo gagal dihapus');
        }
    }
}
