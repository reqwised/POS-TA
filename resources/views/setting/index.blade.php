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
            <div class="card">
                <form action="{{ route('setting.update') }}" method="post" class="form-setting" data-toggle="validator" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body m-4">
                        <div class="form-group row">
                            <label for="nama_perusahaan" class="col-sm-2 col-form-label">Nama Toko  <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input type="text" name="nama_perusahaan" class="form-control" id="nama_perusahaan" required autofocus><span class="help-block with-errors text-danger"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="telepon" class="col-sm-2 col-form-label">Telepon  <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input type="text" name="telepon" class="form-control" id="telepon" required>
                                <span class="help-block with-errors text-danger"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="alamat" class="col-sm-2 col-form-label">Alamat <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <textarea name="alamat" class="form-control" id="alamat" rows="3" required></textarea>
                                <span class="help-block with-errors text-danger"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Logo</label>
                            <div class="col-lg-4">
                                <div class="custom-file">
                                    <input type="file" name="path_logo" class="custom-file-input" id="path_logo" onchange="preview('.tampil-logo', this.files[0])">
                                    <label class="custom-file-label" for="foto">Choose file</label>
                                </div>
                                <span class="help-block with-errors text-danger"></span>
                                <br>
                                <div class="tampil-logo mt-3">
                                    <img src="{{ url($profil->foto ?? '/') }}" width="200">
                                </div>
                            </div>
                        </div>
                        <!-- <div class="form-group row">
                            <label for="path_kartu_member" class="col-sm-2 col-form-label">Kartu Member</label>
                            <div class="col-lg-4">
                                <input type="file" name="path_kartu_member" class="form-control" id="path_kartu_member"
                                    onchange="preview('.tampil-kartu-member', this.files[0], 300)">
                                <span class="help-block with-errors text-danger"></span>
                                <br>
                                <div class="tampil-kartu-member"></div>
                            </div>
                        </div> -->
                        <div class="form-group row">
                            <label for="diskon" class="col-sm-2 col-form-label">Diskon  <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <input type="number" name="diskon" class="form-control" id="diskon" required>
                                <span class="help-block with-errors text-danger"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tipe_nota" class="col-sm-2 col-form-label">Tipe Nota  <span class="text-danger">*</span></label>
                            <div class="col-lg-4">
                                <select name="tipe_nota" class="custom-select" id="tipe_nota" required>
                                    <option value="1">Nota Kecil</option>
                                    <option value="2">Nota Besar</option>
                                </select>
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

                $('.tampil-logo').html(`<img src="{{ url('/') }}${response.path_logo}" width="200">`);
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
</script>
@endpush