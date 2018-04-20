<div class="">
    <h3><i class="fa fa-edit"></i> <?=$page_title;?></h3>
    <p><?= lang('enter_info'); ?></p>
</div>
<div class="row">
    <div class="row">
        <div class="col-lg-12">
            <div class="content-panel">
                <?php echo form_open("stores/edit/".$store->id);?>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="code"><?= $this->lang->line("store"); ?></label>
                        <?= form_input('store_name', set_value('store_name', $store->store_name), 'class="form-control input-sm" id="store"'); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="email_address"><?= $this->lang->line("location"); ?></label>
                        <?= form_input('location', set_value('location', $store->location), 'class="form-control input-sm" id="location"'); ?>
                    </div>
                </div>
                
               
                <div class="col-md-12">
                    <div class="form-group">
                        <?php echo form_submit('edit_store', $this->lang->line("edit_store"), 'class="btn btn-primary"');?>
                    </div>
                </div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>