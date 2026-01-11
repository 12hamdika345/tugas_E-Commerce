<?php

namespace App\Http\Controllers;

use App\Models\Slideshow;
use Illuminate\Http\Request;

class SlideshowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $itemSlideshow = Slideshow::paginate(10);
        $data = array('title' => 'Dashboard Slideshow',
                      'itemslideshow' => $itemSlideshow
                    );
        return view('slideshow.index', $data)->with('no', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // ambil data user yang login
        $itemUser = $request->user();
        //masukkan data yang dikirim ke dalam variable $inputan
        $inputan = $request->all();
        $inputan['user_id'] = $itemUser->id;
        //ambil url gambar yang diupload
        $fileupload = $request->file('image');
        $folder = 'assets/images';
        $itemgambar = (new ImageController)->upload($fileupload, $itemUser, $folder);
        // masukkan url gambar ke dalam $inputan
        $inputan['foto'] = $itemgambar->url;
        $itemSlideshow = Slideshow::create($inputan);
        return back()->with('success', 'Foto berhasil diupload');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $itemSlideshow = Slideshow::findOrFail($slideshow->id);
        // cek kalo foto bukan null
        if ($itemSlideshow->foto != null) {
            \Storage::delete($itemSlideshow->foto);
        }
        if($itemSlideshow->delete()) {
            return back()->with('success', 'Data slideshow berhasil dihapus');
        } else {
            return back()->with('error', 'Data slideshow gagal dihapus');
        }
    }
}
