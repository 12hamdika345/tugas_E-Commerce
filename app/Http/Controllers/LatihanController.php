<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LatihanController extends Controller
{
    public function index()
    {
        return 'ini dicetak dari controller';
    }

    public function blog($id){
        return 'ini adalah function blog dengan id '.$id;
    }

    public function komentar($idBlog, $idKomentar){
        echo 'Id blognya : '.$idBlog;
        echo '<br>';
        echo 'Id komentarnya : '.$idKomentar;
    }

    public function beranda(){
        $data = array('nama' => 'Rifqi');
        return view('beranda', $data);
    }
}
