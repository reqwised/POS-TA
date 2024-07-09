<!-- Modal: Daftar Member -->
<div class="modal fade" id="daftarMemberModal" tabindex="-1" role="dialog" aria-labelledby="daftarMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="daftarMemberModalLabel">Daftar Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" id="search-member-input" class="form-control" placeholder="Cari kode/nama member...">
                <br>
                <table class="table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th><i class="fa fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody id="member-list">
                        <!-- Member akan dimuat di sini melalui JavaScript -->
                    </tbody>
                </table>
                <div id="paginationmember" class="text-center"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
