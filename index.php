
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Script JQuery Toggle -->
<script type='text/javascript'>
    $(document).ready(function(){
        $(".mostrar").hide();
        $(".ocultar").click(function(){
            $(this).next(".mostrar ").slideToggle(600);
        });
    });
</script>
<!-- Fim Script JQuery Toggle -->
<style>
#customers, #customers2, #customers3 {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
  text-align: center; 
  vertical-align: middle;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 6px;
 
}

#customers, #customers2, #customers3 tr:nth-child(even){background-color: #f2f2f2;}

#customers, #customers3 tr:hover {background-color: #ddd;}

#customers th {
  border-radius: 3px;
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #3b8dbd;
  color: white;
}
#customers2 th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #3b8dbd;
  color: white;
}
#customers2 td, #customers2 th {

  border: 1px solid white;
  padding: 6px;
}
#customers3 td, #customers3 th {
  border: 1px solid #FFF;
  padding: 6px;
}
#customers3 th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #666;
  color: white;
}


</style>
</head>
<body>
<?php
$jsonEditais = file_get_contents("#");
$dataEditais = json_decode($jsonEditais);

$jsonProjetos = file_get_contents("#");
$dataProjetos = json_decode($jsonProjetos);

$jsonBolsistas = file_get_contents("#");
$dataBolsistas = json_decode($jsonBolsistas);
$Ano = [];

foreach ($dataEditais as $key => $valueAno) {
    $Ano[$key] = $valueAno->AnoEdital;

}
$AnoOK = array_values(array_unique($Ano, SORT_REGULAR));

foreach ($AnoOK as $key => $value) {
    echo "<p><table id='customers' class='ocultar'>";
    echo "<tr>";
    echo "<td style='width: 1%; background-color: #F8F8FF;'><img src='http://proppg.unilab.edu.br/forms/paineis/prestacaoContas/imgs/caixa.png' alt='Minha Figura' width='50%'></td>";
    echo "<th style='width: 15%;'>Ano do Edital:</b> {$value}</th>";
    echo "</tr>";
    echo "</table>";
    echo "<div class='mostrar'>";
    foreach ($dataEditais as $key => $valueEdital) {
        if ($valueEdital->AnoEdital == $value) {
            echo "<p><table id='customers2' class='ocultar'>";
            echo "<tr>";
            echo "<td style='width: 3%; background-color: #F8F8FF;  border: 1px solid #ddd;'><img src='https://proppg.unilab.edu.br/forms/paineis/prestacaoContas/imgs/arquivo.png' alt='Minha Figura' width='50%'></td>";
            echo "<th style='width: 15%;'>{$valueEdital->AnoEdital} - {$valueEdital->Descrição}</th>";
            echo "<th style='width: 15%;'><p>Início/Fim Exec.<br> ",date('d/m/Y', strtotime($valueEdital->DataInicioExe)),"</p><p>",date('d/m/Y', strtotime($valueEdital->DataFimExe)),"</p></th>";
            echo "</tr>";
            echo "</table>";
            echo "<div class='mostrar'>";
            foreach ($dataProjetos as $key => $valueProjeto) {
                if($valueProjeto->idEdital == $valueEdital->idEdital){
                    
                    echo "<table id='customers3' class='ocultar'>";
                    echo "<tr>";
                    echo "<td style='width: 4%; background-color: #F8F8FF;  border: 1px solid #ddd;'><img src='https://proppg.unilab.edu.br/forms/paineis/prestacaoContas/imgs/projeto.png' alt='Minha Figura' width='50%'></td>";
                    echo "<th colspan='7'><center>PROJETO:",mb_strtoupper($valueProjeto->titulo, 'UTF-8'),"</center></th>";
                    
                    echo "</tr>";
                    echo "<tr>";
                    echo "</table><table id='customers3' class='mostrar'>";
                    echo "<th></th><th>Discentes do projeto:</th><th>Orientador</th><th>Condição</th><th>Instituto</th><th>Situação da Bolsa</th><th>Fomento</th><th>Valor da bolsa</th><th>Data de Inicio/Fim da cota</th><th>Tot. meses ativo</th><th>Valor total</th>";
                    echo "</tr>";
                    $encerrado = 0;
                    $bolsista = 0;
                    $Voluntarios = 0;
                    $totoBolsistaEM = 0;
                    $totoBolsistaES = 0;
                    $bolsaES = 0;
                    $bolsaEM = 0;
                    foreach($dataBolsistas as $key => $valueBolsistas){
                        
                        if($valueBolsistas->idProjeto == $valueProjeto->idProjeto){
                            $dat1 = date($valueBolsistas->dataInicioCota);
                            $dat2 = date($valueBolsistas->dataFinalCota);
                            $data1 = explode("/", $dat1);
                            $list1 = list($dia, $mes, $ano) = $data1;
                            $data2 = explode("/", $dat2);
                            $list2 = list($dia, $mes, $ano) = $data2;



                            if($valueBolsistas->condicao == 'Voluntário'){
                                $Voluntarios++;
                            }
                            if($valueBolsistas->condicao == 'Bolsista'){
                                $bolsista++;
                            }
                            if($valueBolsistas->Situacao == 'Encerrada'){
                                $encerrado++;
                            }
                            if($valueBolsistas->Instituto == 'Ensino Médio' && $valueBolsistas->condicao != 'Voluntário'){
                                $totoBolsistaEM++;
                            }
                            if($valueBolsistas->Instituto != 'Ensino Médio' && $valueBolsistas->condicao != 'Voluntário'){
                                $totoBolsistaES++;
                            }
                            if($valueBolsistas->condicao == 'Bolsista'){
                                if($valueBolsistas->Instituto == 'Ensino Médio' && $valueBolsistas->condicao == 'Bolsista'){
                                    $bolsaES = ((($list2[2] - $list1[2])*12) + ($list2[1] - $list1[1]))*100;
                                }
                                if($valueBolsistas->Instituto != 'Ensino Médio' && $valueBolsistas->condicao == 'Bolsista'){
                                    $bolsaEM = ((($list2[2] - $list1[2])*12) + ($list2[1] - $list1[1]))*400;
                                }if($valueBolsistas->condicao != 'Bolsista'){
                                    $bolsaEM = 0;
                                    $bolsaES = 0;
                                }
                            }
                            
                            echo "<tr>";
                            echo "<td style='width: 4%; background-color: #F8F8FF;  border: 1px solid #ddd;'><img src='https://proppg.unilab.edu.br/forms/paineis/prestacaoContas/imgs/user.png' alt='Minha Figura' width='20%'></td>";
                            echo "<td style='border: 1px solid #DCDCDC;'>",$valueBolsistas->bolsista,"</td>";
                            echo "<td style='border: 1px solid #DCDCDC;'>",$valueBolsistas->orientador,"</td>" ;
                            echo "<td style='border: 1px solid #DCDCDC;'>",$valueBolsistas->condicao == 'Bolsista'? "<span style='color:#30b570;'>{$valueBolsistas->condicao}</span>": "{$valueBolsistas->condicao}","</td>";
                            echo "<td style='border: 1px solid #DCDCDC;'>",$valueBolsistas->Instituto? $valueBolsistas->Instituto : "---" ,"</td>";
                            echo "<td style='border: 1px solid #DCDCDC;'>",$valueBolsistas->Situacao == 'Encerrada'? "<span style='color:#ff5062;'>{$valueBolsistas->Situacao}</span>": $valueBolsistas->Situacao ,"</td>";
                            echo "<td style='border: 1px solid #DCDCDC;'>",$valueBolsistas->fomento,"</td>";
                            echo "<td style='border: 1px solid #DCDCDC;'>",$valueBolsistas->condicao == 'Bolsista'? $valueBolsistas->Instituto != 'Ensino Médio'? "400,00" : "100,00" : "---" ,"</td>";
                            echo "<td style='border: 1px solid #DCDCDC;'>",$valueBolsistas->dataInicioCota, "---",$valueBolsistas->dataFinalCota,"</td>";
                            echo "<td style='border: 1px solid #DCDCDC;'>",((($list2[2] - $list1[2])*12) + ($list2[1] - $list1[1])),"</td>";
                            echo "<td style='border: 1px solid #DCDCDC;'>",$valueBolsistas->condicao == 'Bolsista'?  $bolsaES? "R$".$bolsaES.",00" : "R$".$bolsaEM.",00" : "R$0,00" ,"</td>";
                            echo "</tr>";

                        }
                    }
                    echo "<td style='background-color: #fff; color: #000; border: 1px solid #DCDCDC;'>Total de Bolsas encerradas: {$encerrado}
                            </td><td style='background-color: #fff; color: #000; border: 1px solid #DCDCDC;'>Total de bolsistas: {$bolsista}</td>
                            </td><td style='background-color: #fff; color: #000; border: 1px solid #DCDCDC;'>Total de Voluntários: {$Voluntarios}</td>
                            </td>";

                    echo "</table>" ;
                }
            }
            echo "</div></p>" ;
        }

    }
    echo "</div>";
}


?>
</body>
</html>