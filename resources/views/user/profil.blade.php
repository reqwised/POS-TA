@extends('layouts.master')

@section('title', 'Edit Profile')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit Profil</li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('user.update_profil') }}" method="post" class="form-profil" data-toggle="validator" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body m-4">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Nama <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input type="text" name="name" class="form-control" id="name" required autofocus value="{{ $profil->name }}"><span class="help-block with-errors text-danger"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Foto Profil</label>
                            <div class="col-lg-4">
                                <div class="custom-file">
                                    <input type="file" name="foto" class="custom-file-input"id="foto" onchange="preview('.tampil-foto', this.files[0])">
                                    <label class="custom-file-label" for="foto">Choose file</label>
                                </div>
                                <span class="help-block with-errors"></span>
                                <br>
                                <div class="tampil-foto mt-3">
                                    <img src="{{ url($profil->foto ?? '/') }}" width="200" class="rounded">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="old_password" class="col-sm-2 col-form-label">Password Lama</label>
                            <div class="col-lg-4">
                                <input type="password" name="old_password" id="old_password" class="form-control" 
                                minlength="6">
                                <span class="help-block with-errors text-danger"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-lg-4">
                                <input type="password" name="password" id="password" class="form-control" 
                                minlength="6">
                                <span class="help-block with-errors text-danger"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password_confirmation" class="col-sm-2 col-form-label">Konfirmasi Password</label>
                            <div class="col-lg-4">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" 
                                    data-match="#password">
                                <span class="help-block with-errors text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        $('#old_password').on('keyup', function () {
            if ($(this).val() != "") $('#password, #password_confirmation').attr('required', true);
            else $('#password, #password_confirmation').attr('required', false);
        });

        $('.form-profil').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.ajax({
                    url: $('.form-profil').attr('action'),
                    type: $('.form-profil').attr('method'),
                    data: new FormData($('.form-profil')[0]),
                    async: false,
                    processData: false,
                    contentType: false
                })
                .done(response => {
                    $('[name=name]').val(response.name);
                    $('.tampil-foto').html(`<img src="{{ url('/') }}${response.foto}" width="200">`);
                    $('.img-profil').attr('src', `{{ url('/') }}/${response.foto}`);

                    Swal.fire({
                        title: "Berhasil menyimpan data",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500
                    });
                })
                .fail(errors => {
                    if (errors.status == 422) {
                        alert(errors.responseJSON); 
                    } else {
                        Swal.fire({
                            title: "Gagal menampilkan data",
                            icon: "error",
                        });
                    }
                    return;
                });
            }
        });
    });
</script>
<script>
    // Script to handle the custom file input label update
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = document.getElementById("foto").files[0].name;
        var nextSibling = e.target.nextElementSibling
        nextSibling.innerText = fileName
    })

    // Function to preview image
    function preview(container, file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector(container + ' img').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
</script>
@endpush