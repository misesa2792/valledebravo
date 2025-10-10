<div class="row m-b-md">
	<div class="col-md-4">
		<div class="col-md-12 box-shadow bg-white b-r-5 p-md h-cont">
	
		  <h3 class="m-b p-t-10 pun text-center c-app">Dependencias Generales</h3>
	
		  <div class="col-md-12 m-t-lg">
			<div class="col-md-12">
			  <select class="mySelect full-width" id="btnarea">
				  @foreach ($dep_gen as $m)
					<option value="{{ $m->idarea }}">{{ $m->area }}</option>    
				  @endforeach
			  </select>
			</div>

			<div class="col-md-12 m-t-lg">
				<div class="col-md-6 no-padding">
					<select name="graficaradio" class="full-width mySelect" id="btnTipoRec">
						<option value="3">Sin Reconducción</option>
						<option value="2">Con Reconducción</option>
					</select>
				</div>
				<div class="col-md-6 no-padding">
					<select name="graficaradio" class="full-width mySelect" id="btnTrimestre">
						<option value="5">Anual</option>
						<option value="1">#1 Trimestre</option>
						<option value="2">#2 Trimestre</option>
						<option value="3">#3 Trimestre</option>
						<option value="4">#4 Trimestre</option>
					</select>
				</div>
				
			  </div>

		  	</div>
	
		</div>
	</div>

	<div class="col-md-4">
		<div class="col-md-12 box-shadow bg-white b-r-5 p-md h-cont">
	
		  	<h3 class="m-b p-t-10 pun text-center c-app">Porcentaje General</h3>
	
			<div class="col-md-12 text-center m-t-md no-padding">

				<div class="col-md-4">
				<div class="col-md-12 p-xs b-r-5 s-14 bg-gray">
				<p class="com">Programado</p>
				<span id="res_prog_anual" class="fun font-bold">0.00 </span>
				</div>
				</div>
				<div class="col-md-4">
				<div class="col-md-12 p-xs b-r-5 s-14 bg-gray">
					<p class="com">Avanve</p>
					<span id="res_avance" class="fun font-bold">0.00 </span>
					</div>
				</div>
				<div class="col-md-4">
				<div class="col-md-12 p-xs b-r-5 s-14 bg-gray">
					<p class="com">Porcentaje</p>
					<span id="res_porc" class="fun font-bold">0.00% </span>
					</div>
				</div>

			</div>
	
		</div>
	</div>

	<div class="col-md-4">
		<div class="col-md-12 box-shadow bg-white b-r-5 p-md h-cont">
			<div class="col-md-12 text-center" id="pieChartContent2"></div>
		</div>
	</div>
</div>
<section class="col-md-12 m-t-md " id="app_size">

	<article class="text-right" v-if="info.length > 0">
		<button type="button" class="btn btn-sm btn-white b-r-30" onclick="captureAndSave()"> <i class="fa icon-file-pdf var"></i> Exportar PDF</button>
	</article>


	<article class="row">
		<div class="col-md-12" id="pieChartContent" style="min-height:350px;"></div>
	</article>

    <div class="col-sm-12 col-md-12 no-padding m-b-lg" >
        <article class="col-sm-12 col-md-12"> 
            <div class="col-sm-12 col-md-12 bg-white b-r-10 cont-card box-shadow" >
                
                <div class="col-sm-12 col-md-12 scroll m-t-md" style="height: auto;overflow:scroll;"  v-if="info.length > 0">
                    <table class="table table-bordered table-hover">
						<tr class="t-tr-s12">
                            <th rowspan="2" width="30"># _ @{{ no_tipo }}</th>
                            <th rowspan="2" colspan="2" class="text-center">Dependencias Auxiliar</th>
                            <th rowspan="2" colspan="2" class="text-center">Proyecto</th>
                            <th rowspan="2" class="text-center">Programado Anual</th>
                            <th rowspan="2" class="text-center">Avance Anual</th>
                            <th rowspan="2" class="text-center">Modificada</th>
							<th rowspan="2" width="10" class="no-borders"></th>
							<th colspan="4" class="text-center">Programado Trimestral</th>
							<th rowspan="2" width="10" class="no-borders"></th>
                            <th colspan="4" class="text-center">
								<div v-if="no == 3">Sin Reconduccion</div>
								<div v-if="no == 2">Con Reconduccion</div>
							</th>
                            <th rowspan="2">Porcentaje</th>
                        </tr>
                        <tr class="t-tr-s12">
							<th class="text-center c-white bg-yellow-meta">1</th>
							<th class="text-center c-white bg-green-meta">2</th>
							<th class="text-center c-white bg-blue-meta">3</th>
							<th class="text-center c-white bg-red-meta">4</th>

							<th class="text-center c-white bg-yellow-meta">1</th>
							<th class="text-center c-white bg-green-meta">2</th>
							<th class="text-center c-white bg-blue-meta">3</th>
							<th class="text-center c-white bg-red-meta">4</th>
                        </tr>
                        <tr class="t-tr-s12" v-for="(row,key) in info">
                            <td class="c-text-alt">@{{ row.no }}</td>
                            <td class="c-text-alt">@{{ row.no_dep_aux }}</td>
                            <td class="c-text-alt">@{{ row.dep_aux }}</td>
                            <td class="c-text-alt">@{{ row.no_proy }}</td>
                            <td class="c-text-alt">@{{ row.proyecto }}</td>
                            <th class="fun text-right">@{{ row.prog_anual }}</th>
                            <th class="c-success text-right">@{{ row.cantidad }}</th>
                            <th class="c-app text-right">@{{ row.modificada }}</th>
							<th class="no-borders"></th>
							<td :class="'c-text text-right ' + (no_tipo == 1 ? 'c-white bg-yellow-meta' : '')">@{{ row.trim_1 }}</td>
                            <td :class="'c-text text-right ' + (no_tipo == 2 ? 'c-white bg-green-meta' : '')">@{{ row.trim_2 }}</td>
                            <td :class="'c-text text-right ' + (no_tipo == 3 ? 'c-white bg-blue-meta' : '')">@{{ row.trim_3 }}</td>
                            <td :class="'c-text text-right ' + (no_tipo == 4 ? 'c-white bg-red-meta' : '')">@{{ row.trim_4 }}</td>
							<th class="no-borders"></th>
                            <td :class="'c-text text-right ' + (no_tipo == 1 ? 'c-white bg-yellow-meta' : '')">@{{ row.avance_1 }}</td>
                            <td :class="'c-text text-right ' + (no_tipo == 2 ? 'c-white bg-green-meta' : '')">@{{ row.avance_2 }}</td>
                            <td :class="'c-text text-right ' + (no_tipo == 3 ? 'c-white bg-blue-meta' : '')">@{{ row.avance_3 }}</td>
                            <td :class="'c-text text-right ' + (no_tipo == 4 ? 'c-white bg-red-meta' : '')">@{{ row.avance_4 }}</td>
                            <th class="c-app text-right">@{{ row.cant }}%</th>
                        </tr>
                    </table>
                </div>

                <div class="col-sm-12 col-md-12" v-else>
					<div class="col-md-12">
						<h1 class="text-center com"> <i class="fa  fa-folder-open-o s-40"></i> </h1>
						<h2 class="text-center com">No se encontraron Registros!</h2>
					</div>
                </div>
                
            </div>
        </article>
    </div>
</section>

<style>
.h-cont{ height:250px; }
</style>

<script>

	function captureAndSave() {
        var canvas = document.getElementById('canvas');
        var imageData = canvas.toDataURL('image/png');



		var tipoRec = $('#btnTipoRec').val();
		var tipoTrim = $('#btnTrimestre').val();
		// Verificar si se seleccionó un radio antes de continuar
			// Realizar una solicitud AJAX al servidor para guardar la imagen
			$.ajax({
				type: 'POST',
				url: "{{ URL::to('graficas/saveimg') }}",
				data: { image_data: imageData },
				success: function(response) {
					var objeto = JSON.parse(response);
					window.open( "{{ URL::to('graficas/pdf') }}"+ '?image_url=' + objeto.imagen+"&ida="+$("#btnarea").val()+"&no="+tipoRec+"&no_tipo="+tipoTrim+"&idanio={{ $idanio }}", '_blank');
				},
				error: function(error) {
					console.error('Error al guardar la imagen');
				}
			});
    }

	$(".mySelect").select2();

    	grafica("{{ $no }}", 5);
		
		$("#btnarea").on("change", function(e) {
		  e.preventDefault();
		  	getSelectGrafica();
		});
		$("#btnTipoRec").on("change", function(e) {
		  e.preventDefault();
		  	getSelectGrafica();
		});

		$("#btnTrimestre").on("change", function(e) {
		  e.preventDefault();
		  	getSelectGrafica();
		});
		function getSelectGrafica(){
			grafica($('#btnTipoRec').val(), $('#btnTrimestre').val());
		}


		function grafica(no,no_tipo){
		  axios.get("{{ URL::to('graficas/graficaproyectos') }}",{
					params : {ida:$("#btnarea").val(), no:no, idanio:"{{ $idanio }}", no_tipo:no_tipo}
		  }).then(response =>{
			let name = [];
			let cant = [];
			let row = response.data;

			$("#res_prog_anual").html(row.prog_anual);
			$("#res_avance").html(row.avance);
			$("#res_porc").html(row.porcentaje+"%");

			vm.info = row.rows;
			vm.no = row.no;
			vm.no_tipo = row.no_tipo;

			let rows = row.rows;
			for (var i = 0; i < rows.length; i++) {
				  var _cant = rows[i].cant;
				  name.push(rows[i].no);
				  cant.push(_cant);
				}
				graf(name,cant, row.prog_anual1,row.avance1, row.no);
		  }).catch(error => {
			//toastr.error("Error, vuelve a intentar!");
		  })
		}

		function graf(name,cant, prog_anual, avance, no){
			$('#pieChartContent').empty().append('<canvas id="canvas" height="55"><canvas>');
			$('#pieChartContent2').empty().append('<canvas id="Pie" height="55"><canvas>');
				const data = {
					labels: name,
					datasets: [{
						label: "Proyectos "+(no == 3 ? " Sin Reconduccion" : "Con Reconduccion"),
						data: cant,
						barThickness: 60,
						backgroundColor: [
							'rgba(98, 17, 50, 0.2)',
							'rgba(255, 159, 64, 0.2)',
							'rgba(255, 205, 86, 0.2)',
							'rgba(75, 192, 192, 0.2)',
							'rgba(54, 162, 235, 0.2)',
							'rgba(153, 102, 255, 0.2)',
							'rgba(201, 203, 207, 0.2)',
							'rgba(255, 0, 0, 0.2)',
							'rgba(0, 255, 0, 0.2)',
							'rgba(0, 0, 255, 0.2)',
							'rgba(255, 255, 0, 0.2)',
							'rgba(0, 255, 255, 0.2)',
							'rgba(255, 0, 255, 0.2)',
							'rgba(128, 0, 0, 0.2)',
							'rgba(0, 128, 0, 0.2)',
							'rgba(0, 0, 128, 0.2)',
							'rgba(128, 128, 0, 0.2)',
							'rgba(128, 0, 128, 0.2)',
							'rgba(0, 128, 128, 0.2)',
							'rgba(128, 64, 0, 0.2)',
							'rgba(128, 128, 128, 0.2)',
							'rgba(64, 0, 128, 0.2)',
							'rgba(0, 64, 128, 0.2)',
							'rgba(64, 128, 0, 0.2)',
							'rgba(0, 128, 64, 0.2)',
							'rgba(128, 64, 64, 0.2)',
							'rgba(64, 128, 64, 0.2)',
							'rgba(64, 64, 128, 0.2)',
							'rgba(128, 64, 128, 0.2)'
						],
						borderColor: [
							'rgb(98, 17, 50)',
							'rgb(255, 159, 64)',
							'rgb(255, 205, 86)',
							'rgb(75, 192, 192)',
							'rgb(54, 162, 235)',
							'rgb(153, 102, 255)',
							'rgb(201, 203, 207)',
							'rgb(255, 0, 0)',
							'rgb(0, 255, 0)',
							'rgb(0, 0, 255)',
							'rgb(255, 255, 0)',
							'rgb(0, 255, 255)',
							'rgb(255, 0, 255)',
							'rgb(128, 0, 0)',
							'rgb(0, 128, 0)',
							'rgb(0, 0, 128)',
							'rgb(128, 128, 0)',
							'rgb(128, 0, 128)',
							'rgb(0, 128, 128)',
							'rgb(128, 64, 0)',
							'rgb(128, 128, 128)',
							'rgb(64, 0, 128)',
							'rgb(0, 64, 128)',
							'rgb(64, 128, 0)',
							'rgb(0, 128, 64)',
							'rgb(128, 64, 64)',
							'rgb(64, 128, 64)',
							'rgb(64, 64, 128)',
							'rgb(128, 64, 128)'
						],
						borderWidth: 1
					}
				]
					};
					const ctx = document.getElementById('canvas').getContext('2d');
					const myChart = new Chart(ctx, {
						type: 'bar',
						data: data,
						options: {
							scales: {
								y: {
									beginAtZero: true
								}
							}
						}
					});

					const ctx2 = document.getElementById('Pie').getContext('2d');
					ctx2.canvas.parentNode.style.height = '230px';
                    ctx2.canvas.parentNode.style.width = '230px';
					const myChart2 = new Chart(ctx2, {
                            type: 'pie',
                            data: {
                                labels: ['Programado Anual','Avance Anual'],
                                datasets: [{
                                    data: [prog_anual,avance],
                                    backgroundColor: [
                                        'rgba(255, 192, 0,0.5)',
										'rgba(98, 17, 50, 0.6)',
                                    ],
                                    borderColor: [
                                        'rgba(255, 192, 0,1)',
                                        '#621132',
                                    ],
                                    borderWidth: 1
                                },
                                
                            ]
                            
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });

		  }

	const appTabs = Vue.createApp({
				data() {
					return {
						info : [],
						no:0,
						no_tipo:0,
					};
				}
			});

	const vm = appTabs.mount('#app_size');
</script>

