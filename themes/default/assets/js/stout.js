    $(document).ready(function() {
        $("#add_item").autocomplete({
            source: base_url+'check_out/suggestions',
            minLength: 1,
            autoFocus: false,
            delay: 200,
            response: function (event, ui) {
                if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    alert(lang.no_match_found, function () {
                        $('#add_item').focus();
                    });
                    $(this).val('');
                }
                else if (ui.content.length == 1 && ui.content[0].id != 0) {
                    ui.item = ui.content[0];
                    $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete('close');
                }
                else if (ui.content.length == 1 && ui.content[0].id == 0) {
                    alert(lang.no_match_found, function () {
                        $('#add_item').focus();
                    });
                    $(this).val('');
                }
            },
            select: function (event, ui) {
                event.preventDefault();
                if (ui.item.id !== 0) {
                    var row = add_order_item(ui.item);
                    if (row)
                        $(this).val('');
                } else {
                    bootbox.alert(lang.no_match_found);
                }
            }
        });

        // $("#customer").autocomplete({
        //     source: base_url+'check_out/customers',
        //     minLength: 1,
        //     autoFocus: false,
        //     delay: 200
        // });

        $('#add_item').bind('keypress', function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $(this).autocomplete("search");
            }
        });

        $(document).on('click', '.stoutdel', function (e) {
            e.preventDefault();
            var row = $(this).closest('tr');
            var item_id = row.attr('data-item-id');
            delete stoutitems[item_id];
            row.remove();
            if(stoutitems.hasOwnProperty(item_id)) { } else {
                store('stoutitems', JSON.stringify(stoutitems));
                loadInItems();
                return;
            }
        });

        var old_row_qty;
        $(document).on("focus", '.rquantity', function () {
            old_row_qty = $(this).val();
        }).on("change", '.rquantity', function () {
            var row = $(this).closest('tr');
            if (!is_numeric($(this).val())) {
                $(this).val(old_row_qty);
                bootbox.alert(lang.unexpected_value);
                return;
            }
            var new_qty = parseFloat($(this).val()),
            item_id = row.attr('data-item-id');
            stoutitems[item_id].row.qty = new_qty;
            store('stoutitems', JSON.stringify(stoutitems));
	        loadInItems();
        });

        
        $(document).on("change", '.rplate_code', function () {
            
            var row = $(this).closest('tr');
            
            var plate_code = $(this).val(),
            item_id = row.attr('data-item-id');
            stoutitems[item_id].plate_code = plate_code;
            store('stoutitems', JSON.stringify(stoutitems));
	        loadInItems();
        });
        
        $(document).on("change", '.rplate_number', function () {
            
            var row = $(this).closest('tr');
            
            var plate_number = $(this).val(),
            item_id = row.attr('data-item-id');
            stoutitems[item_id].plate_number = plate_number;
            store('stoutitems', JSON.stringify(stoutitems));
	        loadInItems();
        });

    });

function loadInItems() {

    if (get('stoutitems')) {

        $("#inTable tbody").empty();

        stoutitems = JSON.parse(get('stoutitems'));

        $.each(stoutitems, function () {
            var item = this;
            var item_id = item.id;

			var serial_number = item.serial_number;
			var plate_number = item.plate_number;
			var plate_code = item.plate_code;

            stoutitems[item_id] = item;


            var product_id = item.row.id, item_qty = item.row.qty, item_aqty = item.row.quantity, item_code = item.row.code,
            item_name = item.row.name.replace(/"/g, "&#034;").replace(/'/g, "&#039;");


            console.log(this);
            var row_no = (new Date).getTime();
            var newTr = $('<tr id="' + row_no + '" class="' + item_id + '" data-item-id="' + item_id + '"></tr>');
            tr_html = '<td style="min-width:100px;"><input name="product_id[]" type="hidden" class="rid" value="' + product_id + '"><span class="sname" id="name_' + row_no + '">' + item_name + ' (' + item_code + ')</span></td>';

			tr_html += '<td style="padding:2px;"><input class="form-control input-sm kb-pad text-center rserial_number" name="serial_number[]" type="text" value="' + serial_number + '" data-id="' + row_no + '" data-item="' + item_id + '" id="serial_number_' + row_no + '"  onClick="this.select();"></td>';
			tr_html += '<td style="padding:2px;"><input class="form-control input-sm kb-pad text-center rplate_number" name="plate_number[]" type="text" value="' + plate_number + '" data-id="' + row_no + '" data-item="' + item_id + '" id="plate_code_' + row_no + '"  onClick="this.select();"></td>';

			tr_html += '<td style="padding:2px;"><input class="form-control input-sm kb-pad text-center rplate_code" name="plate_code[]" type="text" value="' + plate_code + '" data-id="' + row_no + '" data-item="' + item_id + '" id="plate_code_' + row_no + '"   onClick="this.select();"></td>';

			tr_html += '<td style="padding:2px;"><input class="form-control input-sm kb-pad text-center rquantity" name="quantity[]" type="text" value="' + item_qty + '" data-id="' + row_no + '" data-item="' + item_id + '" id="quantity_' + row_no + '" onClick="this.select();"></td>';

            tr_html += '<td class="text-center"><i class="fa fa-trash-o tip pointer stoutdel" id="' + row_no + '" title="Remove"></i></td>';

            newTr.html(tr_html);
            newTr.prependTo("#inTable");
            if(item_aqty < item_qty) {
                $('#'+row_no).addClass('danger');
            }
        });

       // $('#add_item').focus();
    }
}

function add_order_item(item) {
    var item_id = item.id;
	var plate_number = '';
	var serial_number = '';
	var plate_code = '';
	
	index = unique_id();
		
    if (stoutitems[index]) {
        stoutitems[index].row.qty = parseFloat(stoutitems[index].row.qty) + 1;
        stoutitems[index].row.serial_number = serial_number;
        stoutitems[index].row.plate_number = plate_number;
        stoutitems[index].row.plate_code = plate_code;
    } else {
		item.id = index;
		item.serial_number = serial_number;
		item.plate_number = plate_number;
        item.plate_code = plate_code;
        stoutitems[index] = item;
    }

    store('stoutitems', JSON.stringify(stoutitems));
    loadInItems();
    return true;
}

function unique_id(){
	var date = new Date();
	var components = [
		date.getYear(),
		date.getMonth(),
		date.getDate(),
		date.getHours(),
		date.getMinutes(),
		date.getSeconds(),
		date.getMilliseconds()
	];

	return components.join("");
}