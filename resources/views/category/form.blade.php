<!-- Modal Form -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" class="form-horizontal" data-toggle="validator">
            @csrf
            @method('post')
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel">Form Kategori</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama_category" class="col-md-3 col-md-offset-1 control-label">Nama Kategori</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="nama_category" name="nama_category" required
                                autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-save">Simpan</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
