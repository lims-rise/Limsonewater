<div class="content-wrapper">
    <section class="content">


        <!-- <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">

                    <div class="box-header">
                        <h3 class="box-title">GENERAL SETTING</h3>
                    </div>

                    <div class="box-body">
                        <?php //echo form_open('kelolamenu/simpan_setting')?>
                        <table class="table table-bordered">
                            <tr><td width="250">Show Menu Base on Level</td><td>
                                    
                                    <?php
                                    // echo form_dropdown('tampil_menu',array('ya'=>'Yes','tidak'=>'No'),$setting['value'],array('class'=>'form-control'));
                                    ?>
                                </td></tr>
                            <tr><td></td><td><button type="submit" class="btn btn-danger">Save change?</button></td></tr>
                        </table>
                    </form>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">

                    <div class="box-header">
                        <h3 class="box-title">MENU SETTINGS</h3>
                    </div>

                    <div class="box-body">
                        <div style="padding-bottom: 10px;">
                            <?php echo anchor(site_url('kelolamenu/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> New Menu', 'class="btn btn-primary"'); ?>
                            <?php //echo anchor(site_url('kelolamenu/excel'), '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Ms Excel', 'class="btn btn-success btn-sm"'); ?>
                            <?php //echo anchor(site_url('kelolamenu/word'), '<i class="fa fa-file-word-o" aria-hidden="true"></i> Export Ms Word', 'class="btn btn-primary btn-sm"'); ?></div>
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead>
                                <tr>
                                    <th width="30px">No</th>
                                    <th>Title</th>
                                    <th>Url</th>
                                    <th>Icon</th>
                                    <th>Is Main Menu</th>
                                    <th>Is Aktif</th>
                                    <th width="100px">Action</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL CONFIRMATION DELETE -->
        <div class="modal fade" id="confirm-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #dd4b39; color: white;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white;">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-trash"></i> Menu Setting | Delete <span id="my-another-cool-loader"></span></h4>
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

    </section>
</div>
<script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {

                function showConfirmation(url) {
                    deleteUrl = url; // Set the URL to the variable
                    $('#confirm-modal').modal('show');
                }

                // Handle the delete button click
                $(document).on('click', '.btn_delete', function() {
                    let id = $(this).data('id');
                    let url = '<?php echo site_url('Kelolamenu/delete'); ?>/' + id;
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

        var t = $("#mytable").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#mytable_filter input')
                .off('.DT')
                .on('keyup.DT', function(e) {
                    if (e.keyCode == 13) {
                        api.search(this.value).draw();
                    }
                });
            },
            oLanguage: {
                sProcessing: "loading..."
            },
            processing: true,
            serverSide: true,
            ajax: {"url": "kelolamenu/json", "type": "POST"},
            columns: [
                {
                    "data": "id_menu"
                    // "orderable": false
                },
                {"data": "title"},
                {"data": "url"},
                {"data": "icon"},
                {"data": "is_main_menu"},
                {"data": "is_aktif"},
                {
                    "data" : "action",
                    "orderable": false,
                    "className" : "text-center"
                }
            ],
            order: [[0, 'desc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });
    });
</script>