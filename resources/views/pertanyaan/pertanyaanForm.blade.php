@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create New Pertanyaan') }}</div>
                
                <div class="alert" id="alertMessage"> {{session('message')}} </div>

                <div class="card-body">
                
                        <div class="form-group">
                            <label for="formGroupExampleInput">Judul Pertanyaan</label>
                            <input type="textarea" name="judul" 
                                class="form-control" id="inputJudul" 
                                placeholder="Masukan Judul">
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">Isi Pertanyaan</label>
                            <input type="textarea" name = "isi" 
                                class="form-control" id="isiPertanyaan"
                                placeholder="Masukan Isi Pertanyaan">
                            <script> CKEDITOR.replace('isiPertanyaan')</script>
                        </div>
                        <div class = "btn btn-primary" type="submit" 
                            onclick="postPertanyaan('<?php echo csrf_token() ?>',)">
                            Buat Pertanyaan
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
</script>
@endsection

