<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/trumbowyg/ui/trumbowyg.css">
<script type="text/javascript" src="<?php echo base_url() ?>assets/trumbowyg/trumbowyg.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/trumbowyg/langs/pt_br.js"></script>
<link href="<?= base_url('assets/css/custom.css'); ?>" rel="stylesheet">
<?php $totalServico = 0; $totalProdutos = 0; ?>


<div class="row-fluid" style="margin-top:0">
<div class="widget_content_3" align="center" style="padding:5px; margin-bottom:5px;">

<?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eVenda')) { ?>
<a style="margin-right:5px; margin-bottom:2px; margin-top:2px; max-width: 160px" title="Nova Venda" class="button_mini btn btn-mini btn-success tip-top" target="new" href="<?php echo base_url(); ?>index.php/vendas/adicionar">
<span class="button_icon"><i class='fas fa-plus-circle'></i></span><span class="button_text">Adicionar</span></a>
<?php } ?>

<?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eVenda')) { ?>
<a style="margin-right:5px; margin-bottom:2px; margin-top:2px; max-width: 160px" title="Editar Venda" class="button_mini btn btn-mini btn-info tip-top" href="<?php echo site_url() ?>/vendas/editar/<?php echo $result->idVendas; ?>">
<span class="button_icon"><i class='fas fa-edit'></i></span><span class="button_text">Editar Venda</span></a>
<?php } ?>

<a style="margin-right:5px; margin-bottom:2px; margin-top:2px; max-width: 160px" title="Imprimir" class="button_mini btn btn-mini btn-inverse tip-top" target="new" href="<?php echo site_url() ?>/vendas/imprimir/<?php echo $result->idVendas; ?>">
<span class="button_icon"><i class='fas fa-print'></i></span><span class="button_text">Imprimir A4</span></a>

<a style="margin-right:5px; margin-bottom:2px; margin-top:2px; max-width: 160px" title="Imprimir Termica" class="button_mini btn btn-mini btn-inverse tip-top" target="new" href="<?php echo site_url() ?>/vendas/imprimirTermica/<?php echo $result->idVendas; ?>">
<span class="button_icon"><i class='fas fa-print'></i></span><span class="button_text">Imprimir Termica</span></a>

<a style="margin-right:5px; margin-bottom:2px; margin-top:2px; max-width: 160px" title="Gerar Pagamento" class="button_mini btn btn-mini btn-success tip-top" href="#modal-gerar-pagamento" id="btn-forma-pagamento" role="button" data-toggle="modal"><span class="button_icon"><i class="fas fa-cash-register"></i></span><span class="button_text">Gerar Pagamento</span></a>
<?= $modalGerarPagamento ?>

</div>
</div>

<div class="row-fluid" style="margin-top:0">
<div class="widget_content_3">
<div class="widget_title_3">
<h5>Dados da Venda</h5>
</div>
<div class="well_0">


<div class="widget_content_printer2">
<table width="100%" class="table_w">
<?php if ($emitente == null) { ?>
<tr>
<td colspan="3" class="alert">Você precisa configurar os dados do emitente. >>><a href="<?php echo base_url(); ?>index.php/masteros/emitente">Configurar</a><<<</td>
</tr>
<?php } ?>
<tr>
<td style="text-align: center; width: 25%">
<img src=" <?php echo $emitente[0]->url_logo; ?> " style="max-height: 100px">
</td>
<td>
<b><?php echo $emitente[0]->nome; ?></b></br>
<i class="fas fa-fingerprint" style="margin:0px 1px"></i>
<?php echo $emitente[0]->cnpj; ?></br>
<i class="fas fa-map-marker-alt" style="margin:0px 3px"></i>
<?php echo $emitente[0]->rua . ', ' . $emitente[0]->numero . ' - ' . $emitente[0]->bairro; ?></br>
<i class="fas fa-map-marker-alt" style="margin:0px 3px"></i> <?php echo $emitente[0]->cidade . ' - ' . $emitente[0]->uf; ?></br>
<i class="fas fa-map-marker-alt" style="margin:0px 3px"></i> <?= 'CEP: ' . $emitente[0]->cep; ?><br>
<i class="fas fa-envelope" style="margin:0px 1px"></i>  <?php echo $emitente[0]->email; ?></br>
<i class="fas fa-phone-alt" style="margin:0px 1px"></i>  <?php echo $emitente[0]->telefone; ?>
</td>
<td style="text-align: center; font-size:12px">
<span><b>#Venda Nº:</b> <?php echo $result->idVendas ?></span><br>
<span><b>Data Venda:</b> <?php echo date('d/m/Y', strtotime($result->dataVenda)); ?></span><br>
<span><b>Emissão:</b> <?php echo date('d/m/Y'); ?></span>
</td>
</tr>
</table>
</div>

<div class="widget_content_printer2">
<table width="100%" class="table_w">
<tr>
<td>
<b>Cliente</b><br>
<i class="fas fa-user-check"></i> <?php echo $result->nomeCliente ?><br>
<i class="fas fa-fingerprint" style="margin:0px 1px"></i>
<?php echo $result->documento ?><br>
<i class="fas fa-map-marker-alt" style="margin:0px 3px"></i>
<?php echo $result->rua ?>,
<?php echo $result->numero ?>,
<?php echo $result->bairro ?><br>
<i class="fas fa-map-marker-alt" style="margin:0px 3px"></i> <?php echo $result->cidade ?> -
<?php echo $result->estado ?><br>
<i class="fas fa-map-marker-alt" style="margin:0px 3px"></i> CEP: <?php echo $result->cep ?><br>
<i class="fas fa-phone-alt" style="margin:0px 1px"></i>  <?php echo $result->telefone ?>
</td>
<td>
<span style="font-size: 15px"><b>Vendedor</b></span><br>
<span style="font-size: 12px"><i class="fas fa-user-check"></i> <?php echo $result->nome ?></span><br>
<span style="font-size: 12px"><i class="fas fa-phone-alt" style="margin:5px 1px"></i> <?php echo $result->telefone_usuario ?></span><br>
<span style="font-size: 12px"><i class="fas fa-envelope" style="margin:5px 1px"></i> <?php echo $result->email_usuario ?></span>
</td>
</tr>
</table>
</div>

<div class="widget_content_printer2">
<table width="100%" class="table_w" id="tblProdutos">
<thead>
<tr>
<th width="8%">Cod. SKU</th>
<th width="10%">Cod. Barras</th>
<th>Produto</th>
<th width="8%">Quantidade</th>
<th width="10%">Preço</th>
<th width="10%">Sub-total</th>
</tr>
</thead>
<tbody>
<?php
$total = 0;
foreach ($produtos as $p) {
	$preco = $p->preco ?: $p->precoVenda;
	$total = $total + $p->subTotal;
echo '<tr>';
echo '<td><div align="center">' . $p->idProdutos . '</div></td>';
echo '<td><div align="center">' . $p->codDeBarra . '</div></td>';
echo '<td>' . $p->descricao . '</td>';
echo '<td><div align="center">' . $p->quantidade . '</div></td>';
echo '<td><div align="center">R$: ' . $preco . '</div></td>';
echo '<td><div align="center">R$: ' . number_format($p->subTotal, 2, ',', '.') . '</div></td>';
echo '</tr>';
} ?>
<tr>
<td colspan="5" style="text-align: right"><strong>Total:</strong>
</td>
<td>
<div align="center"><strong>R$:
<?php echo number_format($total, 2, ',', '.'); ?></strong>
<input type="hidden" id="total-venda" value="<?php echo number_format($total, 2); ?>">
</div>
</td>
</tr>
<?php if ($result->valor_desconto != 0 && $result->desconto != 0) { ?>
<tr>
<td colspan="5" style="text-align: right"><strong>Desconto:</strong></td>
<td>
<div align="center">
<strong>R$: <?php echo number_format($result->desconto, 2, ',', '.'); ?></strong></div>
</td>
</tr>
<tr>
<td colspan="5" style="text-align: right"><strong>Total Com Desconto:</strong></td>
<td>
<div align="center"><strong>R$: <?php echo number_format($result->valor_desconto, 2, ',', '.'); ?></strong>
</div><input type="hidden" id="total-desconto" value="<?php echo number_format($result->valor_desconto, 2); ?>">
</td>
</tr>
<?php } ?>
</tbody>
</table>
</div>

















</div>
</div>
</div>
