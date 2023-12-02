@extends('layouts.main', ['title' => $title ])
 
<!-- isi bagian konten -->
<!-- cara penulisan isi section yang panjang -->
@section('content')
 
<div class="row mb-2">
    <div class="col-sm-12">
        <h2>Welcome {{ auth()->user()->name }} | {{ auth()->user()->email }}</h2>
        {{ trimString("Hello", "...", 3)}}
    </div>
</div>
 
@endsection