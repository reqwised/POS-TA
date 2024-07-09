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
                                <div class="form-group col-md-10">
                                    <label for="nama_perusahaan">Nama Toko  <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_perusahaan" class="form-control" id="nama_perusahaan" data-error="Nama toko tidak boleh kosong" required autofocus><span class="help-block with-errors text-danger"></span>
                                </div>

                                <div class="form-group col-md-10">
                                    <label for="telepon">Telepon  <span class="text-danger">*</span></label>
                                    <input type="text" name="telepon" class="form-control" data-error="Nomor telepon tidak boleh kosong" id="telepon" required>
                                    <span class="help-block with-errors text-danger"></span>
                                </div>

                                <div class="form-group col-md-10">
                                    <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                    <textarea name="alamat" class="form-control" data-error="Alamat tidak boleh kosong" id="alamat" rows="3" required></textarea>
                                    <span class="help-block with-errors text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group col-md-10">
                                    <label for="diskon">Diskon  <span class="text-danger">*</span></label>
                                    <input type="number" name="diskon" class="form-control" data-error="Diskon tidak boleh kosong" id="diskon" required>
                                    <span class="help-block with-errors text-danger"></span>
                                </div>

                                <div class="form-group col-md-10">
                                    <label for="tipe_nota">Tipe Nota  <span class="text-danger">*</span></label>
                                    <select name="tipe_nota" class="custom-select" id="tipe_nota" required>
                                        <option value="1">Nota Kecil</option>
                                        <option value="2">Nota Besar</option>
                                    </select>
                                    <span class="help-block with-errors text-danger"></span>
                                </div>

                                <div class="form-group col-md-10">
                                    <label>Logo <span class="text-sm text-secondary font-italic">(Kosongkan jika tidak ingin diubah)</span></label>
                                    <div class="custom-file">
                                        <input type="file" name="path_logo" class="custom-file-input" id="path_logo" onchange="preview('.tampil-logo', this.files[0])">
                                        <label class="custom-file-label" for="foto">Choose file</label>
                                    </div>
                                    <small class="form-text text-muted">
                                        File harus berupa gambar PNG, ukuran maksimal 500KB, dan memiliki aspek rasio 1:1.
                                    </small>
                                    <span class="help-block with-errors text-danger"></span>
                                    <div class="tampil-logo mt-3">
                                        <img src="{{ url($profil->foto ?? '/') }}" width="150">
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
                    return;
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
                        title: "Gagal menyimpan data",
                        icon: "error",
                    });
                    return;
            });
    }

    function validateImage(input) {
        const file = input.files[0];
        const img = new Image();
        const maxSize = 500 * 1024; // 500KB
        const allowedTypes = ['image/png'];

        if (file) {
            if (!allowedTypes.includes(file.type)) {
                alert("File harus berupa gambar PNG.");
                input.value = "";
                return;
            }

            if (file.size > maxSize) {
                alert("Ukuran file maksimal adalah 500KB.");
                input.value = "";
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                img.src = e.target.result;
                img.onload = function () {
                    if (img.width !== img.height) {
                        alert("Gambar harus memiliki aspek rasio 1:1.");
                        input.value = "";
                    } else {
                        document.getElementById('logoPreview').src = img.src;
                    }
                };
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush