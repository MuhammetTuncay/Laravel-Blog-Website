@extends('back.layouts.master')
@section('title', $article->title.' makalesini güncelle')
@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif
            <form method="post" action="{{ route('admin.makaleler.update', $article->id) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label>Makale Başlığı</label>
                    <input type="text" name="title" class="form-control" value="{{ $article->title }}" required>
                </div>
                <div class="form-group">
                    <label>Makale Kategori</label>
                    <select class="form-control" name="category" required>
                        <option value="">Seçim Yapınız</option>
                        @foreach($categories as $category)
                            <option @if($article->category_id==$category->id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Makale Fotoğrafı</label> <br>
                    <img src="{{ asset($article->image) }}" class="rounded img-thumbnail" width="300" alt="">
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="form-group">
                    <label>Makale İçeriği</label>
                    <textarea id="editor" name="content" class="form-control" rows="4">{!! $article->content !!}</textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Makaleyi Güncelle</button>
                </div>
            </form>
        </div>
    </div>
@endsection

{{--/*Sadece bu sayfada kullanılması gereken js ve css*/--}}
<!-- include summernote css/js -->
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('js')
    <!-- include summernote js -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $('#editor').summernote({
            placeholder: 'Makelenizi Düzenleyiniz !!',
            tabsize: 2,
            height: 500
        });
    </script>
@endsection
