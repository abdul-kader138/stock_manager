<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>
<style type="text/css">
    .table td:first-child { padding: 3px; }
    .table td:last-child { padding: 6px; }
    .table td:first-child, .table td:nth-child(5), .table td:nth-child(6), .table td:nth-child(7), .table td:last-child { text-align: center; }
</style>

<div class="">
    <div class="box-icon">
    <h3><i class="fa fa-th"></i> <?=$page_title;?>
            <a href="#" class="toggle_up tip" title="<?= lang('hide_form') ?>"><i
                        class="icon fa fa-toggle-up"></i></a>
            <a href="#" class="toggle_down tip" title="<?= lang('show_form') ?>"><i
                        class="icon fa fa-toggle-down"></i></a></div>
    <?php if ($this->input->post('start_date')) {
        echo" # ". $this->input->post('start_date') . " - " . $this->input->post('end_date');}

    ?>&nbsp; &nbsp;&nbsp;
    </h3>
</div>
<div id="form">

    <?php echo form_open("check_out/transaction_details"); ?>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <?= lang("start_date", "start_date"); ?>
                <?php echo form_input('start_date', (isset($_POST['start_date']) ? $_POST['start_date'] : ""), 'class="form-control date" required ="required" id="start_date"'); ?>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <?= lang("end_date", "end_date"); ?>
                <?php echo form_input('end_date', (isset($_POST['end_date']) ? $_POST['end_date'] : ""), 'class="form-control date" required ="required" id="end_date"'); ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="controls"> <?php echo form_submit('submit', $this->lang->line("submit"), 'class="btn btn-primary"');?> </div>  </div>
    <?php echo form_close(); ?>

</div>
<div class="clearfix"></div>
<?php if($this->input->post('submit')) { ?>
<div class="row">
    <div class="row">
        <div class="col-lg-12">
            <div class="content-panel">
                <div class="table-responsive">
                    <table id="TTable" class="table table-bordered table-striped cf" style="margin-bottom:5px;">
                        <thead class="cf">
                        <tr>
                            <th><?=lang('id');?></th>
                            <th class="col-xs-3"><?=lang('date');?></th>
                            <th class="col-xs-2"><?=lang('reference');?></th>
                            <th class="col-xs-3"><?=lang('store');?></th><!-- edit by sajid-->
                            <th class="col-xs-2"><?=lang('name');?></th>
                            <th class="col-xs-1"><?=lang('number');?></th>
                            <th class="col-xs-1"><?=lang('code');?></th>
                            <th class="col-xs-1"><?=lang('quantity');?></th>
                            <th class="col-xs-1"><?=lang('unit');?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="9" class="dataTables_empty"><?= lang("loading_data_from_server"); ?></td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th><input class="form-control full-width" placeholder="<?=lang('id');?>" type="text"></th>
                            <th class="col-xs-3"><input class="form-control full-width" id="date_range" placeholder="<?=lang('date');?>" type="text"></th>
                            <th class="col-xs-2"><?=lang('reference');?></th>
                            <th class="col-xs-1"><?=lang('store');?></th>
                            <th class="col-xs-2"><?=lang('name');?></th>
                            <th class="col-xs-2"><?=lang('number');?></th>
                            <th class="col-xs-1"><?=lang('code');?></th>
                            <th class="col-xs-1"><?=lang('quantity');?></th>
                            <th class="col-xs-1"><?=lang('unit');?></th>
                        </tr>
                        <tr>
                            <td colspan="9" class="p0"><input type="text" class="form-control b0" name="search_table" id="search_table" placeholder="<?= lang('type_hit_enter'); ?>" style="width:100%;"></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<script type="text/javascript">
    $(document).ready(function() {
        <?php if($this->input->post('submit')) { echo "$('#form').hide();"; } ?>
        $('.toggle_down').click(function () {
            $("#form").slideDown();
            return false;
        });
        $('.toggle_up').click(function () {
            $("#form").slideUp();
            return false;
        });
        function image(n) {
            if(n !== null && n != '') {
                return '<div style="width:32px; margin: 0 auto;"><a href="<?=base_url();?>uploads/'+n+'" class="open-image"><img src="<?=base_url();?>uploads/'+n+'" alt="" class="img-responsive"></a></div>';
            }
            return '';
        }
        var table = $('#TTable').DataTable({

            "order": [[ 1, "asc" ]],
            "pageLength": <?=$Settings->rows_per_page;?>,
            "processing": true, "serverSide": true,
            'ajax' : { url: '<?=site_url('check_out/get_all_transaction');?>', type: 'POST', "data": function ( d ) {
                    d.<?=$this->security->get_csrf_token_name();?> = "<?=$this->security->get_csrf_hash()?>";
                    d.start_date=$("#start_date").val();
                    d.end_date=$("#end_date").val();
                }},
            rowId: 'id',
            <?php $cols =  $Admin? ' 1, 2, 3, 4, 5,6,7,8': ' 1, 2, 4, 5,6,7,8'; ?>
            "buttons": [
                { extend: 'copyHtml5', exportOptions: { columns: [ <?= $cols ?> ] } },
                { extend: 'excelHtml5', 'footer': true, exportOptions: { columns: [ <?= $cols ?> ] } },
                { extend: 'csvHtml5', 'footer': true, exportOptions: { columns: [ <?= $cols ?> ] } },
                { extend: 'pdfHtml5', orientation: 'landscape', pageSize: 'A4', 'footer': true,
                    exportOptions: { columns: [ <?= $cols ?> ] },
                    customize: function (doc) {
                        doc.content[1].table.widths =
                            Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    } },
                // { extend: 'colvis', text: 'Columns' },
            ],
            "columns": [
                { "data": "id", "visible": false },
                { "data": "date", "render": hrld },
                { "data": "reference","searchable": true},
                { "data": "store_name" <?= $Admin ? '' : ', "visible": false'; ?>},
                { "data": "item_name","searchable": true },
                { "data": "number","searchable": true },
                { "data": "item_code","searchable": true },
                { "data": "qty","searchable": true },
                { "data": "um" }
            ],
            'fnRowCallback': function (nRow, aData) {
                nRow.id = aData.id; nRow.className = "check_out_link";
                return nRow;
            }
        });

        $('#TTable tfoot th:not(:nth-child(1), :nth-last-child(2), :last)').each(function () {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control full-width" placeholder="'+title+'" />' );
        });

        $('#search_table').on( 'keyup change', function (e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (((code == 13 && table.search() !== this.value) || (table.search() !== '' && this.value === ''))) {
                table.search( this.value ).draw();
            }
        });

        table.columns().every(function () {
            var self = this;
            $( 'input', this.footer() ).on( 'keyup change', function (e) {
                var code = (e.keyCode ? e.keyCode : e.which);
                if (((code == 13 && self.search() !== this.value) || (self.search() !== '' && this.value === ''))) {
                    self.search( this.value ).draw();
                }
            });
            $( 'select', this.footer() ).on( 'change', function (e) {
                self.search( this.value ).draw();
            });
        });

        $("#date_range").daterangepicker({
            autoUpdateInput: false,
            timePicker: true,
            timePicker24Hour: true,
            ranges: {
                "Today": [moment().startOf('day'), moment().endOf('day')],
                'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
                '7 last days': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
                '30 last days': [moment().subtract(29, 'days').startOf('day'), moment().endOf('day')],
                'This month': [moment().startOf('month'), moment().endOf('month')],
                'Last month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            locale: {
                "cancelLabel": "Clear",
            }
        });


        $("#date_range").on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm') + ' to ' + picker.endDate.format('YYYY-MM-DD H:mm'));
            startDate = picker.startDate.format('YYYY-MM-DD');
            endDate = picker.endDate.format('YYYY-MM-DD');
            table.ajax.url( '<?=site_url('check_out/get_all_transaction');?>?start_date='+startDate+'&end_date='+endDate ).load();
        });

        $("#date_range").on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            table.ajax.url( '<?=site_url('check_out/get_all_transaction');?>' ).load();
        });
    });
</script>
