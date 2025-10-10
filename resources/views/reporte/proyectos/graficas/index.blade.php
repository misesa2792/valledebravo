@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{ asset('mass/js/plugins/chartjs/chartv3.8.2.min.js') }}"></script>
  <main class="page-content row bg-body" id="app_foda">

    @if($type == 0)
      @include('reporte.include.menumetas')
    @else 
      @include('reporte.include.menuindicadores')
    @endif

    <div class="col-md-12 m-t-md">
        <section class="col-md-12">
          <article class="col-sm-12 col-md-12 col-lg-12 contArticle">
            <section class="col-sm-12 col-md-12 col-lg-12 border-left-dashed-a p-md">
                <span class="line-circle-a text-center font-bold tips" title="{{ $year }}">{{ $year }} </span>
                <div class="col-sm-12 col-md-12 col-lg-12 bg-white box-shadow b-r-10 p-md b-r-c" id="line-comm" >

                 <div class="col-md-12 m-b-md">
			              <a href="{{ URL::to('reporte/graficasmetasexportar?idy='.$idy.'&type='.$type)}}" class="btn btn-xs btn-white b-r-5" target="_blank"> <i class="fa icon-file-excel lit"></i> Exportar</a>
                 </div>

                  <div class="col-md-12">

                    <div class="box well">
                      <div class="tab-container">
                      <ul class="nav nav-tabs">
                        <li class="active"><a href="#home" data-toggle="tab">Detalle</a></li>
                        <li><a href="#profile" data-toggle="tab">Gráfica</a></li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active use-padding" id="home">
                        <table class="table table-bordered table-hover">
                          <tr class="t-tr-s16">
                            <th>DEPENDENCIA GENERAL</th>
                            <th>TOTAL {{ $type == 0 ? 'METAS' : 'INDICADORES' }}</th>
                            <th>PORCENTAJE</th>
                            <th>GRÁFICA</th>
                          </tr>
                          @foreach ($info as $row)
                            <tr class="t-tr-s16">
                              <td>{{ $row->area }}</td>
                              <td class="text-center">{{ $row->total }}</td>
                              <td class="text-center">{{ number_format($row->porcentaje,2) }} %</td>
                              <td>
                                <div class="progress" style="background: rgb(185, 185, 185);height:10px;margin-bottom:0px;">
                                  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ $row->porcentaje }}"
                                  aria-valuemin="0" aria-valuemax="100" style="width:{{ $row->porcentaje }}%"></div>
                                </div>
                              </td>
                            </tr>
                          @endforeach
                        </table>
                        </div>
                        <div class="tab-pane use-padding" id="profile">
              
                        <canvas class="text-center" id="Pie_0" ></canvas>
                        <script>
                          const ctx = document.getElementById('Pie_0').getContext('2d');
                          ctx.canvas.parentNode.style.height = '700px';
                          ctx.canvas.parentNode.style.width = '700px';
                          var porcentaje = JSON.parse('{!! $porcentaje !!}');
                          var color = JSON.parse('{!! $color !!}');
                          var area = JSON.parse('{!! $area !!}');
                          const myChart = new Chart(ctx, {
                            type: 'pie',
                            data: {
                              labels : area,
                              datasets: [{
                                data: porcentaje,
                                backgroundColor: color,
                                borderColor: color,
                                borderWidth: 1
                              },
                              
                            ]
                            
                            },
                            options: {
                              responsive: true,
                              scales: {
                                y: {
                                  beginAtZero: true
                                }
                              }
                            }
                          });
                          </script>
              
                        </div>
                      
                      </div>
                      </div>
                    </div>  

                  </div>
                </div>
            </section>
          </article>
        </section>
      
      <section class="col-md-12">
          <article class="col-sm-12 col-md-12 col-lg-12 contArticle">
              <section class="col-sm-12 col-md-12 col-lg-12 p-md">
                  <span class="line-circle-a text-center font-bold tips" title="Inicio"><i class="fa fa-calendar s-16"></i></span>
              </section>
          
          </article>
      </section>

    </div>
    
  </main>	
  
@stop