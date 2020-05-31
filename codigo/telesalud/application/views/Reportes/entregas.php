<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Nivel de Pedidos Entregados a Tiempo
                <div class="pull-right">
                    <label for="mes">Mes</label>
                    <select id="mes" onchange="cambiarVista()">
                        <option value="">Seleccione</option>
                        <?php
                        foreach ($meses as $mes) {
                            $selectedM = ($mes->id == $mesActual) ? 'selected' : '';
                            echo "<option value='$mes->id' $selectedM>$mes->nombre</option>";
                        }
                        ?>
                    </select>
                    <label for="anio">Año</label>
                    <select id="anio" onchange="cambiarVista()">
                        <option value="">Seleccione</option>
                        <?php
                        $initYear = 2018;
                        $curYear  = $anioActual;
                        do {
                            $selectedY = ($initYear == $curYear) ? 'selected' : '';
                            echo "<option value='$initYear' $selectedY>$initYear</option>";
                            $initYear++;
                        } while ($initYear <= $curYear);
                        ?>
                    </select>
                </div>
            </header>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 pull-right">
                        <a href="<?= base_url('Reportes/entregasPDF/' . $mesActual . '/' . $anioActual) ?>"
                           class="btn btn-warning">Exportar</a>
                    </div>
                    <div class="col-md-12">
                        <div class="row text-center">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <table style="" class="table table-striped table-hover table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Proceso Observador</th>
                                        <td>Gestion de Pedidos</td>
                                    </tr>
                                    <tr>
                                        <th>Indicador</th>
                                        <td>Nivel de Pedidos Entregados a Tiempo</td>
                                    </tr>
                                    <tr>
                                        <th>Formula</th>
                                        <td>
                                            <b><u>Pedidos Entregados a Tiempo</u> * 100</b><br/>
                                            <b>
                                                <center>Total Pedidos Entregados</center>
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Periodicidad</th>
                                        <td>Diario</td>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <br/>
                                <table id="calidad" class="table table-striped table-hover table-bordered"
                                       style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Fecha</th>
                                        <th>Pedidos Entregados<br> a Tiempo</th>
                                        <th>Total Pedidos<br> Entregados</th>
                                        <th>Nivel de Pedidos <br>Entregados a Tiempo</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i       = 1;
                                    $atiempo = 0;
                                    $totales = 0;
                                    foreach ($indicadores as $indicador) {
                                        $procesado = 0;
                                        if ($indicador->total > 0) {
                                            $atiempo   += $indicador->cumple;
                                            $totales   += $indicador->total;
                                            $procesado = round(($indicador->cumple / $indicador->total) * 100, 2);
                                        }
                                        echo "<tr>";
                                        echo "<td>" . $i . "</td>";
                                        echo "<td>" . $indicador->fecha_envio . "</td>";
                                        echo "<td>" . $indicador->cumple . "</td>";
                                        echo "<td>" . $indicador->total . "</td>";
                                        echo "<td>" . $procesado . "</td>";
                                        echo "</tr>";
                                        $i++;
                                    }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                    <?php
                                    $totalIndicador = 0;
                                    if ($totales > 0) {
                                        $totalIndicador = round(($atiempo / $totales) * 100, '2');
                                    }
                                    echo "<th colspan='2' class='text-center'>Total</th>";
                                    echo "<th>$atiempo</th>";
                                    echo "<th>$totales</th>";
                                    echo "<th>" . $totalIndicador . "%</th>";
                                    ?>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<script>
    var oPendi;

    $(document).ready(function () {
        //loadTable();
    });

    function cambiarVista () {
        let mes = $('#mes').val();
        let anio = $('#anio').val();
        if (mes && anio) {
            location.href = base_url + 'Reportes/entregas/' + mes + '/' + anio;
        }
    }

    // function loadTable () {
    //     oPendi = $('#calidad').DataTable({
    //         responsive:      true,
    //         'order':         [[0, 'desc']],
    //         'aLengthMenu':   [[10, 50, -1], [10, 50, 'Todo']],
    //         'bLengthChange': false,
    //         'oLanguage':     {
    //             'sProcessing':     'Procesando...',
    //             'sLengthMenu':     'Mostrar _MENU_ registros',
    //             'sZeroRecords':    'No se encontraron resultados',
    //             'sEmptyTable':     'Ningún dato disponible en esta tabla',
    //             'sInfo':           'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
    //             'sInfoEmpty':      'Mostrando registros del 0 al 0 de un total de 0 registros',
    //             'sInfoFiltered':   '(filtrado de un total de _MAX_ registros)',
    //             'sInfoPostFix':    '',
    //             //'sSearch':         'Buscar',
    //             'sUrl':            '',
    //             'sInfoThousands':  ',',
    //             'sLoadingRecords': 'Cargando...',
    //             'oPaginate':       {
    //                 sFirst:    'Primero',
    //                 sLast:     'Último',
    //                 sNext:     'Siguiente',
    //                 sPrevious: 'Anterior'
    //             }
    //         }
    //     });
    //     $('#productos_filter').hide();
    // };
</script>
