
<script src="<?=base_url()?>assets/third_party/highchart/highcharts.js"></script>
<script src="<?=base_url()?>assets/third_party/highchart/modules/series-label.js"></script>
<script src="<?=base_url()?>assets/third_party/highchart/modules/exporting.js"></script>
<script src="<?=base_url()?>assets/third_party/highchart/modules/export-data.js"></script>


<style type="css">
	#container {
		min-width: 310px;
		max-width: 800px;
		height: 800px;
		margin: 0 auto
	}
	
	
</style>
<div class="wrapper">
	<div class="container">

		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<div class="page-title-box">
					<div class="btn-group pull-right">
						<ol class="breadcrumb hide-phone p-0 m-0">
							
							<li class="active">
								Grafik Perpustakaan
							</li>
						</ol>
					</div>
					<h4 class="page-title">Grafik Perpustakaan</h4>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->
		
		<div class="row">
			<div class="col-md-12">
				<div class="card-box">
					<div class="row">
						<form class="form-inline" action="<?=base_url();?>data/grafik" method="GET" >
							<div class="form-group m-r-10">
								<label for="exampleInputName2">Tanggal Pencarian</label>
								<div class="input-daterange input-group" id="date-range">
									<input type="text" class="form-control" name="from" value="<?=$this->input->get('from')?>"/>
									<span class="input-group-addon bg-custom text-white b-0">to</span>
									<input type="text" class="form-control" name="last" value="<?=$this->input->get('last')?>"/>
								</div>
							</div>
							<button type="submit" class="btn btn-success btn-custom waves-effect waves-light btn-sm">
								Cari
							</button>
						</form>
					
					</div>
				</div>
			</div>
		</div>
		
		<!--
		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
						<div id="container"></div>
				</div>
			</div>
		</div>-->
		
		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
						<div id="container_siswa"></div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
						<div id="container_buku"></div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
						<div id="container_peringkat_siswa"></div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
						<div id="container_peringkat_buku"></div>
				</div>
			</div>
		</div>
		
		<?php if($data['role']=='siswa'){?>
		<div class="row">
			<div class="col-sm-6">
				<div class="card-box table-responsive">
						<div id="container3"></div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="card-box table-responsive">
						<div id="container4"></div>
				</div>
			</div>
		</div>
		<?php
		}else{ ?>
		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
						<div id="container3"></div>
				</div>
			</div>
		</div>
		<?php
		} ?>
		<div id="demo"></div>
		<div id="demo1"></div>
		<div id="demo2"></div>
		<?php 
		//print_r($data['listing_peringkat_siswa']['data']);
		?>
		<?php 
		//print_r($data['listing_peringkat_buku']['data']);
		?>
		<?php 
		//print_r($data['listing_peringkat_tag']);
		?>
<script>
//var timeValue = '1167609600000';
//document.getElementById("demo").innerHTML = new Date(+timeValue);
<?php 
	/*
	$date = "2018-08-07 22:40:00";
	$date = strtotime ( '-7 hours' , strtotime ( $date ) ) ; 
	
	$new_time = date("Y-m-d H:i:s",$date);
	$new_time = str_replace(" ","T",$new_time);
	$new_time = $new_time."Z";*/
?>
/*
var dates_as_int = [
    "<?=$new_time?>"
];
var dates = dates_as_int.map(function(dateStr) {
    return new Date(dateStr).getTime();
});
document.getElementById("demo").innerHTML = '<?=$new_time?>';
document.getElementById("demo1").innerHTML = dates;
document.getElementById("demo2").innerHTML = new Date(+dates[0]);


	Highcharts.chart('container', {

		title: {
			text: 'Grafik Tahun Ajaran 2016-2018'
		},

		subtitle: {
			text: 'Source: -'
		},

		yAxis: {
			title: {
				text: 'Jumlah'
			}
		},
		legend: {
			layout: 'vertical',
			align: 'right',
			verticalAlign: 'middle'
		},

		plotOptions: {
			series: {
				label: {
					connectorAllowed: false
				},
				pointStart: 2016
			}
		},

		series: [{
			name: 'Pembaca',
			data: [321, 452, 401]
		}, {
			name: 'Buku',
			data: [421, 479, 502, ]
		}, {
			name: 'Siswa',
			data: [887, 898, 902]
		}],

		responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					legend: {
						layout: 'horizontal',
						align: 'center',
						verticalAlign: 'bottom'
					}
				}
			}]
		}

	});
	*/
	
	$.getJSON(
		'https://cdn.rawgit.com/highcharts/highcharts/057b672172ccc6c08fe7dbb27fc17ebca3f5b770/samples/data/usdeur.json',
		function (data) {

			Highcharts.chart('container', {
				chart: {
					zoomType: 'x'
				},
				title: {
					text: 'USD to EUR exchange rate over time'
				},
				subtitle: {
					text: document.ontouchstart === undefined ?
							'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
				},
				xAxis: {
					type: 'datetime'
				},
				yAxis: {
					title: {
						text: 'Exchange rate'
					}
				},
				legend: {
					enabled: false
				},
				plotOptions: {
					area: {
						fillColor: {
							linearGradient: {
								x1: 0,
								y1: 0,
								x2: 0,
								y2: 1
							},
							stops: [
								[0, Highcharts.getOptions().colors[0]],
								[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
							]
						},
						marker: {
							radius: 2
						},
						lineWidth: 1,
						states: {
							hover: {
								lineWidth: 1
							}
						},
						threshold: null
					}
				},

				series: [{
					type: 'area',
					name: 'USD to EUR',
					data: data
				}]
			});
		}
	);
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	Highcharts.chart('container_siswa', {
		chart: {
			zoomType: 'x'
		},
		title: {
			text: 'Jumlah <?=($data['role'])?> membaca perhari'
		},
		subtitle: {
			text: document.ontouchstart === undefined ?
					'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
		},
		xAxis: {
			type: 'datetime'
		},
		yAxis: {
			title: {
				text: 'Jumlah <?=($data['role'])?>'
			}
		},
		legend: {
			enabled: false
		},
		plotOptions: {
			area: {
				fillColor: {
					linearGradient: {
						x1: 0,
						y1: 0,
						x2: 0,
						y2: 1
					},
					stops: [
						[0, Highcharts.getOptions().colors[0]],
						[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
					]
				},
				marker: {
					radius: 2
				},
				lineWidth: 1,
				states: {
					hover: {
						lineWidth: 1
					}
				},
				threshold: null
			}
		},

		series: [{
			type: 'area',
			name: '<?=ucfirst($data['role'])?>',
			data: [<?php 
			$no=0;
			foreach($data['data_grafik']['user'] as $siswa){
				if($no>0){
					echo ',['.$siswa[0].','.$siswa[1].']';
				}else{
					echo '['.$siswa[0].','.$siswa[1].']';
				}
				$no++;
			};?>]
		}]
	});
	
	Highcharts.chart('container_buku', {
		chart: {
			zoomType: 'x'
		},
		title: {
			text: 'Jumlah buku dibaca perhari'
		},
		subtitle: {
			text: document.ontouchstart === undefined ?
					'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
		},
		xAxis: {
			type: 'datetime'
		},
		yAxis: {
			title: {
				text: 'Jumlah buku'
			}
		},
		legend: {
			enabled: false
		},
		plotOptions: {
			area: {
				fillColor: {
					linearGradient: {
						x1: 0,
						y1: 0,
						x2: 0,
						y2: 1
					},
					stops: [
						[0, Highcharts.getOptions().colors[2]],
						[1, Highcharts.Color(Highcharts.getOptions().colors[2]).setOpacity(0).get('rgba')]
					]
				},
				marker: {
					radius: 2
				},
				lineWidth: 1,
				states: {
					hover: {
						lineWidth: 1
					}
				},
				threshold: null
			}
		},

		series: [{
			type: 'area',
			name: 'Buku',
			data: [<?php 
			$no=0;
			foreach($data['data_grafik']['buku'] as $buku){
				if($no>0){
					echo ',['.$buku[0].','.$buku[1].']';
				}else{
					echo '['.$buku[0].','.$buku[1].']';
				}
				$no++;
			};?>]
		}]
	});
	
	Highcharts.chart('container_peringkat_siswa', {
		chart: {
			type: 'column'
		},
		title: {
			text: 'Grafik Jumlah <?=ucfirst($data['role'])?> membaca Buku'
		},
		subtitle: {
			text: 'Source: Perpustakaan sekolah'
		},
		xAxis: {
			type: 'category',
			labels: {
				rotation: -45,
				style: {
					fontSize: '13px',
					fontFamily: 'Verdana, sans-serif'
				}
			}
		},
		yAxis: {
			min: 0,
			title: {
				text: 'Pembaca (<?=ucfirst($data['role'])?>)'
			}
		},
		legend: {
			enabled: false
		},
		tooltip: {
			pointFormat: 'Total waktu: <b>{point.y:.0f} menit</b>'
		},
		series: [{
			name: 'Pembaca',
			data: [
			<?php 
			$no=0;
			foreach($data['listing_peringkat_user']['data'] as $siswa){
				if($data['role']=='siswa'){
					if($no>0){
						echo ',["'.$siswa['nama_user'].' - '.$siswa['nama_kelas'].'",'.$siswa['total_waktu'].']';
					}else{
						echo '["'.$siswa['nama_user'].' - '.$siswa['nama_kelas'].'",'.$siswa['total_waktu'].']';
					}
				}else{
					if($no>0){
						echo ',["'.$siswa['nama_user'].'",'.$siswa['total_waktu'].']';
					}else{
						echo '["'.$siswa['nama_user'].'",'.$siswa['total_waktu'].']';
					}
				}
				$no++;
			};?>
				
				
			],
			dataLabels: {
				enabled: true,
				rotation: -90,
				color: '#FFFFFF',
				align: 'right',
				//format: '{point.y:.1f}', // one decimal
				y: 10, // 10 pixels down from the top
				style: {
					fontSize: '13px',
					fontFamily: 'Verdana, sans-serif'
				}
			}
		}]
	});
	
	Highcharts.chart('container_peringkat_buku', {
		chart: {
			type: 'column'
		},
		title: {
			text: 'Grafik Jumlah buku dibaca <?=ucfirst($data['role'])?>'
		},
		subtitle: {
			text: 'Source: Perpustakaan sekolah'
		},
		xAxis: {
			type: 'category',
			labels: {
				rotation: -45,
				style: {
					fontSize: '13px',
					fontFamily: 'Verdana, sans-serif'
				}
			}
		},
		yAxis: {
			min: 0,
			title: {
				text: 'Dibaca (buku)'
			}
		},
		legend: {
			enabled: false
		},
		tooltip: {
			pointFormat: 'Total waktu: <b>{point.y:.0f} menit</b>'
		},
		series: [{
			name: 'Buku',
			data: [
			<?php 
			$no=0;
			foreach($data['listing_peringkat_buku']['data'] as $siswa){
				if($no>0){
					echo ',["'.$siswa['nama_buku'].'",'.$siswa['total_waktu'].']';
				}else{
					echo '["'.$siswa['nama_buku'].'",'.$siswa['total_waktu'].']';
				}
				$no++;
			};?>
				
				
			],
			dataLabels: {
				enabled: true,
				rotation: -90,
				color: '#FFFFFF',
				align: 'right',
				//format: '{point.y:.1f}', // one decimal
				y: 10, // 10 pixels down from the top
				style: {
					fontSize: '13px',
					fontFamily: 'Verdana, sans-serif'
				}
			}
		}]
	});
	
	Highcharts.chart('container3', {
		chart: {
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			type: 'pie'
		},
		title: {
			text: 'Grafik Dibaca'
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: true,
					format: '<b>{point.name}</b>: {point.percentage:.1f} %',
					style: {
						color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
					}
				}
			}
		},
		series: [{
			name: 'Jenis Buku',
			colorByPoint: true,
			data: [<?php 
			$no=0;
			foreach($data['listing_peringkat_tag'] as $label => $value){
				if($no>0){
					echo ', {
							name: "Tag '.$label.'",
							y: '.$value.'
						}';
				}else{
					echo ' {
							name: "Tag '.$label.'",
							y: '.$value.',
							sliced: true,
							selected: true
						}';
				}
				$no++;
			};?>]
		}]
	});
	
	Highcharts.chart('container4', {
		chart: {
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			type: 'pie'
		},
		title: {
			text: 'Grafik Pembaca'
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: true,
					format: '<b>{point.name}</b>: {point.percentage:.1f} %',
					style: {
						color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
					}
				}
			}
		},
		series: [{
			name: '<?=ucfirst($data['role'])?>',
			colorByPoint: true,
			data: [
			<?php 
			$no=0;
			foreach($data['listing_peringkat_grade'] as $label => $value){
				if($no>0){
					echo ', {
							name: "Kelas '.$label.'",
							y: '.$value.'
						}';
				}else{
					echo ' {
							name: "Kelas '.$label.'",
							y: '.$value.',
							sliced: true,
							selected: true
						}';
				}
				$no++;
			};?>
			]
		}]
	});
</script>		
		