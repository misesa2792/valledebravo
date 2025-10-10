@extends('layouts.main')

@section('content')
 {{--*/
  $gp = Auth::user()->group_id;
  /*--}}
  
  <main class="page-content row bg-body" id="app_pbrmc">
    
    @if($type == 0)
      @include('reporte.include.menumetas')
    @else 
      @include('reporte.include.menuindicadores')
    @endif


    <div class="col-md-12">
      <section class="page-content-wrapper no-padding">
        <div class="sbox animated fadeInRight ">
          <div class="sbox-title border-t-yellow"> <h4> Seguimiento de metas por reconducción</h4></div>
          <div class="sbox-content bg-white" style="min-height:300px;"> 	

            <div class="col-md-12 m-b-md text-center no-padding s-16">
                <div class="col-md-3">
                  <div :class="'col-md-12 p-xs cursor ' + (trim == 1 ? 'bg-success c-white' : 'bg-gray')" @click="selectTrim(1)">
                    <div>Trim #1</div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div :class="'col-md-12 p-xs cursor ' + (trim == 2 ? 'bg-success c-white' : 'bg-gray')" @click="selectTrim(2)">
                    <div>Trim #2</div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div :class="'col-md-12 p-xs cursor ' + (trim == 3 ? 'bg-success c-white' : 'bg-gray')" @click="selectTrim(3)">
                    <div>Trim #3</div>
                  </div>
                </div>

                <div class="col-md-3">
                  <div :class="'col-md-12 p-xs cursor ' + (trim == 4 ? 'bg-success c-white' : 'bg-gray')" @click="selectTrim(4)">
                    <div>Trim #4</div>
                  </div>
                </div>
              </div>

            <div class="table-resp">
             
              <div class="col-md-12" style="max-height:650px;">
                <table class="table table-bordered table-hover">
                  <tr class="t-tr-s10">
                    <th rowspan="2" width="30">#</th>
                    <th rowspan="2" class="text-center" width="40">Dependencias General</th>
                    <th rowspan="2" class="text-center" width="40">Dependencias Auxiliar</th>
                    <th rowspan="2" class="text-center" width="40">Proyecto</th>
                    <th rowspan="2" class="text-center">No.</th>
                    <th rowspan="2" class="text-center">Unidad Medida</th>
                    <th rowspan="2" class="text-center">Meta</th>
                    <th rowspan="2" class="text-center">Programado Anual</th>
                    <th rowspan="2" class="text-center">Modificada</th>
                    <th rowspan="2" width="10" class="no-borders"></th>
                    <th colspan="4" class="text-center">Programado Trimestral</th>
                    <th rowspan="2" width="10" class="no-borders"></th>
                    <th colspan="4" class="text-center">Avance Trimestral</th>
                  </tr>
                  <tr class="t-tr-s10">
                    <th class="text-center c-white bg-yellow-meta" width="100">1</th>
                    <th class="text-center c-white bg-green-meta" width="100">2</th>
                    <th class="text-center c-white bg-blue-meta" width="100">3</th>
                    <th class="text-center c-white bg-red-meta" width="100">4</th>
                    <th class="text-center c-white bg-yellow-meta" width="100">1</th>
                    <th class="text-center c-white bg-green-meta" width="100">2</th>
                    <th class="text-center c-white bg-blue-meta" width="100">3</th>
                    <th class="text-center c-white bg-red-meta" width="100">4</th>
                  </tr>
                  <tr class="t-tr-s10" v-for="(row,key) in rowsData">
                    <td class="c-text-alt">@{{ row.j }}</td>
                    <td class="c-text-alt text-center"><div>@{{ row.no_dep_gen }}</div> </td>
                    <td class="c-text-alt text-center"><div>@{{ row.no_dep_aux }}</div></td>
                    <td class="c-text-alt"><div>@{{ row.no_proyecto }}</div></td>
                    <td class="c-text-alt">@{{ row.no_a }} </td>
                    <td class="c-text-alt">@{{ row.um }} </td>
                    <td class="c-text-alt">@{{ row.meta }} </td>
                    <th class="fun text-right">@{{ row.pa }}</th>
                    <th class="fun text-right">@{{ row.mod }}</th>
                    <th class="no-borders"></th>
                    <td class="c-text text-right">@{{ row.t1 }}</td>
                    <td class="c-text text-right">@{{ row.t2 }}</td>
                    <td class="c-text text-right">@{{ row.t3 }}</td>
                    <td class="c-text text-right">@{{ row.t4 }}</td>
							      <th class="no-borders"></th>
                    <td :class="'c-text text-right ' + (row.std1 == 'ok' ? '' : 'danger')">@{{ row.tt1 }}</td>
                    <td :class="'c-text text-right ' + (row.std2 == 'ok' ? '' : 'danger')">@{{ row.tt2 }}</td>
                    <td :class="'c-text text-right ' + (row.std3 == 'ok' ? '' : 'danger')">@{{ row.tt3 }}</td>
                    <td :class="'c-text text-right ' + (row.std4 == 'ok' ? '' : 'danger')">@{{ row.tt4 }}</td>
                  </tr>
              </table>
              </div>

            </div>
          </div>
        </div>		 
      </section>
    </div>

  </main>	
<style>
  .t-tr-s10 td, th{
    font-size: 10px !important;
    padding: 0px;
    margin:0px;
  }
</style>
	<script>

    /* ---- 2) CREACIÓN DEL APP (aislado) ---- */
	const app = Vue.createApp({
		data() {
			return {
				rowsData : [],
        idy:0,
        type:0,
        cancelTokenSource: null,
        trim: 1
			};
		},
    watch: {
    },
		methods:{
      selectTrim(newValue) {
        this.trim = newValue;
        this.rowsProjects();
      },
	    rowsProjects(){
				if (this.cancelTokenSource) {
					this.cancelTokenSource.cancel("Solicitud cancelada debido a una nueva petición.");
				}

				// Crear un nuevo token de cancelación
				this.cancelTokenSource = axios.CancelToken.source();

				axios.get('{{ URL::to("reporte/searchsegmetas") }}',{
					params : {idy: this.idy, type: this.type, trim: this.trim},
					cancelToken: this.cancelTokenSource.token // Asignar el cancelToken
				}).then(response => {
					var row = response.data;
					if(row.status == 'ok'){
						this.rowsData = row.rowsData;
					}else{
						toastr.error(row.message);
					}
				}).catch(error => {
				}).finally(() => {
				});

      },downloadPDF(number){
        window.open('{{ URL::to("download/pdf?number=") }}'+number, '_blank');
      }
				
		},
		mounted(){
        this.trim = "{{ $trim }}";
			  this.type = "{{ $type }}";
        this.idy = "{{ $idy }}";
			  this.rowsProjects();
		}
	});

	/* ---- 4) MONTAJE ---- */
	var appPbrmc= app.mount('#app_pbrmc');
  </script>
  
@stop