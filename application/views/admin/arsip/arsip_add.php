<?php $this->load->view('admin/datepicker'); ?>

<?php
if (isset($arsip)) {
    $inputNumber = $arsip['arsip_number'];    
    $inputDate = $arsip['arsip_date'];
    $inputGen = $arsip['arsip_generate'];
    $inputImage = $arsip['arsip_image'];      
    $inputCat = $arsip['category_category_id'];
} else {
    $inputNumber = set_value('arsip_number');    
    $inputDate = set_value('arsip_date');
    $inputGen = set_value('arsip_generate');
    $inputImage = set_value('arsip_image');    
    $inputCat = set_value('category_id');
}
?>
<div class="col-md-12 col-sm-12 col-xs-12 main post-inherit">
    <div class="x_panel post-inherit">
        <?php if (!isset($arsip)) echo validation_errors(); ?>
        <?php echo form_open_multipart(current_url()); ?>
        <div>
            <h3><?php echo $operation; ?> Surat Arsip</h3><br>
        </div>

        <div class="row">
            <div class="col-sm-9 col-md-9">
                <?php if (isset($arsip)): ?>
                    <input type="hidden" name="arsip_id" value="<?php echo $arsip['arsip_id']; ?>" />
                <?php endif; ?>
                <label >No. Surat *</label>
                <input type="text" name="arsip_number" placeholder="No. Surat" class="form-control" value="<?php echo $inputNumber; ?>"><br>
                <label >Tanggal *</label>
                <input name="arsip_date" placeholder="Tanggal" type="text" class="form-control datepicker" value="<?php echo $inputDate; ?>"><br>
                <label >Pilih Kategori *</label>
                <select name="category_id" class="form-control">
                    <option value="">-- Pilih Kategori --</option>
                    <?php
                    foreach ($category as $row):
                        ?>
                    <option value="<?php echo $row['category_id']; ?>"> <?php echo $row['category_name']; ?></option>

                    <?php
                    endforeach;
                    ?>
                </select><br>                
                <p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
            </div></div></div><br>
            <div class="col-sm-12 col-xs-12 col-md-3">
                <div class="form-group">
                    <label >Upload Document </label>
                    <input type="file" name="arsip_image" class="form-control" ><br>
                    <?php if (isset($arsip) AND $arsip['arsip_image'] != NULL) { ?>
                    <img src="<?php echo upload_url('arsips/'.$arsip['arsip_image']) ?>" class="img-responsive ava-detail"><br>
                    <?php } ?>    
                    <div class="form-group">
                        <button name="action" type="submit" value="save" class="btn btn-success btn-form"><i class="fa fa-check"></i> Simpan</button>
                        <a href="<?php echo site_url('admin/arsip'); ?>" class="btn btn-info btn-form"><i class="fa fa-arrow-left"></i> Batal</a>
                        <?php if (isset($arsip)): ?>
                            <a href="<?php echo site_url('admin/arsip/delete/' . $arsip['arsip_id']); ?>" class="btn btn-danger btn-form" ><i class="fa fa-trash"></i> Hapus</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>

    <?php if (isset($arsip)): ?>
        <!-- Delete Confirmation -->
        <div class="modal fade" id="confirm-del">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><b><span class="fa fa-warning"></span> Konfirmasi Penghapusan</b></h4>
                    </div>
                    <div class="modal-body">
                        <p>Data yang dipilih akan dihapus oleh sistem, apakah anda yakin?;</p>
                    </div>
                    <?php echo form_open('admin/arsip/delete/' . $arsip['arsip_id']); ?>
                    <div class="modal-footer">
                        <a><button style="float: right;margin-left: 10px" type="button" class="btn btn-default" data-dismiss="modal">Tidak</button></a>
                        <input type="hidden" name="del_id" value="<?php echo $arsip['arsip_id'] ?>" />
                        <input type="hidden" name="del_name" value="<?php echo $arsip['arsip_number'] ?>" />
                        <button type="submit" class="btn btn-danger"> Ya</button>
                    </div>
                    <?php echo form_close(); ?>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <?php if ($this->session->flashdata('delete')) { ?>
        <script type="text/javascript">
            $(window).load(function() {
                $('#confirm-del').modal('show');
            });
        </script>
        <?php }
        ?>
    <?php endif; ?>