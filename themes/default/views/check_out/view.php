<div class="modal-dialog modal-lg no-modal-header">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i></button>
            <h4 class="modal-title" id="myModalLabel"><?= $page_title; ?></h4>
          </div>
        <div class="modal-body">

            <div class="well well-sm">
                <div class="row bold">
                    <div class="col-sm-12">
                    <table class="table mb0">
                        <tbody>
                            <tr>
                                <td class="col-xs-3" style="border-top:0;"><?= lang("ref"); ?></td>
                                <td class="col-xs-9" style="border-top:0;">: <?= $inv->reference; ?></td>
                            </tr>
                            <tr>
                                <td><?= lang("date"); ?></td>
                                <td>: <?= $this->tec->hrld($inv->date); ?></td>
                            </tr>
                            <tr>
                                <td><?= lang("store"); ?></td>
                                <td>: <?= $store ? $store->store_name : ''; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="table-responsive">
                <table id="TLTable" class="table table-bordered table-hover table-striped print-table order-table">

                    <thead>

                    <tr>
                        <th><?= lang("no"); ?></th>
                        <th><?= lang("description"); ?></th>
                        <th><?= lang("plate number"); ?></th>
                        <th><?= lang("plate code"); ?></th>
                        <th><?= lang("quantity"); ?></th>
                    </tr>

                    </thead>

                    <tbody>

                    <?php $r = 1;
                    $tax_summary = array();
					if(!empty($items)){
						foreach ($items as $row):
					?>
							<tr>
								<td style="text-align:center; width:40px; vertical-align:middle;"><?= $r; ?></td>
								<td style="vertical-align:middle;">
									<?= $row->item_name . " (" . $row->item_code . ")"; ?>
								</td>
								<td class="col-xs-2" style="text-align:center; vertical-align:middle;"><?= $row->plate_number; ?></td>
								<td class="col-xs-2" style="text-align:center; vertical-align:middle;"><?= $row->plate_code; ?></td>
								<td class="col-xs-2" style="text-align:center; vertical-align:middle;"><?= $row->quantity; ?></td>
							</tr>
					<?php
							$r++;
						endforeach;
					}
                    ?>
                    </tbody>
					<tfoot>
						<tr>
							<th>[<?= lang("no"); ?>]</th>
							<th>[<?= lang("description"); ?>]</th>
							<th>[<?= lang("plate number"); ?>]</th>
							<th>[<?= lang("plate code"); ?>]</th>
							<th>[<?= lang("quantity"); ?>]</th>
						</tr>
						
                            <tr>
                                <td colspan="8" class="p0"><input type="text" class="form-control b0" name="search_table" id="search_table" placeholder="<?= lang('type_hit_enter'); ?>" style="width:100%;"></td>
                            </tr>
                       
					</tfoot>
                </table>
            </div>

            <div class="row">
                <div class="col-xs-7">
                    <?php
                        if ($inv->note || $inv->note != "") { ?>
                            <div class="well well-sm">
                                <p class="bold"><?= lang("note"); ?>:</p>
                                <div><?= $this->tec->decode_html($inv->note); ?></div>
                            </div>
                        <?php
                        }
                        ?>
                </div>

                <div class="col-xs-5 pull-right mb0">
                    <div class="well well-sm">
                        <p>
                            <?= lang("created_by"); ?>: <?= $created_by->first_name . ' ' . $created_by->last_name; ?> <br>
                            <?= lang("date"); ?>: <?= $this->tec->hrld($inv->date); ?>
                        </p>
                        <?php if ($inv->updated_by) { ?>
                        <p>
                            <?= lang("updated_by"); ?>: <?= $updated_by->first_name . ' ' . $updated_by->last_name;; ?><br>
                            <?= lang("update_at"); ?>: <?= $this->tec->hrld($inv->updated_at); ?>
                        </p>
                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>

        var table = $('#TLTable').DataTable({

            "order": [[ 1, "desc" ]],
            
            rowId: 'id',
            "buttons": [
            { extend: 'copyHtml5', exportOptions: { columns: [ 0, 1, 2, 3, 4] } },
            { extend: 'excelHtml5', 'footer': true, exportOptions: { columns: [ 0, 1, 2, 3, 4] } },
            { extend: 'csvHtml5', 'footer': true, exportOptions: { columns: [ 0, 1, 2, 3, 4 ] } },
            { extend: 'pdfHtml5', orientation: 'landscape', pageSize: 'A4', 'footer': true, 
            exportOptions: { columns: [ 0, 1, 2, 3, 4 ] },
            customize: function (doc) {
                doc.content[1].table.widths = 
                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
            } }, { extend: 'colvis', text: 'Columns' },
            ],
                    });
					
					
			
        $('#TLTable tfoot th:not(:nth-child(1))').each(function () {
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
		

		
</script>