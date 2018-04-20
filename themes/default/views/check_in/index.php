<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>
<?php
$v = "?v=1";

if ($this->input->post('from_date')) {
    $v .= "&start_date=" . $this->input->post('from_date');
}
if ($this->input->post('till_date')) {
    $v .= "&end_date=" . $this->input->post('till_date');
}
?>
<div class="">
    <h3><i class="fa fa-arrow-circle-up"></i> <?=$page_title;?><a href="<?=site_url('check_in/add')?>" class="btn btn-primary pull-right" style="margin-right:5px;"><i class="fa fa-plus"></i> <?=lang('add_check_in');?></a></h3>
    <p><?= lang('list_results'); ?></p>
</div>
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
                                <th class="col-xs-3"><?=lang('store');?></th><!--edit by sajid--->
                                <th class="col-xs-2"><?=lang('created_by');?></th>
                                <th class="col-xs-2"><?=lang('note');?></th>
                                <th class="col-xs-1"><i class="fa fa-chain"></i></th>
                                <th class="col-xs-1"><?=lang('actions');?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="8" class="dataTables_empty"><?= lang("loading_data_from_server"); ?></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><input class="form-control full-width" placeholder="[<?=lang('id');?>]" type="text"></th>
                                <th class="col-xs-3"><input class="form-control full-width" id="date_range" placeholder="[<?=lang('date');?>]" type="text"></th>
                                <th class="col-xs-2">[<?=lang('reference');?>]</th>
                                <th class="col-xs-3">[<?=lang('store');?>]</th>
                                <th class="col-xs-2">[<?=lang('created_by');?>]</th>
                                <th class="col-xs-2">[<?=lang('note');?>]</th>
                                <th class="col-xs-1"><i class="fa fa-chain"></i></th>
                                <th class="col-xs-1"><?=lang('actions');?></th>
                            </tr>
                            <tr>
                                <td colspan="8" class="p0"><input type="text" class="form-control b0" name="search_table" id="search_table" placeholder="[<?= lang('type_hit_enter'); ?>]" style="width:100%;"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        function download(x) {
            if(x !== null) {
                return '<div class="text-center"><a href="<?=site_url('welcome/download');?>/'+x+'"><i class="fa fa-chain"></i></a></div>';
            }
            return '';
        }

        var table = $('#TTable').DataTable({

            "order": [[ 1, "desc" ]],
            "pageLength": <?=$Settings->rows_per_page;?>,
            "processing": true, "serverSide": true,
            'ajax' : { url: '<?=site_url('check_in/get_list/'.$v);?>', type: 'POST', "data": function ( d ) {
                d.<?=$this->security->get_csrf_token_name();?> = "<?=$this->security->get_csrf_hash()?>";
            }},
            rowId: 'id',
            "buttons": [
            { extend: 'copyHtml5', exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6 ] } },
            { extend: 'excelHtml5', 'footer': true, exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6 ] } },
            { extend: 'csvHtml5', 'footer': true, exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6 ] } },
            { extend: 'pdfHtml5', orientation: 'landscape', pageSize: 'A4', 'footer': true, 
            exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6 ] },
            customize: function (doc) {
                doc.content[1].table.widths = 
                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
            } },
            { extend: 'colvis', text: 'Columns' },
            ],
            "columns": [
            { "data": "id", "visible": false },
            { "data": "date", "render": hrld },
            { "data": "reference" },
            { "data": "store_name" <?php if(!$Admin) echo ',  "visible": false' ;?>  },  //edit by sajid
            { "data": "created_by" },
            { "data": "note" },
            { "data": "attachment", "render": download },
            { "data": "Actions", "searchable": false, "orderable": false<?= $Admin ? '' : ', "visible": false'; ?> }
            ],
            'fnRowCallback': function (nRow, aData) {
                nRow.id = aData.id; nRow.className = "check_in_link";
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
            table.ajax.url( '<?=site_url('check_in/get_list');?>?start_date='+startDate+'&end_date='+endDate ).load();
        });

        $("#date_range").on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            table.ajax.url( '<?=site_url('check_in/get_list');?>' ).load();
        });

        // var oTable = $('#TTable').dataTable({
        //     "aaSorting": [[1, "desc"]],
        //     "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
        //     "iDisplayLength": 10, 'bServerSide': true, 'bProcessing' : true,
        //     'sAjaxSource': '<?= site_url('check_in/get_list/'.$v); ?>',
        //     'fnServerData': function(sSource, aoData, fnCallback) {
        //         aoData.push( { "name": "<?= $this->security->get_csrf_token_name(); ?>", "value": "<?= $this->security->get_csrf_hash() ?>" } );
        //         $.ajax ({ 'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback });
        //     },
        //     'fnRowCallback': function (nRow, aData, iDisplayIndex) {
        //         var oSettings = oTable.fnSettings();
        //         nRow.id = aData[0]; nRow.className = "check_in_link";
        //         return nRow;
        //     },
        //     "aoColumns": [{"bVisible": false}, {"mRender": hrld}, null, null, null, {"bVisible": false}, {"mRender": download}, null]
        // });
    });
</script>
