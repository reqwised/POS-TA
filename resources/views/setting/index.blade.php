@extends('layouts.master')

@section('title', 'Pengaturan')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Pengaturan</li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <form action="{{ route('setting.update') }}" method="post" class="form-setting" data-toggle="validator" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group col-md-9">
                                    <label for="nama_perusahaan">Nama Toko  <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_perusahaan" class="form-control" id="nama_perusahaan" data-error="Nama toko tidak boleh kosong" required autofocus><span class="help-block with-errors text-danger"></span>
                                </div>

                                <div class="form-group col-md-9">
                                    <label for="telepon">Telepon  <span class="text-danger">*</span></label>
                                    <input type="text" name="telepon" class="form-control" data-error="Nomor telepon tidak boleh kosong" id="telepon" required>
                                    <span class="help-block with-errors text-danger"></span>
                                </div>

                                <div class="form-group col-md-9">
                                    <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                    <textarea name="alamat" class="form-control" data-error="Alamat tidak boleh kosong" id="alamat" rows="3" required></textarea>
                                    <span class="help-block with-errors text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group col-md-9">
                                    <label for="diskon">Diskon <span class="text-danger"> *</span></label>
                                    <div class="input-group">
                                        <input type="number" name="diskon" class="form-control" data-error="Diskon tidak boleh kosong" id="diskon" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                        </div>
                                    </div>
                                    <span class="help-block with-errors text-danger"></span>
                                </div>

                                <div class="form-group col-md-9">
                                    <label>Logo <span class="text-sm text-secondary font-italic">(Kosongkan jika tidak ingin diubah)</span></label>
                                    <div class="custom-file">
                                        <input type="file" name="path_logo" class="custom-file-input" id="path_logo" onchange="validateImage(this)">
                                        <label class="custom-file-label" for="foto">Choose file</label>
                                    </div>
                                    <small class="form-text text-muted">
                                        Ukuran maksimal 1 MB dengan format (JPEG, JPG, dan PNG).
                                    </small>
                                    <span class="help-block with-errors text-danger"></span>
                                    <div class="tampil-logo mt-3">
                                        <img id="logoPreview" src="{{ url($profil->foto ?? '/') }}" width="150">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button class="btn btn-primary">Simpan</button>
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
        showData();

        $('.form-setting').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.ajax({
                    url: $('.form-setting').attr('action'),
                    type: $('.form-setting').attr('method'),
                    data: new FormData($('.form-setting')[0]),
                    async: false,
                    processData: false,
                    contentType: false
                })
                .done(response => {
                    Swal.fire({
                            title: "Berhasil menyimpan data",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                })
                .fail(errors => {
                    Swal.fire({
                        title: "Gagal menyimpan data",
                        icon: "error",
                    });
                });
            }
        });
    });

    function showData() {
        $.get('{{ route('setting.show') }}')
            .done(response => {
                $('[name=nama_perusahaan]').val(response.nama_perusahaan);
                $('[name=telepon]').val(response.telepon);
                $('[name=alamat]').val(response.alamat);
                $('[name=diskon]').val(response.diskon);
                $('[name=tipe_nota]').val(response.tipe_nota);
                $('title').text(response.nama_perusahaan + ' | Pengaturan');
                
                let words = response.nama_perusahaan.split(' ');
                let word  = '';
                words.forEach(w => {
                    word += w.charAt(0);
                });
                $('.logo-mini').text(word);
                $('.logo-lg').text(response.nama_perusahaan);

                $('.tampil-logo').html(`<img src="{{ url('/') }}${response.path_logo}" width="150">`);
                $('.tampil-kartu-member').html(`<img src="{{ url('/') }}${response.path_kartu_member}" width="300">`);
                $('[rel=icon]').attr('href', `{{ url('/') }}/${response.path_logo}`);
            })
            .fail(errors => {
                Swal.fire({
                    title: "Gagal menyimpan data!",
                    icon: "error",
                    confirmButtonColor: '#007bff',
                });
            });
    }

    function validateImage(input) {
        const file = input.files[0];
        const maxSize = 1000 * 1024; // 1MB
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

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
                document.getElementById('logoPreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
        preview('.tampil-logo', file);
    }

    document.getElementById('diskon').addEventListener('input', function() {
        let value = parseInt(this.value) || 0;
        
        if (value < 0) {
            this.value = 0;
        } else if (value > 100) {
            this.value = 100;
        } else {
            this.value = value;
        }
    });
</script>
@endpush