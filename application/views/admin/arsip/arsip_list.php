<div class="col-md-12 col-sm-12 col-xs-12 main post-inherit">
    <div class="x_panel post-inherit">
        <h3 class="">
            Daftar Peserta
            <a href="<?php echo site_url('admin/arsip/add'); ?>" ><span class="glyphicon glyphicon-plus-sign"></span></a>
        </h3><br>
        
        <span class="pull-right">
            <a class="btn btn-sm btn-default" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample" ><span class="glyphicon glyphicon-align-justify"></span></a>               
        </span>
    </h3>       
</h3>
<div>
    <?php echo form_open(current_url(), array('method' => 'get')) ?>
    <div class="row">                
        <div class="col-md-3">                 
            <input autofocus type="text" name="n" id="field" placeholder="Nama" class="form-control">            
        </div>                
        <input type="submit" class="btn btn-success" value="Cari">
    </div>
</div>
<?php echo form_close() ?>
</div>
<?php echo validation_errors() ?>
<br>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="controls" align="center">Arsip</th>
                <th class="controls" align="center">No Surat</th>
                <th class="controls" align="center">Tanggal</th>
                <th class="controls" align="center">Kategori</th>
                <th class="controls" align="center">Aksi</th>
            </tr>
        </thead>
        <?php				
        if (!empty($arsip)) {
            foreach ($arsip as $row) {
                ?>
                <tbody>
                    <tr>
                        <td ><?php echo $row['arsip_generate']; ?></td>
                        <td ><?php echo $row['arsip_number']; ?></td>
                        <td ><?php echo pretty_date($row['arsip_date'], 'd F Y', false); ?></td>
                        <td ><?php echo $row['category_name']; ?></td>
                        <td>
                            <a class="btn btn-warning btn-xs" href="<?php echo site_url('admin/arsip/detail/' . $row['arsip_id']); ?>" ><span class="glyphicon glyphicon-eye-open"></span></a>
                            <a class="btn btn-success btn-xs" href="<?php echo site_url('admin/arsip/edit/' . $row['arsip_id']); ?>" ><span class="glyphicon glyphicon-edit"></span></a>                            
                            </td>
                        </tr>
                    </tbody>
                    <?php
                }
            } else {
                ?>
                <tbody>
                    <tr id="row">
                        <td colspan="5" align="center">Data Kosong</td>
                    </tr>
                </tbody>
                <?php
            }
            ?>   
        </table>
    </div>
    <div >
        <?php echo $this->pagination->create_links(); ?>
    </div>
</div>
</div>

<script>
    $(function() {

        var arsip_list = [
        <?php foreach ($arsips as $row): ?>
        {
                       
            "label": "<?php echo $row['arsip_generate'] ?>",
            "label_nik": "<?php echo $row['arsip_number'] ?>"

        },
    <?php endforeach; ?>
    ];
    function custom_source(request, response) {
        var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
        response($.grep(arsip_list, function(value) {
            return matcher.test(value.label)
            || matcher.test(value.label_nik);
        }));
    }

    $("#field").autocomplete({
        source: custom_source,
        minLength: 1,
        select: function(event, ui) {
                // feed hidden id field                
                $("#field_id").val(ui.item.label_nik);  
                $("#field_name").val(ui.item.value);                

                // update number of returned rows
            },
            open: function(event, ui) {
                // update number of returned rows
                var len = $('.ui-autocomplete > li').length;
            },
            close: function(event, ui) {
                // update number of returned rows
            },
            // mustMatch implementation
            change: function(event, ui) {
                if (ui.item === null) {
                    $(this).val('');
                    $('#field_id').val('');
                }
            }
        });

        // mustMatch (no value) implementation
        $("#field").focusout(function() {
            if ($("#field").val() === '') {
                $('#field_id').val('');
            }
        });
    });
</script>