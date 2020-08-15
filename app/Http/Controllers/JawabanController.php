<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Jawaban;
use App\Pertanyaan;
use App\User;
use App\VotersJawaban;

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

    private function isValidToVote($id, $upDown)
    {
        //upDown -> upvote atau downvote
        if ($upDown === "up") {
            $count = VotersJawaban::whereRaw(
                "voters_id = " . Auth::user()->id . " AND jawaban_id = $id"
            )
                ->get()
                ->count();
            if ($count != 0) {
                return false;
            } else {
                $vote = new VotersJawaban();
                $vote->voters_id = Auth::user()->id;
                $vote->jawaban_id = $id;
                $vote->save();
                return true;
            }
        }
        else{
            if(Auth::user()->reputation < 15)
                return false;
            else return true;
        }
    }

    public function upVote($id)
    {
        if (!$this->isValidToVote($id, "up")) {
        //if (false) {
            return response()->json(
                array(
                    'msg' =>
                        "Syarat Vote Tidak Terpenuhi,Tidak Bisa Melakukan Vote"
                ),
                300
            );
        }

        $jawaban = Jawaban::find($id);
        $jawaban->votes += 1;
        $jawaban->save();

        $user = User::find($jawaban->id);
        $user->reputation += 10;
        $user->save();

        return response()->json(array('result' => $jawaban->votes), 200);
    }

    public function downVote($id)
    {
        if (!$this->isValidToVote($id, "down")) {
            return response()->json(
                array('msg' => "Syarat Vote Tidak Terpenuhi, Tidak Bisa Melakukan Vote"),
                300
            );
        }

        $jawaban = Jawaban::find($id);
        $jawaban->votes -= 1;
        $jawaban->save();
        return response()->json(array('result' => $jawaban->votes), 200);
    }

    public function tepat($pertanyaan_id,$jawaban_id){
        $pertanyaan = Pertanyaan::find($pertanyaan_id);
        $pertanyaan -> jawaban_tepat_id = $jawaban_id;
        $pertanyaan->save();

        $jawaban = Jawaban::find($jawaban_id);
        $jawaban->jawaban_tepat = 1;
        $jawaban->save();

        $user = User::find($jawaban->creator_id);
        $user->reputation += 15;
        $user->save();
    }
}

