<div class="content-wrapper">
    <section class="content">
    <div class="row">
            <div class="col-xs-12">
                <div class="box box-black box-solid">
                    <div class="box-header">
                        <h3 class="box-title">Lab Consumables - Stock Take</h3>
                    </div>
                        <div class="box-body">
                            <div style="padding-bottom: 10px;">
                                <?php
                                        $lvl = $this->session->userdata('id_user_level');
                                        if ($lvl != 7){
                                            echo "<button class='btn btn-primary' id='addtombol'><i class='fa fa-wpforms' aria-hidden='true'></i> New Stock Take </button>";
                                        }
                                ?>
                                <?php //echo anchor(site_url('tbl_delivery/new'), '<i class="fa fa-wpforms" aria-hidden="true"></i> New Delivery', 'class="btn btn-danger btn-sm"'); ?>
                                <?php //echo anchor(site_url('tbl_delivery/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> New Sample', 'class="btn btn-danger btn-sm"'); ?>
                                <?php echo anchor(site_url('consumables_stock_take/excel'), '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export to XLS', 'class="btn btn-success"'); ?>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped tbody" id="mytable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Objective</th>
                                        <th>Product Name</th>
                                        <th>Number of closed containers</th>
                                        <th>Unit of measure counted in the lab</th>
                                        <th>Quantity Measured per Unit</th>
                                        <th>Unit Of Measure</th>
                                        <th>Number of loose items </th>
                                        <th>Total Quantity</th>
                                        <th>Collection Date</th>
                                        <th>Collection Time</th>
                                        <th>Comments</th>
                                        <!-- <th>Indonesia Comments</th> -->
                                        <!-- <th>Melbourne Comments</th> -->
                                        <!-- <th>Time Collected </th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        .table tbody tr.selected {
            color: white !important;
            background-color: #9CDCFE !important;
        }
    </style>
    

    <!-- START MODAL FORM -->
    <div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header box">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="modal-title">Consumables - In Stock</h4>
                </div>
                <form id="formSample"  action= <?php echo site_url('consumables_stock_take/saveConsumablesInStock') ?> method="post" class="form-horizontal">
                    <div class="modal-body">
                        <input id="mode" name="mode" type="hidden" class="form-control input-sm">
                        <input id="id_stock1" name="id_stock1" type="hidden" class="form-control input-sm">

                        <div class="form-group" id="idx">
                            <label for="id_instock" class="col-sm-4 control-label">ID In Stock</label>
                            <div class="col-sm-8">
                                <input id="id_instock" name="id_instock" placeholder="Id In stock" type="text" class="form-control">
                            </div>
                        </div>

                        <!-- <div class="form-group">
							<label for="id_objective" class="col-sm-4 control-label">Objective</label>
							<div class="col-sm-8" >
								<select id='id_objective' name="id_objective" class="form-control idObjectiveSelect">
									<option>-- Select Objective --</option>
									<?php
									foreach($objectives as $row){
										if ($id == $row['id_objective']) {
											echo "<option value='".$row['id_objective']."' selected='selected'>".$row['objective']."</option>";
										}
										else {
											echo "<option value='".$row['id_objective']."'>".$row['objective']."</option>";
										}
									}
										?>
								</select>
							</div>
						</div> -->

                        <div class="form-group">
                            <label for="id_objective" class="col-sm-4 control-label">Objective</label>
                            <div class="col-sm-4">
                                <?php foreach ($objectives as $row): ?>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="id_objective[]" class="idObjectiveSelect" value="<?php echo $row['id_objective']; ?>"> <?php echo $row['objective']; ?>
                                            <input type="hidden" name="id_objective1[]" class="idObjectiveSelect1" value="<?php echo $row['id_objective']; ?>">
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>



                        <!-- <div class="form-group">
							<label for="id_stock" class="col-sm-4 control-label">Product Name</label>
							<div class="col-sm-8" >
								<select id='id_stock' name="id_stock" class="form-control stockSelect">
									<option>-- Select Product Name --</option>
									<?php
									foreach($stockName as $row){
										if ($id == $row['id_stock']) {
											echo "<option value='".$row['id_stock']."' selected='selected'>".$row['product_name']."</option>";
										}
										else {
											echo "<option value='".$row['id_stock']."'>".$row['product_name']."</option>";
										}
									}
										?>
								</select>
							</div>
						</div> -->

                        <!-- <div class="form-group">
                            <label for="id_stock" class="col-sm-4 control-label">Product Name</label>
                            <div class="col-sm-8">
                                <select id="id_stock" name="id_stock" class="form-control stockSelect">
                                    <option>-- Select Product Name --</option>
                                   
                                </select>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <label for="id_stock" class="col-sm-4 control-label">Product Name</label>
                            <div class="col-sm-8">
                                <select id="id_stock" name="id_stock" class="form-control stockSelect">
                                    <option value="">-- Select Product Name --</option>
                                    <!-- Options will be populated via AJAX -->
                                </select>
                            </div>
                        </div>



                        <!-- <div class="form-group">
                            <label for="closed_container" class="col-sm-4 control-label">Number of Closed Containers</label>
                            <div class="col-sm-8">
                                <input id="closed_container" name="closed_container" type="number" class="form-control" placeholder="Number of Closed Containers" required>
                                <div class="val1tip"></div>
                            </div>
                        </div> -->

                        <!-- <div class="form-group">
                            <label for="closed_container" class="col-sm-4 control-label">Number of Closed Containers</label>
                            <div class="col-sm-8">
                                <input id="closed_container" name="closed_container" type="number" class="form-control" placeholder="Number of Closed Containers" required>
                                <div class="val1tip"></div>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <label for="closed_container" class="col-sm-4 control-label">Number of Closed Containers</label>
                            <div class="col-sm-8">
                                <div class="input-group input-group1">
                                    <input id="closed_container" name="closed_container" type="number" class="form-control" placeholder="Number of Closed Containers" required>
                                   <input id="unit_measure_lab" name="unit_measure_lab" type="text" class="form-control" placeholder="Unit" required>
                                </div>
                                <div class="val1tip"></div>
                            </div>
                        </div>


                        <!-- <div class="form-group">
                            <label for="unit_measure_lab" class="col-sm-4 control-label">Unit of measure counted in the lab</label>
                            <div class="col-sm-8">
                                <input id="unit_measure_lab" name="unit_measure_lab" type="text" class="form-control" placeholder="Unit of measure counted in the lab" required>
                                <div class="val1tip"></div>
                            </div>
                        </div> -->

                        
                        <div class="form-group">
                            <label for="quantity_per_unit" class="col-sm-4 control-label">Quantity Measured per Unit</label>
                            <div class="col-sm-8">
                                <div class="input-group input-group1">
                                    <input id="quantity_per_unit" name="quantity_per_unit" type="number" class="form-control" placeholder="Quantity Measured per Unit" required>
                                   <input id="unit_of_measure" name="unit_of_measure" type="text" class="form-control" placeholder="Unit" required>
                                </div>
                                <div class="val1tip"></div>
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <label for="quantity_per_unit" class="col-sm-4 control-label">Quantity Measured per Unit</label>
                            <div class="col-sm-8">
                                <input id="quantity_per_unit" name="quantity_per_unit" type="number" class="form-control" placeholder="Quantity Measured per Unit" required>
                                <div class="val1tip"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="unit_of_measure" class="col-sm-4 control-label">Unit of Measure</label>
                            <div class="col-sm-8">
                                <input id="unit_of_measure" name="unit_of_measure" type="text" class="form-control" placeholder="Unit of Measure" required>
                                <div class="val1tip"></div>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <label for="loose_items" class="col-sm-4 control-label">Number of loose items </label>
                            <div class="col-sm-8">
                                <input id="loose_items" name="loose_items" type="number" class="form-control" placeholder="Number of loose items " required>
                                <div class="val1tip"></div>
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <label for="total_quantity" class="col-sm-4 control-label">Total Quantity (Unit of Measure)</label>
                            <div class="col-sm-8">
                                <div class="input-group input-group1">
                                    <input id="total_quantity" name="total_quantity" type="number" class="form-control" placeholder="Total Quantity" required>
                                    <input id="unit_of_measure1" class="form-control unit-of-measure" disabled>
                                </div>
                                <div class="val1tip"></div>
                            </div>
                        </div>


                        <!-- <div class="form-group">
							<label for="unit_of_measure" class="col-sm-4 control-label">Unit Of Measure</label>
							<div class="col-sm-8" >
								<select id='unit_of_measure' name="unit_of_measure" class="form-control">
									<option>-- Select testing type --</option>
									<?php
									foreach($productName as $row){
										if ($unit_of_measure == $row['unit_of_measure']) {
											echo "<option value='".$row['unit_of_measure']."' selected='selected'>".$row['unit_of_measure']."</option>";
										}
										else {
											echo "<option value='".$row['unit_of_measure']."'>".$row['unit_of_measure']."</option>";
										}
									}
										?>
								</select>
							</div>
						</div> -->

                        <div class="form-group">
							<label for="expired_date" class="col-sm-4 control-label">Experied Date</label>
							<div class="col-sm-8">
								<input id="expired_date" name="expired_date" type="date" class="form-control" placeholder="Experied date" value="<?php echo date("Y-m-d"); ?>">
							</div>
						</div>

                        <div class="form-group">
							<label for="date_collected" class="col-sm-4 control-label">Collection Date</label>
							<div class="col-sm-8">
								<input id="date_collected" name="date_collected" type="date" class="form-control" placeholder="Collection Date" value="<?php echo date("Y-m-d"); ?>">
							</div>
						</div>

						<div class="form-group">
							<label for="time_collected" class="col-sm-4 control-label">Collection Time</label>
							<div class="col-sm-8">
								<div class="input-group clockpicker">
									<input id="time_collected" name="time_collected" class="form-control" placeholder="Collection Time" value="<?php 
									$datetime = new DateTime();
									echo $datetime->format( 'H:i' );
									?>">
									<span class="input-group-addon">
									<span class="glyphicon glyphicon-time"></span>
									</span>
								</div>
							</div>
						</div>

                        <div class="form-group">
                            <label for="comments" class="col-sm-4 control-label">Comment</label>
                            <div class="col-sm-8">
                                <textarea id="comments" name="comments" class="form-control" placeholder="Comment"> </textarea>
                                <div class="val1tip"></div>
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <label for="indonesia_comments" class="col-sm-4 control-label">Indonesia Comment</label>
                            <div class="col-sm-8">
                                <textarea id="indonesia_comments" name="indonesia_comments" class="form-control" placeholder="Indonesia Comment"> </textarea>
                                <div class="val1tip"></div>
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <label for="melbourne_comments" class="col-sm-4 control-label">Melbourne Comment</label>
                            <div class="col-sm-8">
                                <textarea id="melbourne_comments" name="melbourne_comments" class="form-control" placeholder="Melbourne Comment"> </textarea>
                                <div class="val1tip"></div>
                            </div>
                        </div> -->


                        <!-- <div class="form-group">
                            <label for="id_person" class="col-sm-4 control-label">Lab Tech</label>
                            <div class="col-sm-8">
                            <select id='id_person' name="id_person" class="form-control">
                                <option select disabled>-- Select lab tech --</option>
                                <?php
                                foreach($person as $row){
									if ($id_person == $row['id_person']) {
										echo "<option value='".$row['id_person']."' selected='selected'>".$row['realname']."</option>";
									}
									else {
                                        echo "<option value='".$row['id_person']."'>".$row['realname']."</option>";
                                    }
                                }
                                    ?>
                            </select>
                            <input id="description" name="description" type="text" class="form-control input-sm" placeholder="Item Description" required>
                            </div>
                        </div> -->

                        <!-- <div class="form-group">
                            <label for="id_type" class="col-sm-4 control-label">Sample Type</label>
                            <div class="col-sm-8">
                            <select id='id_type' name="id_type" class="form-control">
                                <option>-- Select sample type --</option>
                                <?php
                                foreach($type as $row){
									if ($id_sampletype == $row['id_sampletype']) {
										echo "<option value='".$row['id_sampletype']."' selected='selected'>".$row['sampletype']."</option>";
									}
									else {
                                        echo "<option value='".$row['id_sampletype']."'>".$row['sampletype']."</option>";
                                    }
                                }
                                    ?>
                            </select>
                            <input id="description" name="description" type="text" class="form-control input-sm" placeholder="Item Description" required>
                            </div>
                        </div> -->
                        
                        <!-- 
                        <div class="form-group">
                            <label for="png_control" class="col-sm-4 control-label">P&G Control</label>
                            <div class="col-sm-8">
                            <select id='png_control' name="png_control" class="form-control">
                                <option select disabled>-- Select answer --</option>
								<option value='Yes'>Yes</option>
								<option value='No'>No</option>
                            </select>
                            <input id="description" name="description" type="text" class="form-control input-sm" placeholder="Item Description" required>
                            </div>
                        </div> -->

                        <!-- <div class="form-group">
								  <label for="cold_chain" class="col-sm-4 control-label">Cold Chain</label>
								  <div class="col-sm-8">
									<select class="form-control" id="cold_chain" name="cold_chain" required>
                                    <option select disabled>-- Select cold chain --</option>
									<?php
                                    echo "<option value='1. Most gel packs frozen solids' >1. Most gel packs frozen solids</option>
                                          <option value='2. Most gel packs partially frozen/mushy' >2. Most gel packs partially frozen/mushy</option> 
                                          <option value='3. Most gel packs entirely liquid contents' >3. Most gel packs entirely liquid contents</option>";
									?>
									</select>
								  </div>
						</div>			 -->

						<!-- <div class="form-group">
								  <label for="cont_intact" class="col-sm-4 control-label">Container - leaks or breakage</label>
								  <div class="col-sm-8">
									<select class="form-control" id="cont_intact" name="cont_intact" required>
                                    <option select disabled>-- Select answer --</option>
									<?php
                                    echo "<option value='Y' >Yes</option>
                                          <option value='N' >No</option> ";
									?>
									</select>
								  </div>
						</div> -->

                        <!-- <div class="form-group">
                                    <label for="comments" class="col-sm-4 control-label">Comments</label>
                                    <div class="col-sm-8">
                                        <textarea id="comments" name="comments" class="form-control" placeholder="Comments"> </textarea>
                                    </div>
                        </div> -->

                        <!-- <div class="form-group">
                            <label for="notes" class="col-sm-4 control-label">Notes</label>
                            <div class="col-sm-8">
                                <textarea id="notes" name="notes" class="form-control input-sm" placeholder="Notes"> </textarea>
                            </div>
                        </div> -->
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- END MODAL -->

    <!-- MODAL CONFIRMATION DELETE -->
    <div class="modal fade" id="confirm-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #dd4b39; color: white;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white;">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-trash"></i>  Stock Take | Delete <span id="my-another-cool-loader"></span></h4>
                </div>
                <div class="modal-body">
                    <div id="confirmation-content">
                        <div class="modal-body">
                            <p class="text-center" style="font-size: 15px;">Are you sure you want to delete ID <span id="id" style="font-weight: bold;"></span> ?</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" id="confirm-save" class="btn btn-danger"><i class="fa fa-trash"></i> Yes</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</div>

<style>
    .input-group1 {
        display: flex;
        align-items: center; /* Vertically center align items */
    }

    .input-group1 .form-control {
        margin: 0; /* Remove default margins */
    }

    .input-group1 .total-quantity {
        flex: 3; /* Take up more space */
        margin-right: -1px; /* Adjust spacing to ensure no extra gap */
    }

    .input-group1 .unit-of-measure {
        flex: 1; /* Take up less space */
        width: 100px; /* Adjust width as needed */
        text-align: center; /* Center text */
        border-left: 0; /* Remove border on the left to avoid double borders */
    }

    .form-control.stockSelect {
        width: 100% !important; /* Mengatur lebar elemen select */
    }
    .chosen-container {
        width: 100% !important; /* Mengatur lebar container Chosen */
    }
    .chosen-container-single .chosen-single {
        width: 100% !important; /* Mengatur lebar untuk dropdown tunggal */
    }
    .chosen-container-multi .chosen-choices {
        width: 100% !important; /* Mengatur lebar untuk dropdown multi */
    }

    .highlight {
        background-color: rgba(0, 255, 0, 0.1) !important;
        font-weight: bold !important;
    }
    .highlight-edit {
        background-color: rgba(0, 0, 255, 0.1) !important;
        font-weight: bold !important;
    }

</style>
<!-- Chosen CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">

<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
<script type="text/javascript">



    var table;
    var rowNum = 1;
    $(document).ready(function() {

        $('.stockSelect').chosen({
            placeholder_text_single: "-- Select Product Name --",
            no_results_text: "No results matched"
        });
        $('.chosen-container').each(function() {
            $(this).css('width', '100%');
        });

        function showConfirmation(url) {
            deleteUrl = url; // Set the URL to the variable
            $('#confirm-modal').modal('show');
        }

        // Handle the delete button click
        $(document).on('click', '.btn_delete', function() {
            let id = $(this).data('id');
            let url = '<?php echo site_url('consumables_stock_take/deleteConsumablesInStock'); ?>/' + id;
            $('#confirm-modal #id').text(id);
            console.log(id);
            showConfirmation(url);
        });

        // When the confirm-save button is clicked
        $('#confirm-save').click(function() {
            $.ajax({
                url: deleteUrl,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                    } else {
                        alert(response.message);
                    }
                },
                complete: function() {
                    $('#confirm-modal').modal('hide');
                    location.reload();
                }
            });
        });

        // Event listener untuk dropdown Objective
        // $('.idObjectiveSelect').change(function() {
        //     let id_objective = $(this).val(); 
        //     if (id_objective) {
        //         $.ajax({
        //             url: '<?php echo site_url('Consumables_stock_take/getStockByObjective'); ?>', 
        //             type: 'POST',
        //             data: { id_objective: id_objective }, 
        //             dataType: 'json', 
        //             success: function(response) {
        //                 let $stockSelect = $('#id_stock');
        //                 $stockSelect.empty(); // Clear existing options
        //                 $stockSelect.append('<option value="">-- Select Product Name --</option>');
                        
        //                 // Add new options based on response
        //                 $.each(response, function(index, item) {
        //                     $stockSelect.append('<option value="' + item.id_stock + '">' + item.product_name + '</option>');
        //                 });

        //                 // Re-initialize Chosen after updating options
        //                 $stockSelect.trigger('chosen:updated');
           
        //             },
        //             error: function(jqXHR, textStatus, errorThrown) {
        //                 console.error('AJAX error:', textStatus, errorThrown);
        //             }
        //         });
        //     } else {
        //         let $stockSelect = $('#id_stock');
        //         $stockSelect.empty(); // Clear existing options
        //         $stockSelect.append('<option value="">-- Select Product Name --</option>'); // Add default option

        //         // Re-initialize Chosen after clearing options
        //         $stockSelect.trigger('chosen:updated');
        //     }
        // });

        $('.idObjectiveSelect').change(function() {
            let id_objectives = [];
            $('.idObjectiveSelect:checked').each(function() {
                id_objectives.push($(this).val());
            });

            let $stockSelect = $('#id_stock');
            $stockSelect.empty(); // Clear existing options
            $stockSelect.append('<option value="">-- Select Product Name --</option>'); // Add default option

            if (id_objectives.length > 0) {
                console.log(id_objectives);
                $.ajax({
                    url: '<?php echo site_url('Consumables_stock_take/getStockByObjective'); ?>',
                    type: 'POST',
                    data: { id_objectives: id_objectives }, // Ensure parameter name is correct
                    dataType: 'json',
                    success: function(response) {
                        // Add new options based on response
                        $.each(response, function(index, item) {
                            $stockSelect.append('<option value="' + item.id_stock + '">' + item.product_name + '</option>');
                        });

                        // Re-initialize Chosen after updating options
                        $stockSelect.trigger('chosen:updated');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX error:', textStatus, errorThrown);
                    }
                });
            } else {
                // Re-initialize Chosen after clearing options
                $stockSelect.trigger('chosen:updated');
            }
        });


        $('.stockSelect').change(function() {
            let idStock = $(this).val();
            if (idStock) {
                $.ajax({
                    url: '<?php echo site_url('Consumables_stock_take/getStockDetails'); ?>',
                    type: 'POST',
                    data: { idStock: idStock }, 
                    dataType: 'json',
                    success: function(response) {
             
                        $('#unit_measure_lab').val(response.unit || '');
                        $('#unit_of_measure').val(response.unit_of_measure || '');
                        $('#unit_of_measure1').val(response.unit_of_measure || '');
                        $('#quantity_per_unit').val(response.quantity_per_unit || '');
                        calculateTotalQuantity(); 
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Menangani error jika terjadi kesalahan dalam request
                        console.error('AJAX error:', textStatus, errorThrown);
                        $('#unit_measure_lab').val('');
                        $('#unit_of_measure').val('');
                        $('#unit_of_measure1').val('');
                        $('#quantity_per_unit').val('');
                    }
                });
            } else {
                $('#unit_measure_lab').val('');
                $('#unit_of_measure').val('');
                $('#unit_of_measure1').val('');
                $('#quantity_per_unit').val('');
            }
        });

        
        $('.clockpicker').clockpicker({
        placement: 'bottom', // clock popover placement
        align: 'left',       // popover arrow align
        donetext: 'Done',     // done button text
        autoclose: true,    // auto close when minute is selected
        vibrate: true        // vibrate the device when dragging clock hand
        });                

        $('.val1tip').tooltipster({
            animation: 'swing',
            delay: 1,
            theme: 'tooltipster-default',
            // touchDevices: false,
            // trigger: 'hover',
            autoClose: true,
            position: 'bottom',
            // content: $('<span><i class="fa fa-exclamation-triangle"></i> <strong> This text is in bold case !</strong></span>')
            // content: $('<span><img src="../assets/img/ttd.jpg" /> <strong>This text is in bold case !</strong></span>')
            // content: 'Test tip'
        });

        // Panggil fungsi calculateTotalQuantity setiap kali nilai input berubah
        $('#closed_container, #quantity_per_unit, #loose_items').on('input', function() {
            calculateTotalQuantity();
        });

        $('#quantity_per_unit').on('change', function() {
            calculateTotalQuantity();
        });

        // Fungsi untuk menghitung total quantity
        function calculateTotalQuantity() {
            let closedContainer = parseFloat($('#closed_container').val()) || 0;
            let quantityPerUnit = parseFloat($('#quantity_per_unit').val()) || 0;
            let looseItems = parseFloat($('#loose_items').val()) || 0;
            let totalQuantity = (closedContainer * quantityPerUnit) + looseItems;
            $('#total_quantity').val(totalQuantity);
        }

        // Inisialisasi clockpicker
        $('.clockpicker').clockpicker({
            autoclose: true
        });

        $("#compose-modal").on('hide.bs.modal', function(){
            $('.val1tip').tooltipster('hide');   
            // $('#barcode_sample').val('');     
        });

        $('#compose-modal').on('hide.bs.modal', function () {
            // Bersihkan form
            $('#formSample').find('input, textarea').val('');
            $('#formSample').find('input[type=checkbox], input[type=radio]').prop('checked', false);
            // Bersihkan nilai yang dipilih dalam select
            $('#formSample select').val('').trigger('change');
            location.reload();
        });
        
        var base_url = location.hostname;
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
        {
            return {
                "iStart": oSettings._iDisplayStart,
                "iEnd": oSettings.fnDisplayEnd(),
                "iLength": oSettings._iDisplayLength,
                "iTotal": oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
        };


        table = $("#mytable").DataTable({
            oLanguage: {
                sProcessing: "loading..."
            },
            processing: true,
            serverSide: true,
            ajax: {"url": "consumables_stock_take/jsonInStock", "type": "POST"},
            columns: [
                {"data": "id_instock"},
                {"data": "objective"},
                {"data": "product_name"},
                {"data": "closed_container"},
                {"data": "unit_measure_lab"},
                {"data": "quantity_per_unit"},
                {"data": "unit_of_measure"},
                {"data": "loose_items"},
                {"data": "quantity_with_unit"},
                // {"data": "expired_date"},
                // {"data": "indonesia_comments"},
                // {"data": "melbourne_comments"},
                {"data": "date_collected"},
                {"data": "time_collected"},
                {"data": "comments"},
                {
                    "data": "action",
                    "orderable": false,
                    "className": "text-center"
                }
            ],
            // order: [[1, 'desc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index); // Menetapkan nomor urut ke kolom pertama
            },
            drawCallback: function(settings) {
                let api = this.api();
                let pageInfo = api.page.info();
                
                // Highlight baris yang baru saja ditambahkan atau diperbarui
                api.rows().every(function() {
                    let data = this.data();
                    let createdDate = new Date(data.date_created);
                    let updatedDate = new Date(data.date_updated);
                    let now = new Date();

                    // Highlight jika baru ditambahkan atau diperbarui dalam 10 detik terakhir
                    if (now - createdDate < 10 * 1000) {
                        $(this.node()).addClass('highlight');
                    } else if (now - updatedDate < 10 * 1000) {
                        $(this.node()).addClass('highlight-edit');
                    }
                });
                
                // Pastikan baris pertama di-highlight jika tabel tidak kosong
                // if (pageInfo.page === 0 && api.rows().count() > 0) {
                //     let firstRow = api.row(0).node();
                //     $(firstRow).addClass('highlight');
                // }
            }
        });

        // Event handler for click to table row
        $('#mytable tbody').on('click', 'tr', function() {
            let rowData = table.row(this).data();
            let rowId = rowData.id_instock;
            $(this).removeClass('highlight');
            $(this).removeClass('highlight-edit');
        });


        $('#addtombol').click(function() {
             // Initially disable the "Number of Closed Containers" field
            // $('#closed_container').prop('disabled', true);

            // Enable the field when a product is selected
            $('#id_stock').change(function() {
                let selectedProduct = $(this).val(); // Get the selected product value
                if (selectedProduct) {
                    $('#closed_container').attr('readonly', false); // Enable field
                } else {
                    $('#closed_container').attr('readonly', true);// Disable field
                }
            });

            $('.val1tip').tooltipster('hide');   
            $('#mode').val('insert');
            $('#modal-title').html('<i class="fa fa-wpforms"></i> Consumables - Insert Stock Take <span id="my-another-cool-loader"></span>');
            $('#idx').hide();
            // $('#id').val('');
            $('#id_stock').val('');
            $('#id_objective').val('');
            // $('#id_objective').prop('readonly', true);
            // $('#id_stock').prop('readonly', true);
            $('#id_objective').attr('readonly', false).attr('onmousedown', 'return true;');
            $('#closed_container').val('');
            $('#closed_container').attr('readonly', true);
            $('#unit_measure_lab').val('');
            $('#unit_measure_lab').attr('readonly', true);
            $('#quantity_per_unit').val('');
            $('#quantity_per_unit').attr('readonly', true);
            $('#loose_items').val('');
            $('#total_quantity').val('');
            $('#total_quantity').attr('readonly', true);
            $('#unit_of_measure').val('');
            $('#unit_of_measure').attr('readonly', true);
            $('#unit_of_measure1').val('');
            $('#unit_of_measure1').attr('readonly', true);
            $('#comments').val('');
            // $('#indonesia_comments').val('');
            // $('#melbourne_comments').val('');
            $('#compose-modal').modal('show');
        });

        $('#mytable').on('click', '.btn_edit', function(){
            let tr = $(this).parent().parent();
            let data = table.row(tr).data();
            console.log(data);
            $('#mode').val('edit');
            $('#modal-title').html('<i class="fa fa-pencil-square"></i> Consumables - Update Stock Take <span id="my-another-cool-loader"></span>');
            $('#id_instock').attr('readonly', true);
            $('#idx').hide();
            $('#id_instock').val(data.id_instock);
            	
       // Reset all checkboxes before setting them
    $('.idObjectiveSelect').prop('checked', false).prop('disabled', true);

            // Pastikan data.id_objective valid dan adalah array
            if (Array.isArray(data.id_objective)) {
                data.id_objective.forEach(function(obj) {
                    // Cek dan centang checkbox berdasarkan value
                    $('.idObjectiveSelect[value="' + obj + '"]').prop('checked', true);
                });
            } else if (data.id_objective && typeof data.id_objective === 'string') {
                // Jika data.id_objective adalah string, ubah menjadi array
                data.id_objective.split(',').map(Number).forEach(function(obj) {
                    $('.idObjectiveSelect[value="' + obj + '"]').prop('checked', true);
                    $('.idObjectiveSelect1').val([obj]);
                });
            }

            // Trigger change event jika diperlukan
            $('.idObjectiveSelect').trigger('change');





            // Tunggu hingga AJAX selesai dan dropdown diisi
            let interval = setInterval(function() {
                // Cek apakah lebih dari satu opsi tersedia (default + data baru)
                if ($('#id_stock').find('option').length > 1) {
                    // Set nilai dropdown produk berdasarkan id_stock
                    $('#id_stock').val(data.id_stock).prop('disabled', true); // Set the value of product dropdown
                    $('#id_stock').trigger('chosen:updated'); // Update Chosen
                    $('#id_stock1').val(data.id_stock); // Set the value of product dropdown
                    $('#id_stock1').trigger('chosen:updated'); // Update Chosen
                    clearInterval(interval); // Hentikan interval
                }
            }, 100); // Cek setiap 100ms hingga dropdown terisi

            $('#id_objective').attr('readonly', true).attr('onmousedown', 'return false;');
            $('#closed_container').val(data.closed_container);
            $('#closed_container').attr('readonly', false);
            $('#unit_measure_lab').val(data.unit_measure_lab);
            $('#unit_measure_lab').attr('readonly', true);
            $('#quantity_per_unit').val(data.quantity_per_unit);
            $('#quantity_per_unit').attr('readonly', true);
            $('#loose_items').val(data.loose_items);
            $('#total_quantity').val(data.total_quantity);
            $('#total_quantity').attr('readonly', true);
            $('#unit_of_measure').val(data.unit_of_measure);
            $('#unit_of_measure').attr('readonly', true);
            $('#unit_of_measure1').val(data.unit_of_measure);
            $('#unit_of_measure1').attr('readonly', true);
            $('#expired_date').val(data.expired_date).trigger('change');
            $('#comments').val(data.comments);
            // $('#indonesia_comments').val(data.indonesia_comments);
            // $('#melbourne_comments').val(data.melbourne_comments);
            $('#date_collected').val(data.date_collected).trigger('change');
            $('#time_collected').val(data.time_collected).trigger('change');
            $('#compose-modal').modal('show');
        }); 

        $('#mytable tbody').on('click', 'tr', function () {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            } else {
                table.$('tr.active').removeClass('active');
                $(this).addClass('active');
            }
        })  
    });

</script>