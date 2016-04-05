<div class="col-md-12 col-sm-12 col-xs-12 main post-inherit">
    <div class="x_panel post-inherit">
        <div class="col-md-12 main">
            <h3>
                Detail Peserta
                <span class=" pull-right">
                    <a href="<?php echo site_url('admin/arsip') ?>" class="btn btn-info btn-sm"><span class="fa fa-arrow-left"></span>&nbsp; Kembali</a> 
                    <a href="<?php echo site_url('admin/arsip/edit/' . $arsip['arsip_id']) ?>" class="btn btn-success btn-sm"><span class="fa fa-edit"></span>&nbsp; Edit</a>                    
                </span>
            </h3><br>
        </div>
        <div class="col-md-2">
            <?php if (!empty($arsip['arsip_image'])) { ?>
            <img src="<?php echo upload_url('arsips/'.$arsip['arsip_image']) ?>" class="img-responsive ava-detail">
            <?php } else { ?>
            <img src="<?php echo base_url('media/image/missing-image.png') ?>" class="img-responsive ava-detail">
            <?php } ?>
        </div>
        <div class="col-md-8">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>Kode Arsip</td>
                        <td>:</td>
                        <td><?php echo $arsip['arsip_generate'] ?></td>
                    </tr>
                    <tr>
                        <td>No. Surat</td>
                        <td>:</td>
                        <td><?php echo $arsip['arsip_number'] ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td><?php echo pretty_date($arsip['arsip_date'], 'd F Y', false) ?></td>
                    </tr>
                    <tr>
                        <td>Kategori</td>
                        <td>:</td>
                        <td><?php echo $arsip['category_name'] ?></td>
                    </tr>                    
                    <tr>
                        <td>User Input</td>
                        <td>:</td>
                        <td><?php echo $arsip['user_full_name'] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
