<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Jawaban;

class JawabanController extends Controller
{
    public function create($question_id){
        $jawaban = new Jawaban();
        $jawaban->isi = request('isi');
        $jawaban->question_id = $question_id;
        $jawaban->creator_id = Auth::user()->id; 
        $jawaban->save();

        return response()->json(array('msg'=> "berhasil"), 200);
    }

    private function isValidToVote($id, $upDown){
        //upDown -> upvote atau downvote
        return true;
    }

    public function upVote($id){

        if(!$this->isValidToVote($id, "up"))
            return response()->json(array('msg'=> "Tidak Bisa Melakukan Vote"), 300);

        $jawaban = Jawaban::find($id);
        $jawaban->votes += 1;
        $jawaban->save();

        return response()->json(array('result'=> $jawaban->votes), 200);
    }

    public function downVote($id){
        if(!$this->isValidToVote($id, "down"))
            return response()->json(array('msg'=> "Tidak Bisa Melakukan Vote"), 300);

        $jawaban = Jawaban::find($id);
        $jawaban->votes -= 1;
        $jawaban->save();
        return response()->json(array('result'=> $jawaban->votes), 200);
    }
}
