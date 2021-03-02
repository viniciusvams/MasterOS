<div class="row-fluid" style="margin-top: 0">
    <div class="span4">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="fas fa-users"></i>
                </span>
                <h5>Relatórios Rápidos</h5>
            </div>
            <div class="widget_box_vizualizar2" style="background-color:#f5f5f5">
                <ul class="site-stats">
                    <li><a href="<?php echo base_url() ?>index.php/relatorios/clientesRapid" target="_blank"><i
                                    class="fas fa-users"></i> <small>Todos os Clientes - pdf</small></a></li>
                    <li><a href="<?php echo base_url() ?>index.php/relatorios/clientesRapid?format=xls" target="_blank"><i
                                    class="fas fa-users"></i> <small>Todos os Clientes - xls</small></a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="span8">
      <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="fas fa-users"></i>
                </span>
                <h5>Relatórios Customizáveis</h5>
            </div>
          
          <div class="span12 widget_box_vizualizar5" style="margin-left: 0">
		<form target="_blank" action="<?php echo base_url() ?>index.php/relatorios/clientesCustom" method="get">
<div class="span12 well_i" style="margin-left: 0">
	<div class="span4">
		<label for="">Cadastrado de:</label>
		<input type="date" name="dataInicial" class="span12"/>
	</div>
	<div class="span4">
		<label for="">até:</label>
		<input type="date" name="dataFinal" class="span12"/>
	</div>
	<div class="span4">
		<label for=""> &nbsp </label>
		<button class="btn btn-inverse span12"><i class="fas fa-print"></i> Imprimir</button>
    </div>
</div>
<div class="span12 well_i" style="margin-left: 0">
	<div class="span12">
		<label for="">Tipo de cliente:</label>
		<select name="tipocliente" class="span12">
		<option value="0">Cliente</option>
		<option value="1">Fornecedor</option>
		</select>
	</div>
</div>
</form>
</div>
</div>
</div>
</div>
