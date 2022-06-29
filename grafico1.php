<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
<center><h3>Gráfico 1</h3></center>
<div style="width: 90%;">
<canvas id="myChart"></canvas>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
<?php
$jsonBolsistas = file_get_contents("#");
$dataBolsistas = json_decode($jsonBolsistas);
$totoBolsistaEM = 0;
$totoBolsistaES = 0;
foreach ($dataBolsistas as $key => $value) {
  if($value->condicao == 'Bolsista'){
    if($value->Instituto == 'Ensino Médio'){
        $totoBolsistaEM++;
    }
    if($value->Instituto != 'Ensino Médio'){
        $totoBolsistaES++;
    }
  }

};




echo "<script>


var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Bolsas ofertadas no Valor de R$400,00(Ensino S.)', 'Bolsas ofertadas no Valor de R$100,00(Ensino M.)'],
        datasets: [{
            label: 'Bolsa/Total ofertado de 2011 até hoje.',
            data: [",$totoBolsistaES,", ",$totoBolsistaEM,"],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});



</script>"



?>
</body>
</html>