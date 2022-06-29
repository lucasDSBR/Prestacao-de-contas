<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
<center><h3>Gráfico 2</h3></center>
<center><h5>Soma dos valores de bolsas em seus respectivos editais.</h5></center>
<center><h5>Obs: Os valores aqui informados foram obtidos por meio de uma soma de todas as bolsas dos alunos que se encontram com status `ativo` no projeto em que foi cadastrado.</h5></center>
<center><h5>Obs: Discentes de Ensino Superior.</h5></center>
<div style="width: 90%;">
<canvas id="myChart"></canvas>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
<?php
$jsonEditais = file_get_contents("#");
$dataEditais = json_decode($jsonEditais);
$jsonBolsistas = file_get_contents("#");
$dataBolsistas = json_decode($jsonBolsistas);
$jsonProjetos = file_get_contents("#");
$dataProjetos = json_decode($jsonProjetos);

$modelDados = [];
$editais = [];
$totBolsistasEditais = [];


//Bolsitas de Ensino Superior ativos
$bolsistasESAtivos = [];
$bolsistasESAtivosTOT = [];
$totIntESAtivos = [];
foreach ($dataBolsistas as $i => $valueBolsistas) {
    if (($valueBolsistas->Situacao == 'Vigente') && ($valueBolsistas->condicao == 'Bolsista') && ($valueBolsistas->Instituto != 'Ensino Médio')) {
        
        $bolsistasESAtivos[$i] = $valueBolsistas->edital;
    }else{

    }
}
foreach ($bolsistasESAtivos as $key => $value) {
    //echo $value,"<br>";
}
//TOTAL DE BOLSITAS ATIVOS
$ESAtivos = array_count_values($bolsistasESAtivos);
foreach ($ESAtivos as $key => $value) {
     $bolsistasESAtivosTOT[$key] = $value;
}
foreach ($bolsistasESAtivosTOT as $key => $value) {
    $totIntESAtivos[$key] = ($value*400.00);
}

$labelbolsistasESAtivos = array_values(array_unique($bolsistasESAtivos, SORT_REGULAR));
$dataBolsistasESAtivos = array_values(array_unique($totIntESAtivos, SORT_REGULAR));




echo "<script>


var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ",json_encode($labelbolsistasESAtivos),",
      datasets: [
        {
          label: 'R$',
          backgroundColor: ['#3e95cd', '#8e5ea2','#3cba9f','#e8c3b9','#c45850'],
          data: ",json_encode($dataBolsistasESAtivos),"
        }
      ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: ''
      }
    }
});


</script>"



?>
</body>
</html>