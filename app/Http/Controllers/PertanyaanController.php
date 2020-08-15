<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Pertanyaan;
use App\VotersPertanyaan;
use App\Jawaban;

class PertanyaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view("pertanyaan.pertanyaanForm");
    }

    public function create(){
        $pertanyaan = new Pertanyaan();

        $pertanyaan->judul = request('judul');
        $pertanyaan->isi = request('isi');
        $pertanyaan->creator_id = Auth::user()->id;

        $pertanyaan->save();

        return response()->json(array('msg'=> "Pertanyaan Berhasil Diinput"), 200);
    }

    public function show($id){
        $pertanyaan = Pertanyaan::find($id);
        $jawaban = Jawaban::where("creator_id", "=", $id)->get();
        
        return view('pertanyaan.pertanyaanDetails',
            ['pertanyaan' => $pertanyaan,
            'jawaban' => $jawaban]
        );
    }

    private function isValidToVote($id, $upDown){
        //upDown -> upvote atau downvote
        return true;
    }

    public function upVote($id){

        if(!$this->isValidToVote($id, "up"))
            return response()->json(array('msg'=> "Tidak Bisa Melakukan Vote"), 300);

        $pertanyaan = Pertanyaan::find($id);
        $pertanyaan->votes += 1;
        $pertanyaan->save();

        return response()->json(array('result'=> $pertanyaan->votes), 200);
    }

    public function downVote($id){
        if(!$this->isValidToVote($id, "down"))
            return response()->json(array('msg'=> "Tidak Bisa Melakukan Vote"), 300);

        $pertanyaan = Pertanyaan::find($id);
        $pertanyaan->votes -= 1;
        $pertanyaan->save();
        return response()->json(array('result'=> $pertanyaan->votes), 200);
    }
}
