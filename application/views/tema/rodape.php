<div class="row-fluid">
<div id="footer" class="span12 hide"> <a class="pecolor" href="https://github.com/RamonSilva20/masteros" target="_blank">
<?= date('Y'); ?> &copy; 2020 - 2022 &copy; Master-OS - Emanuel Victor - Versão: <?= $this->config->item('app_version'); ?></a></div>
</div>

<div id="footer" class="span12" style="color:#FFFFFF; ">
2020 - <?= date('Y'); ?> &copy; Master-OS - Emanuel Victor - Versão: <?= $this->config->item('app_version'); ?>
</div>
<!--end-Footer-part-->
<script src="<?= base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?= base_url(); ?>assets/js/matrix.js"></script>
</body>
<script type="text/javascript">
    $(document).ready(function() {
        var dataTableEnabled = '<?php echo $configuration['control_datatable']; ?>';
        if(dataTableEnabled == '1') {
            $('#tabela').dataTable( {
                "ordering": false,
                "language": {
                    "url": "<?= base_url(); ?>assets/js/dataTable_pt-br.json"
                }
            } );
        }
    } );
</script>
</html>
