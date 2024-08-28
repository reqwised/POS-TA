<div class="modal fade" id="daftarMemberModal" tabindex="-1" role="dialog" aria-labelledby="daftarMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="daftarMemberModalLabel">Daftar Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-2">
                <input type="text" id="search-member-input" class="form-control" placeholder="Cari kode/nama member...">
                <br>
                <table class="table table-sm table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Kode</th>
                            <th>Nama</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="member-list">
                    </tbody>
                </table>
                <div id="paginationmember" class="text-center"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
