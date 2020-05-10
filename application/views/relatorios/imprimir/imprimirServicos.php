<!DOCTYPE html>
<html>
    
<head>
    <title>MAPOS</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fullcalendar.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/blue.css" class="skin-color" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body style="background-color: transparent">
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">

                <div class="widget-box">
                    <div class="widget-title">
                        <h4 style="text-align: center">Serviços</h4>
                    </div>
                    <div class="widget-content nopadding">

                        <table width="1000" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="300" style="font-size: 15px">Nome</th>
                                    <th width="600" style="font-size: 15px">Descrição</th>
                                    <th width="100" style="font-size: 15px">Preço</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($servicos as $s) {
                                        echo '<tr>';
                                        echo '<td>' . $s->nome . '</td>';
                                        echo '<td>' . $s->descricao . '</td>';
                                        echo '<td>' . $s->preco . '</td>';
                                        echo '</tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <h5 style="text-align: right; font-size: 0.8em; padding: 5px;">Data do Relatório: <?php echo date('d/m/Y'); ?>
                </h5>
            </div>
        </div>
    </div>
</body>

</html>
