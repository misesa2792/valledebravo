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
          <div class="sbox-title border-t-yellow"> <h4> Reconducciones</h4></div>
          <div class="sbox-content bg-white" style="min-height:300px;"> 	
            <div class="table-resp">
              
              <div class="col-md-12 no-padding m-t-xs m-b-xs">
                  <table class="table table-bordered no-margins b-gray bg-white">
                      <tr>
                        <td class="no-borders">
                            <div class="s-14 c-text-alt">Dependencia general</div>
                            <select name="iddg" class="select2" ref="selectDepGen">
                              <option value="">--Select please--</option>
                              @foreach($rowsDepGen as $v)
                                <option value="{{ $v->no_dep_gen }}">{{ $v->no_dep_gen.' '.$v->area }}</option>
                              @endforeach
                            </select>
                          </td>
                      </tr>
                  </table>
              </div>  

              <div class="col-md-12 m-b-md m-t-xs text-center no-padding s-16">
                <div class="col-md-3 no-padding">
                  <div class="col-md-12 bg-gray p-xs" >
                    <div>Total Trim #1</div>
                    @{{ t1 }}
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="col-md-12 bg-gray p-xs" >
                    <div>Total Trim #2</div>
                    @{{ t2 }}
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="col-md-12 bg-gray p-xs" >
                    <div>Total Trim #3</div>
                    @{{ t3 }}
                  </div>
                </div>

                <div class="col-md-3 no-padding">
                  <div class="col-md-12 bg-gray p-xs" >
                    <div>Total Trim #4</div>
                    @{{ t4 }}
                  </div>
                </div>
              </div>

              <table class="table table-hover border-gray no-margins table-ses">
                <thead>
                  <tr class="t-tr-s14 c-text-alt">
                    <th class="no-borders" colspan="2">Dependencia</th>
                    <th class="no-borders text-center" width="100">No. Proyecto</th>
                    <th class="no-borders">Proyecto</th>
                    <td width="40" class="text-center c-white bg-yellow-meta">1</td>
                    <td width="40" class="text-center c-white bg-green-meta">2</td>
                    <td width="40" class="text-center c-white bg-blue-meta">3</td>
                    <td width="40" class="text-center c-white bg-red-meta">4</td>
                  </tr>
                </thead>
                <tbody>
                  <template v-for="v in rowsData">
                    <tr>
                      <th class="text-center">
                        <span class="badge badge-primary badge-outline font-ses-monospace">@{{ v.no_dep_gen }}</span>
                      </th>
                      <th colspan="7" class="c-blue">@{{ v.dep_gen }}</th>
                    </tr>
                    <tr  v-for="r in v.data">
                      <td class="text-center font-ses-monospace">@{{ r.no_dep_aux }}</td>
                      <td>@{{ r.dep_aux }}</td>
                      <td class="text-center font-ses-monospace">@{{ r.no_proyecto }}</td>
                      <td>@{{ r.proyecto }}</td>
                      <td>
                          <div v-if="r.url1 == 'empty'">
                            <i class="fa fa-times c-black s-12"></i>
                          </div>
                          <div v-else-if="r.url1 == 'no_aplica'">
                            <i class="fa fa-check-circle c-yellow-meta s-12"></i>
                          </div>
                          <div v-else-if="r.url1 != 'empty' && r.url1 != 'no_aplica'">
                            <i class="fa icon-file-pdf c-danger s-10 cursor" @click.prevent="downloadPDF(r.url1)"></i>
                          </div>
                      </td>
                      <td>
                          <div v-if="r.url2 == 'empty'">
                            <i class="fa fa-times c-black s-12"></i>
                          </div>
                          <div v-else-if="r.url2 == 'no_aplica'">
                            <i class="fa fa-check-circle c-green-meta s-12"></i>
                          </div>
                          <div v-else-if="r.url2 != 'empty' && r.url2 != 'no_aplica'">
                            <i class="fa icon-file-pdf c-danger s-10 cursor" @click.prevent="downloadPDF(r.url2)"></i>
                          </div>
                      </td>
                      <td>
                          <div v-if="r.url3 == 'empty'">
                            <i class="fa fa-times c-black s-12"></i>
                          </div>
                          <div v-else-if="r.url3 == 'no_aplica'">
                            <i class="fa fa-check-circle c-blue-meta s-12"></i>
                          </div>
                          <div v-else-if="r.url3 != 'empty' && r.url3 != 'no_aplica'">
                            <i class="fa icon-file-pdf c-danger s-10 cursor" @click.prevent="downloadPDF(r.url3)"></i>
                          </div>
                      </td>
                        <td>
                          <div v-if="r.url4 == 'empty'">
                            <i class="fa fa-times c-black s-12"></i>
                          </div>
                          <div v-else-if="r.url4 == 'no_aplica'">
                            <i class="fa fa-check-circle c-red-meta s-12"></i>
                          </div>
                          <div v-else-if="r.url4 != 'empty' && r.url4 != 'no_aplica'">
                            <i class="fa icon-file-pdf c-danger s-10 cursor" @click.prevent="downloadPDF(r.url4)"></i>
                          </div>
                      </td>
                    </tr>
                  </template>
                </tbody>
              </table>

            </div>
          </div>
        </div>		 
      </section>
    </div>



  </main>	


	<script>

    /* ---- 2) CREACIÓN DEL APP (aislado) ---- */
	const app = Vue.createApp({
		data() {
			return {
				rowsData : [],
				rowsDataOriginal : [],
        idy:0,
        type:0,
        t1:0,
        t2:0,
        t3:0,
        t4:0,
        cancelTokenSource: null,
        iddg: '', 
			};
		},
    watch: {
      iddg(newVal){ 
        if (!newVal) {
          this.rowsData = this.rowsDataOriginal;
          return;
        }
        this.rowsData = this.rowsDataOriginal.filter(v => v.no_dep_gen === newVal);
      }
    },
		methods:{
	    rowsProjects(){
				if (this.cancelTokenSource) {
					this.cancelTokenSource.cancel("Solicitud cancelada debido a una nueva petición.");
				}

				// Crear un nuevo token de cancelación
				this.cancelTokenSource = axios.CancelToken.source();

				axios.get('{{ URL::to("reporte/searchreconducciones") }}',{
					params : {idy: this.idy, type: this.type},
					cancelToken: this.cancelTokenSource.token // Asignar el cancelToken
				}).then(response => {
					var row = response.data;
					if(row.status == 'ok'){
						this.rowsDataOriginal = row.rowsData;
						this.rowsData = row.rowsData;
						this.t1 = row.t1;
						this.t2 = row.t2;
						this.t3 = row.t3;
						this.t4 = row.t4;
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
      const vm = this;
      $(this.$refs.selectDepGen).select2();

      // Sincronizar cuando el usuario cambia el select2
      $(this.$refs.selectDepGen).on('change', function () {
        vm.iddg = $(this).val();
      });

      this.type = "{{ $type }}";
      this.idy = "{{ $idy }}";
      this.rowsProjects();
		}
	});

	/* ---- 4) MONTAJE ---- */
	var appPbrmc= app.mount('#app_pbrmc');
  </script>
  
@stop