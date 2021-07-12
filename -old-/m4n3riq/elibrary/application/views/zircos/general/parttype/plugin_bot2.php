<script src="<?=URL_MASTER;?>plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?=URL_MASTER;?>plugins/datatables/dataTables.bootstrap.js"></script>

        <script src="<?=URL_MASTER;?>plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="<?=URL_MASTER;?>plugins/datatables/buttons.bootstrap.min.js"></script>
        <script src="<?=URL_MASTER;?>plugins/datatables/jszip.min.js"></script>
        <script src="<?=URL_MASTER;?>plugins/datatables/pdfmake.min.js"></script>
        <script src="<?=URL_MASTER;?>plugins/datatables/vfs_fonts.js"></script>
        <script src="<?=URL_MASTER;?>plugins/datatables/buttons.html5.min.js"></script>
        <script src="<?=URL_MASTER;?>plugins/datatables/buttons.print.min.js"></script>
        <script src="<?=URL_MASTER;?>plugins/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="<?=URL_MASTER;?>plugins/datatables/dataTables.keyTable.min.js"></script>
        <script src="<?=URL_MASTER;?>plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="<?=URL_MASTER;?>plugins/datatables/responsive.bootstrap.min.js"></script>
        <script src="<?=URL_MASTER;?>plugins/datatables/dataTables.scroller.min.js"></script>
        <script src="<?=URL_MASTER;?>plugins/datatables/dataTables.colVis.js"></script>
        <script src="<?=URL_MASTER;?>plugins/datatables/dataTables.fixedColumns.min.js"></script>

        <!-- init -->
        <script src="<?=URL_MASTER;?>assets/pages/jquery.datatables.init.js"></script>
		
		<script type="text/javascript">
            $(document).ready(function () {
                $('#datatable').dataTable();
                $('#datatable-keytable').DataTable({keys: true});
                $('#datatable-responsive').DataTable();
                $('#datatable-colvid').DataTable({
                    "dom": 'C<"clear">lfrtip',
                    "colVis": {
                        "buttonText": "Change columns"
                    }
                });
                $('#datatable-scroller').DataTable({
                    ajax: "../plugins/datatables/json/scroller-demo.json",
                    deferRender: true,
                    scrollY: 380,
                    scrollCollapse: true,
                    scroller: true
                });
                var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});
                var table = $('#datatable-fixed-col').DataTable({
                    scrollY: "300px",
                    scrollX: true,
                    scrollCollapse: true,
                    paging: false,
                    fixedColumns: {
                        leftColumns: 1,
                        rightColumns: 1
                    }
                });
            });
            TableManageButtons.init();

        </script>