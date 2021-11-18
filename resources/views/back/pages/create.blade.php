@extends('back.layouts.master')
@section('title', 'Sayfa Oluştur')
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
            <form method="post" action="{{ route('admin.page.create.post') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Sayfa Başlığı</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Sayfa Fotoğrafı</label>
                    <input type="file" name="image" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Sayfa İçeriği</label>
                    <textarea id="editor" name="content" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Sayfayı Oluştur</button>
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
        placeholder: 'Sayfanızı Düzenleyiniz !!',
        tabsize: 2,
        height: 500
      });
    </script>
@endsection
