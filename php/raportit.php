<?php
    include_once("../config/https.php");
    include_once("../config/config.php");
    include("../php/functions.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="../styles/styles_test.css">
    <link href="https://fonts.googleapis.com/css?family=Baloo+Da+2&display=swap" rel="stylesheet">
    <style>
	    canvas{
		    -moz-user-select: none;
		    -webkit-user-select: none;
		    -ms-user-select: none;
	    }
	</style>
	<!-- Seuraavat skriptit ja raporttirakenne käytännössä copy-paste chart.js -kirjastosta-->
    <script src="../js/Chart.min.js"></script>
	<script src="../js/utils.js"></script>
    
</head>
<body>



<div class="valikkoSivuWrapper">
    <div class="valikkoSivuNavNimi">RAPORTIT</div>
    <div class="valikkoSivuNavKuvake">
        <i id="closeRaportit" class='fas fa-times-circle'></i>
    </div>
    <div class="valikkoSivuBody">

    <h3>TULOSSA!</h3>
    <p>Raportointisivulla pystyt tarkastelemaan unesi laatua ja siihen vaikuttavia tekijöitä haluamallasi aikavälillä. Voit rajata aikaa mm. seurataksesi eroaako nukkumisesi loma-aikana, uuden harrastuksen tai lääkityksen myötä tai muuttuneessa elämäntilanteessa.</p>

    <div style="width:100%;">
		<canvas id="canvas"></canvas>
	</div>
	<div class="buttonsCentered">
	<button class="buttonGeneric" id="randomizeData">Sekoita data</button>
	<button class="buttonGeneric" id="addDataset">Lisää parametri</button>
	<button class="buttonGeneric" id="removeDataset">Poista parametri</button>
	<button class="buttonGeneric" id="addData">Pidennä aikasarjaa</button>
    <button class="buttonGeneric" id="removeData">Lyhennä aikasarjaa</button>
    </div>
	<script>
		var MONTHS = ['Tammi', 'Helmi', 'Maalis', 'Huhti', 'Touko', 'Kesä', 'Heinä', 'Elo', 'Syys', 'Loka', 'Marras', 'Joulu'];
		var config = {
			type: 'line',
			data: {
				labels: ['Tammi', 'Helmi', 'Maalis', 'Huhti', 'Touko', 'Kesä', 'Heinä'],
				datasets: [{
					label: 'Unenlaatu',
					backgroundColor: window.chartColors.red,
					borderColor: window.chartColors.red,
					data: [
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor()
					],
					fill: false,
				}, {
					label: 'Liikunta',
					fill: false,
					backgroundColor: window.chartColors.blue,
					borderColor: window.chartColors.blue,
					data: [
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor()
					],
				}]
			},
			options: {
				responsive: true,
				title: {
					display: true,
					text: 'Unenlaatu ja siihen vaikuttavat tekijät'
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					x: {
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Month'
						}
					},
					y: {
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Value'
						}
					}
				}
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myLine = new Chart(ctx, config);
		};

		document.getElementById('randomizeData').addEventListener('click', function() {
			config.data.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return randomScalingFactor();
				});

			});

			window.myLine.update();
		});

		var colorNames = Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function() {
			var colorName = colorNames[config.data.datasets.length % colorNames.length];
			var newColor = window.chartColors[colorName];
			var newDataset = {
				label: 'Vaikuttava tekijä ' + config.data.datasets.length,
				backgroundColor: newColor,
				borderColor: newColor,
				data: [],
				fill: false
			};

			for (var index = 0; index < config.data.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());
			}

			config.data.datasets.push(newDataset);
			window.myLine.update();
		});

		document.getElementById('addData').addEventListener('click', function() {
			if (config.data.datasets.length > 0) {
				var month = MONTHS[config.data.labels.length % MONTHS.length];
				config.data.labels.push(month);

				config.data.datasets.forEach(function(dataset) {
					dataset.data.push(randomScalingFactor());
				});

				window.myLine.update();
			}
		});

		document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0, 1);
			window.myLine.update();
		});

		document.getElementById('removeData').addEventListener('click', function() {
			config.data.labels.splice(-1, 1); // remove the label first

			config.data.datasets.forEach(function(dataset) {
				dataset.data.pop();
			});

			window.myLine.update();
		});
	</script>


    </div>
</div>

<script>
    document.getElementById("closeRaportit").addEventListener("click", function(){
    document.location = 'sivurunko.php';
    })
</script>

<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<script src="../js/sivurunko.js"></script>
</body>
</html>