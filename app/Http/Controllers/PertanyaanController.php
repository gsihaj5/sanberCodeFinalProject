<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\VotersPertanyaan;
use App\Pertanyaan;
use App\Komentar;
use App\Jawaban;
use App\User;

class PertanyaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view("pertanyaan.pertanyaanForm");
    }

    public function create()
    {
        $pertanyaan = new Pertanyaan();

        $pertanyaan->judul = request('judul');
        $pertanyaan->isi = request('isi');
        $pertanyaan->creator_id = Auth::user()->id;

        $pertanyaan->save();

        return response()->json(
            array('msg' => "Pertanyaan Berhasil Diinput"),
            200
        );
    }

    public function show($id)
    {
        $pertanyaan = Pertanyaan::find($id);
        $jawaban = Jawaban::whereRaw(
            "creator_id = " . Auth::user()->id . " AND question_id = $id"
        )->get();
        $komentar = Komentar::whereRaw(
            "creator_id = " . Auth::user()->id . " AND post_id = $id AND type = 'pertanyaan'"
        )->get();

        return view('pertanyaan.pertanyaanDetails', [
            'pertanyaan' => $pertanyaan,
            'jawaban' => $jawaban,
            'komentar' => $komentar,
            'reputation' => Auth::user()->reputation
        ]);
    }

    private function isValidToVote($id, $upDown)
    {
        //upDown -> upvote atau downvote
        if ($upDown === "up") {
            $count = VotersPertanyaan::whereRaw(
                "voters_id = " . Auth::user()->id . " AND pertanyaan_id = $id"
            )
                ->get()
                ->count();
            if ($count != 0) {
                return false;
            } else {
                $vote = new VotersPertanyaan();
                $vote->voters_id = Auth::user()->id;
                $vote->pertanyaan_id = $id;
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

        $pertanyaan = Pertanyaan::find($id);
        $pertanyaan->votes += 1;
        $pertanyaan->save();

        $user = User::find($pertanyaan->id);
        $user->reputation += 10;
        $user->save();

        return response()->json(array('result' => $pertanyaan->votes), 200);
    }

    public function downVote($id)
    {
        if (!$this->isValidToVote($id, "down")) {
            return response()->json(
                array('msg' => "Syarat Vote Tidak Terpenuhi, Tidak Bisa Melakukan Vote"),
                300
            );
        }

        $pertanyaan = Pertanyaan::find($id);
        $pertanyaan->votes -= 1;
        $pertanyaan->save();
        return response()->json(array('result' => $pertanyaan->votes), 200);
    }
}
