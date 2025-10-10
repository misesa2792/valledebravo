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
                
              <div class="col-md-12 m-b-md text-center no-padding s-16">
                    <div class="col-md-3 no-padding">
                      <div class="col-md-12 bg-gray p-xs" >
                        <div>Total Trim #1</div>
                        @{{totales.t1 }}
                      </div>
                    </div>
                     <div class="col-md-3">
                      <div class="col-md-12 bg-gray p-xs" >
                        <div>Total Trim #2</div>
                         @{{totales.t2 }}
                      </div>
                    </div>
                     <div class="col-md-3">
                      <div class="col-md-12 bg-gray p-xs" >
                        <div>Total Trim #3</div>
                        @{{totales.t3 }}
                      </div>
                    </div>

                     <div class="col-md-3 no-padding">
                      <div class="col-md-12 bg-gray p-xs" >
                        <div>Total Trim #4</div>
                        @{{totales.t4 }}
                      </div>
                    </div>
                  </div>
                  
                  <table class="table table-bordered no-margins" v-for="m in rowsData">
                    <tr>
                      <th colspan="4" class="c-blue">@{{ m.no_dep_gen }} | @{{ m.no_dep_aux }} | <span class="badge badge-primary badge-outline">@{{ m.no_proyecto }}</span>@{{ m.proyecto }}</th>
                      <td class="text-center c-white bg-yellow-meta" width="25">1</td>
                      <td class="text-center c-white bg-green-meta" width="25">2</td>
                      <td class="text-center c-white bg-blue-meta" width="25">3</td>
                      <td class="text-center c-white bg-red-meta" width="25">4</td>
                    </tr>
                    <tr v-for="v in m.indicadores">
                      <td width="10%" >@{{ v.mir }}</td>
                      <td width="60%">@{{ v.ind }}</td>
                      <td width="10%" class="text-center">@{{ v.fre }}</td>
                      <td width="10%" class="text-center s-10">@{{ v.fla }}</td>
                      <td>
                          <div v-if="v.url1 == 'empty'">
                            <i class="fa fa-times c-black s-12"></i>
                          </div>
                          <div v-else-if="v.url1 == 'no_aplica'">
                            <i class="fa fa-check-circle c-yellow-meta s-12"></i>
                          </div>
                          <div v-else-if="v.url1 != 'empty' && v.url1 != 'no_aplica'">
                            <i class="fa icon-file-pdf c-danger s-12 cursor" @click.prevent="downloadPDF(v.url1)"></i>
                          </div>
                      </td>
                      <td>
                          <div v-if="v.url2 == 'empty'">
                            <i class="fa fa-times c-black s-12"></i>
                          </div>
                          <div v-else-if="v.url2 == 'no_aplica'">
                            <i class="fa fa-check-circle c-green-meta s-12"></i>
                          </div>
                          <div v-else-if="v.url2 != 'empty' && v.url2 != 'no_aplica'">
                            <i class="fa icon-file-pdf c-danger s-12 cursor" @click.prevent="downloadPDF(v.url2)"></i>
                          </div>
                      </td>
                      <td>
                          <div v-if="v.url3 == 'empty'">
                            <i class="fa fa-times c-black s-12"></i>
                          </div>
                          <div v-else-if="v.url3 == 'no_aplica'">
                            <i class="fa fa-check-circle c-blue-meta s-12"></i>
                          </div>
                          <div v-else-if="v.url3 != 'empty' && v.url3 != 'no_aplica'">
                            <i class="fa icon-file-pdf c-danger s-12 cursor" @click.prevent="downloadPDF(v.url3)"></i>
                          </div>
                      </td>
                        <td>
                          <div v-if="v.url4 == 'empty'">
                            <i class="fa fa-times c-black s-12"></i>
                          </div>
                          <div v-else-if="v.url4 == 'no_aplica'">
                            <i class="fa fa-check-circle c-red-meta s-12"></i>
                          </div>
                          <div v-else-if="v.url4 != 'empty' && v.url4 != 'no_aplica'">
                            <i class="fa icon-file-pdf c-danger s-12 cursor" @click.prevent="downloadPDF(v.url4)"></i>
                          </div>
                      </td>
                    </tr>
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
				rowsDataOriginal : [],
				rowsData : [],
        idy:0,
        type:0,
        iddg:0,
        t1:0,
        t2:0,
        t3:0,
        t4:0,
        cancelTokenSource: null
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
    computed: {
      totales() {
        let count1 = 0;
        let count2 = 0;
        let count3 = 0;
        let count4 = 0;
        this.rowsData.forEach(m => {
          m.indicadores.forEach(v => {
            if (v.url1 !== 'empty' && v.url1 !== 'no_aplica') {
              count1++;
            }
            if (v.url2 !== 'empty' && v.url2 !== 'no_aplica') {
              count2++;
            }
            if (v.url3 !== 'empty' && v.url3 !== 'no_aplica') {
              count3++;
            }
            if (v.url4 !== 'empty' && v.url4 !== 'no_aplica') {
              count4++;
            }
          });
        });
          return { t1: count1, t2: count2, t3: count3, t4: count4 };
      }
		},
		methods:{
	    rowsProjects(){
				if (this.cancelTokenSource) {
					this.cancelTokenSource.cancel("Solicitud cancelada debido a una nueva petición.");
				}

				// Crear un nuevo token de cancelación
				this.cancelTokenSource = axios.CancelToken.source();

				axios.get('{{ URL::to("indicadores/searchreconducciones") }}',{
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