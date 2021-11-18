@extends('front.layouts.master')

@section('title','İletişim Sayfası')
@section('bg','https://www.iienstitu.com/uploads/blog-yazilari-5/iletisim-nedir-etkili-iletisim-nasil-kurulur%203_w1145_h572_op.jpg')
@section('content')


    <div class="col">
        @if(session('success'))
        <div class="alert alert-success">
            <p>{{ session('success') }}</p>
        </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <div class="card-header bg-primary text-white"><i class="fa fa-envelope"></i> Bizimle iletişime geçin...</div>
            <div class="card-body">
                <form method="post" action="{{ route('contact.post') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Ad Soyad</label>
                        <input type="text" class="form-control" value="{{ old('name') }}" name="name" aria-describedby="emailHelp" placeholder="Adınız ve Soyadınız" required>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail Adresi</label>
                        <input type="email" class="form-control" value="{{ old('email') }}" name="email" aria-describedby="emailHelp" placeholder="E-mail Adresiniz" required>
                        <small id="emailHelp" class="form-text text-muted">E-postanızı asla başkalarıyla paylaşmayacağız.</small>
                    </div>
                    <div class="form-group">
                        <label>Konu</label>
                        <select class="form-group" name="topic" required>
                            <option @if(old('topic')=="") selected @endif></option>
                            <option @if(old('topic')=="Bilgi") selected @endif>Bilgi</option>
                            <option @if(old('topic')=="Destek") selected @endif>Destek</option>
                            <option @if(old('topic')=="Genel") selected @endif>Genel</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message">Mesajınız</label>
                        <textarea class="form-control" name="message" rows="6" required>{{ old('message') }}</textarea>
                    </div>
                    <div class="mx-auto">
                        <button type="submit" class="btn btn-primary text-right">Gönder</button></div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="card bg-light mb-3">
            <div class="card-header bg-success text-white text-uppercase"><i class="fa fa-home"></i> İletişim Bilgilerimiz</div>
            <div class="card-body">
                <p>3 rue des Champs Elysées</p>
                <p>75008 PARIS</p>
                <p>France</p>
                <p>Email : email@example.com</p>
                <p>Tel. +33 12 56 11 51 84</p>

            </div>

        </div>
    </div>

@endsection

