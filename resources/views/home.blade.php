@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">{{ __('Home') }}</div>
                <div class="card-body pertanyaan">
                    <a class="btn btn-success" href="pertanyaan">+ Tambah Pertanyaan</a>
                    @foreach($pertanyaan as $item)
                        <div class="card" href="/home">
                        
                            <div class="card-header">{{ __($item->judul) }}</div>
                            <div class="card-body">
                                <p>
                                    {!!$item->isi!!}
                                </p>
                                <a class="btn btn-primary stretched-link" 
                                    href="/pertanyaan/{{$item->id}}">
                                    Lihat Detail Pertanyaan</a>
                            </div>
                            <div class="card-footer">
                                votes: <div id = "vote_{{$item->id}}">{{$item->votes}} </div>
                                <div class="btn btn-success" 
                                    onclick="upVote('<?php echo csrf_token() ?>', {{$item->id}}, 'pertanyaan')">
                                    Up Vote
                                </div>
                                <div class="btn btn-danger" 
                                    onclick="downVote('<?php echo csrf_token() ?>', {{$item->id}}, 'pertanyaan')">
                                    Down Vote
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
