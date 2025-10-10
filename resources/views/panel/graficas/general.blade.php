<h3 class="text-center c-text m-b-md">Gráfica Anual de {{ $type == 0 ? 'Metas' : 'Indicadores' }} en Porcentaje de Avance</h3>
<div id="pieChartContent"></div>

<section class="row m-t-md " id="app_size">

	<article class="text-right m-b-md" v-if="info.length > 0">
		<button type="button" class="btn btn-sm btn-white b-r-30" onclick="captureAndSave()"> <i class="fa icon-file-pdf var"></i> Exportar PDF</button>
	</article>


    <div class="col-sm-12 col-md-12 no-padding m-b-lg">
        <article class="col-sm-12 col-md-12"> 
            <div class="col-sm-12 col-md-12 bg-white b-r-10 cont-card box-shadow">
                
                <div class="col-sm-12 col-md-12 scroll p-md" style="height: 500px;overflow:scroll;">
                    <table class="table table-bordered table-hover">
                        <tr class="t-tr-s14 c-text-alt">
                            <th width="30">#</th>
                            <th>Dependencias Generales</th>
                            <th>Programado Anual</th>
                            <th>Avance</th>
                            <th>Porcentaje</th>
                        </tr>
                        <tr class="t-tr-s14 c-text" v-for="(row,key) in info">
                            <td class="c-text-alt">@{{ row.no }}</td>
                            <td class="c-text-alt">@{{ row.dep_gen }}</td>
                            <th class="fun text-right">@{{ row.prog_anual }}</th>
                            <th class="c-success text-right">@{{ row.cantidad }}</th>
                            <th class="c-app text-right">@{{ row.cant }}%</th>
                        
                        </tr>
                    </table>
                </div>
                
            </div>
        </article>
    </div>
</section>


<script>
	function captureAndSave() {
        var canvas = document.getElementById('canvas');
        var imageData = canvas.toDataURL('image/png');

	
			// Realizar una solicitud AJAX al servidor para guardar la imagen
			$.ajax({
				type: 'POST',
				url: "{{ URL::to('graficas/saveimg') }}",
				data: { image_data: imageData },
				success: function(response) {
					var objeto = JSON.parse(response);
					window.open( "{{ URL::to('graficas/pdfgeneral') }}"+ '?image_url=' + objeto.imagen+"&idanio={{ $idanio }}"+"&type={{ $type }}", '_blank');
				},
				error: function(error) {
					console.error('Error al guardar la imagen');
				}
			});
    }

    grafica();

	function grafica(){
		axios.get("{{ URL::to('graficas/grafica') }}",{
				params : {idanio:"{{ $idanio }}",type:"{{ $type }}"}
		}).then(response =>{
		let name = [];
		let cant = [];
		let row = response.data;
		vm.info = row.rows;
		let rows = row.rows;
		for (var i = 0; i < rows.length; i++) {
				var _cant = rows[i].cant;
				name.push(rows[i].no);
				cant.push(_cant);
			}
			graf(name,cant);
		}).catch(error => {
		//toastr.error("Error, vuelve a intentar!");
		})
	}

		function graf(name,cant){
			$('#pieChartContent').empty().append('<canvas id="canvas" height="55"><canvas>');
			$('#pieChartContent2').empty().append('<canvas id="Pie" height="55"><canvas>');
				const data = {
					labels: name,
					datasets: [{
						label: "dependencias",
						data: cant,
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
					}]
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
		  }
		$(".btnreset_tab").click(function(eve){
		  eve.preventDefault();
		  reset();
		  grafica();
		});


		const appTabs = Vue.createApp({
				data() {
					return {
						info : []
					};
				}
			});

	const vm = appTabs.mount('#app_size');
</script>

