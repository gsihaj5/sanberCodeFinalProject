@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">{{ $pertanyaan->judul }}</div>
                <div class="card-body pertanyaan">
                    {{$pertanyaan->isi}}
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
                            <div class="card-body">
                                <p>
                                    {{$item->isi}}
                                </p>
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
                    
                </div>
                <div class="card-footer">
                    <form action="/komentar/{{$pertanyaan->id}}" method = "POST">
                        @csrf
                        <input  type="textarea" name = "komentar" 
                            placeholder = "Masukan Pertanyaan">
                        <script>
                                CKEDITOR.replace( 'komentar' );
                        </script>
                        <br>
                        <input type = "submit" value = "Tambahkan Komentar"
                            class = "btn btn-success">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
