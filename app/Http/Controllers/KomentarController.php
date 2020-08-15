<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Komentar;

class KomentarController extends Controller
{
    public function create($post_id){
        $komen = new Komentar();

        $komen->type = request('type');
        $komen->isi = request('isi');
        $komen->post_id = $post_id;
        $komen->creator_id = Auth::user()->id;
        $komen->save();
        
    }
}
