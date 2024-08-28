@extends('layouts.master')

@section('title', 'Profil')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Profil</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <form action="{{ route('user.update_profil') }}" method="post" class="form-profil" data-toggle="validator" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <h5>Edit Profil</h5>

                                <div class="form-group col-md-9">
                                    <label for="name">Nama <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" data-error="Nama tidak boleh kosong" id="name" required autofocus value="{{ $profil->name }}"><span class="help-block with-errors text-danger"></span>
                                </div>

                                <div class="form-group col-md-9">
                                    <label>Foto Profil</label>
                                    <div class="custom-file">
                                        <input type="file" name="foto" class="custom-file-input" id="foto" onchange="validateImage(this)">
                                        <label class="custom-file-label" for="foto">Choose file</label>
                                    </div>
                                    <small class="form-text text-muted">
                                        Ukuran maksimal 1 MB dengan format (JPEG, JPG, dan PNG).
                                    </small>
                                    <span class="help-block with-errors"></span>
                                    <div class="tampil-foto mt-3">
                                        <img class="rounded-circle" id="fotoPreview" src="{{ url($profil->foto ?? '/') }}" width="150">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5>Ganti Password <span class="text-sm text-secondary font-italic">(Kosongkan jika tidak ingin diubah)</span></h5>

                                <div class="form-group col-md-9">
                                    <label for="old_password">Password Lama</label>
                                    <input type="password" name="old_password" id="old_password" class="form-control" placeholder="Masukkan Password Lama Anda" data-error="Password harus terdiri dari setidaknya 6 karakter" minlength="6">
                                    <span class="help-block with-errors text-danger"></span>
                                </div>

                                <div class="form-group col-md-9">
                                    <label for="password">Password Baru</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Buat Password Baru (Minimal 6 Karakter)" data-error="Password harus terdiri dari setidaknya 6 karakter" minlength="6">
                                    <span class="help-block with-errors text-danger"></span>
                                </div>

                                <div class="form-group col-md-9">
                                    <label for="password_confirmation">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Konfirmasi Password Baru (Minimal 6 Karakter)" data-error="Konfirmasi password Anda dengan benar" data-match="#password">
                                    <span class="help-block with-errors text-danger"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary float-right">Simpan</button>
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
                    $('.tampil-foto').html(`<img src="{{ url('/') }}${response.foto}" width="150">`);
                    $('.img-profil').attr('src', `{{ url('/') }}/${response.foto}`);

                    Swal.fire({
                        title: "Berhasil menyimpan data!",
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
                            title: "Gagal menyimpan data!",
                            icon: "error",
                            confirmButtonColor: '#007bff',
                        });
                    }
                });
            }
        });
    });

    function validateImage(input) {
        const file = input.files[0];
        const maxSize = 1500 * 1024; // 1MB
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];

        if (file) {
            if (!allowedTypes.includes(file.type)) {
                alert("Format gambar harus (JPEG, JPG, PNG).");
                input.value = "";
                return;
            }

            if (file.size > maxSize) {
                alert("Ukuran file maksimal adalah 1 MB.");
                input.value = "";
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('fotoPreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush