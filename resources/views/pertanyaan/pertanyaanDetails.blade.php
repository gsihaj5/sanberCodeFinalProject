@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">{{ $pertanyaan->judul }}</div>
                <div class="card-body pertanyaan">
                    {!!$pertanyaan->isi!!}
                </div>
                <div class="card-footer">
                    votes: <div id = "vote_{{$pertanyaan->id}}">{{$pertanyaan->votes}} </div>
                    <div class="btn btn-success" 
                        onclick="upVote('<?php echo csrf_token() ?>', {{$pertanyaan->id}}, 'pertanyaan')">
                        Up Vote
                    </div>
                    <div class="btn btn-danger" 
                        onclick="downVote('<?php echo csrf_token() ?>', {{$pertanyaan->id}}, 'pertanyaan')">
                        Down Vote
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">Jawaban</div>
                <div class="card-body">
                    @foreach($jawaban as $item)
                        <div class="card" href="/home">
                        @if($item->jawaban_tepat == 1)
                            <div class="card-body bg-success text-white" href="/home">
                        @else
                            <div class="card-body">
                        @endif
                                {!!$item->isi!!}
                            </div>
                            <div class="card-footer">
                                votes: <div id = "vote_jawaban_{{$item->id}}">{{$item->votes}} </div>
                                <div class="btn btn-success" 
                                    onclick="upVote('<?php echo csrf_token() ?>', {{$item->id}}, 'jawaban')">
                                    Up Vote
                                </div>
                                <div class="btn btn-danger" 
                                    onclick="downVote('<?php echo csrf_token() ?>', {{$item->id}}, 'jawaban')">
                                    Down Vote
                                </div>
                                @if($pertanyaan -> jawaban_tepat_id == 0)
                                <div class="btn btn-info" 
                                    onclick="selectAnswer('<?php echo csrf_token() ?>', 
                                            {{$item->id}},
                                            {{$pertanyaan->id}})">
                                    Pilih Jawban
                                </div>
                                @endif
                            </div>
                        </div>
                    
                    @endforeach
                    
                </div>
                <div class="card-footer">
                    <input  type="textarea" id = "jawaban" 
                        placeholder = "Masukan Pertanyaan">
                    <script>
                            CKEDITOR.replace( 'jawaban' );
                    </script>
                    <br>
                    <div class = "btn btn-success" 
                        onclick = "postJawaban('<?php echo csrf_token() ?>', 
                        {{$pertanyaan->id}})">
                        Tambahkan Jawaban
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">Komentar</div>
                <div class="card-body">
                    @foreach($komentar as $item)
                        <div class="card" href="/home">
                            <div class="card-body">
                                {!!$item->isi!!}
                            </div>
                        </div>
                    @endforeach
                    
                </div>
                <div class="card-footer">
                    <input  type="textarea" id = "komentar" 
                        placeholder = "Masukan Pertanyaan">
                    <script>
                            CKEDITOR.replace( 'komentar' );
                    </script>
                    <div class = "btn btn-success"
                        onclick = "postKomentar('<?php echo csrf_token() ?>', {{$pertanyaan->id}}, 'pertanyaan')"
                    >
                        Tambahkan Komentar
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
