@extends('front.layouts.master')

@section('title',$article->title)
@section('bg',$article->image)
@section('content')
    <!-- Post Content -->

    <div class="col-md-9 mx-auto">
        {!! $article->content !!}  {{-- {{!! Böyle yaparak html kodları ekrana yazdırılabilir. !!}} --}}
        <br><br>
        <span class="text-danger">Okunma sayısı : <b>{{ $article->hit }}</b></span>
    </div>
@include('front.widgets.categoryWidget')
@endsection

