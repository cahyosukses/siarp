<div class="col-md-12 col-sm-12 col-xs-12 main post-inherit">
    <div class="x_panel post-inherit">
        <h3 class="">
            List Kategori
            <a href="<?php echo site_url('admin/category/add'); ?>" ><span class="glyphicon glyphicon-plus-sign"></span></a>
        </h3><br>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="controls" align="center">NO</th>
                        <th class="controls" align="center">Nama Kategori</th>                        
                        <th class="controls" align="center">AKSI</th>
                    </tr>
                </thead>
                <?php
                $i=1;
                
                foreach ($category as $row): 
                    ?>
                <tbody>
                    <tr>
                        <td ><?php echo $i ?></td>
                        <td ><?php echo $row['category_name']; ?></td>
                        
                        <td>
                            <a class="btn btn-warning btn-xs" href="<?php echo site_url('admin/category/detail/' . $row['category_id']); ?>" ><span class="glyphicon glyphicon-eye-open"></span></a>
                            <a class="btn btn-success btn-xs" href="<?php echo site_url('admin/category/edit/' . $row['category_id']); ?>" ><span class="glyphicon glyphicon-edit"></span></a>
                            
                        </td>
                    </tr>
                    
                </tbody> <?php $i++; endforeach; ?>                        
            </table>
        </div>
        <div >
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
</div>