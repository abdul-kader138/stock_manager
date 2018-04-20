<div class="">
<h3><i class="fa fa-user"></i> <?= lang('add_user'); ?></h3>
<p><?= lang('enter_info'); ?></p>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="content-panel">
            <?php
            echo form_open("auth/create_user");
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo lang('first_name', 'first_name'); ?> 
                            <div class="controls">
                                <?php echo form_input('first_name', '', 'class="form-control" id="first_name" pattern=".{3,10}"'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo lang('last_name', 'last_name'); ?>
                            <div class="controls">
                                <?php echo form_input('last_name', '', 'class="form-control" id="last_name"'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <?= lang("group", "group"); ?>
                            <?php
                            $gp[""] = "";
                            foreach ($groups as $group) {
                                if($group['name'] != 'customer' && $group['name'] != 'supplier') {
                                    $gp[$group['id']] = $group['name'];
                                }
                            }
                            echo form_dropdown('group', $gp, (isset($_POST['group']) ? $_POST['group'] : ''), 'id="group" data-placeholder="' . lang("select") . ' ' . lang("group") . '" class="form-control input-tip select" style="width:100%;"');
                            ?> 
                        </div>
						
						
                            <div class="form-group <?php echo (isset($_POST['store']) ? '' : 'hidden') ?>" >
                                <?= lang('store', 'store'); ?>
                                <?php 
                                $st[''] = lang('select_store');
                                foreach ($stores as $store) {
                                    $st[$store->id] = $store->store_name;
                                }
								?>
								
                                <?= form_dropdown('store', $st, (isset($_POST['store']) ? $_POST['store'] : ''), 'class="form-control tip" id="store"'); ?>
                            </div>
                        
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo lang('phone', 'phone'); ?>
                            <div class="controls">
                                <?php echo form_input('phone', '', 'class="form-control" id="phone"'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo lang('email', 'email'); ?> 
                            <div class="controls">
                                <input type="email" id="email" name="email" class="form-control" />
                            </div>
                        </div></div>
                        <div class="col-md-4"><div class="form-group">
                            <?php echo lang('username', 'username'); ?> 
                            <div class="controls">
                                <input type="text" id="username" name="username" class="form-control" pattern=".{4,20}"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo lang('password', 'password'); ?> 
                            <div class="controls">
                                <?php echo form_password('password', '', 'class="form-control tip" id="password" pattern=".{8,}"'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo lang('confirm_password', 'confirm_password'); ?>
                            <div class="controls">
                                <?php echo form_password('confirm_password', '', 'class="form-control" id="confirm_password" pattern=".{8,}"'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <?= lang('status', 'status'); ?>
                            <?php
                            $opt = array('' => '', 1 => lang('active'), 0 => lang('inactive'));
                            echo form_dropdown('status', $opt, (isset($_POST['status']) ? $_POST['status'] : ''), 'id="status" data-placeholder="' . lang("select") . ' ' . lang("status") . '" class="form-control input-tip select" style="width:100%;"');
                            ?> 
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-12">
                        <div class="col-md-8" style="margin-left:10px;"><label class="checkbox" for="notify"><input type="checkbox" name="notify" value="1" id="notify" checked="checked" /> <?= lang('notify_user_by_email') ?></label>
                        </div>
                        <div class="clearfix"></div>
                        <p><?php echo form_submit('add_user', lang('add_user'), 'class="btn btn-theme03"'); ?></p>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
$('#group').change(function(){
	elm =  $(this);
	if(elm.val() ==2){
		$('#store').parents('.form-group').removeClass('hidden');
	}else{
		$('#store').parents('.form-group').addClass('hidden');
	}	
});
</script>
