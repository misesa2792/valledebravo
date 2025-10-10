<section class="row">
    <script type="text/javascript" src="{{ asset('mass/js/plugins/chartjs/chartv3.8.2.min.js') }}"></script>

    <article class="col-sm-12 col-md-12 col-lg-12 no-padding">
        <div class="col-sm-12 col-md-5 col-lg-5">

                <div class="sbox animated fadeInRight border-l-pink b-r-5">
                    <div class="sbox-title"> <h3> <i class="fa fa-table"></i> Reporte de Avance de Metas</h3></div>
                    <div class="sbox-content"> 	
        
                        <div class="col-md-12 text-center">
                       
                            <table class="table">
                                <tr class="t-tr-s16">
                                    <td class="bg-white no-borders">{{ $row->area }}</td>
                                </tr>
                                <tr class="t-tr-s16">
                                    <td class="pro_desc bg-white no-borders">{{ $rows->pro_desc }}</td>
                                </tr>
                            </table>
                            
                        </div>
        
                        <div style="clear:both"></div>	
                    </div>
                </div>		 
            
        </div>
        <div class="col-sm-12 col-md-7 col-lg-7 no-padding">
            <table class="table table-bordered bg-white">
                <tr>
                    <th colspan="3" class="text-center s-16 c-text border-t-app">Identificador</th>
                </tr>
                <tr class="t-tr-s16">
                    <td class="text-right c-text-alt">Finalidad:</td>
                    <td class="bg-white c-text-alt">{{ $rows->fin_numero }}</td>
                    <td id="fin_desc" class="bg-white" width="60%">{{ $rows->fin_desc }}</td>
                </tr>
                <tr class="t-tr-s16">
                    <td class="text-right c-text-alt">Función:</td>
                    <td class="bg-white c-text-alt">{{ $rows->fun_numero }}</td>
                    <td id="fun_desc" class="bg-white">{{ $rows->fun_desc }}</td>
                </tr>
                <tr class="t-tr-s16">
                    <td class="text-right c-text-alt">Subfunción:</td>
                    <td class="bg-white c-text-alt">{{ $rows->sub_numero }}</td>
                    <td id="sub_desc" class="bg-white">{{ $rows->sub_desc }}</td>
                </tr>
                <tr class="t-tr-s16">
                    <td class="text-right c-text-alt">Programa:</td>
                    <td class="bg-white c-text-alt">{{ $rows->pro_numero }}</td>
                    <td class="pro_desc bg-white">{{ $rows->pro_desc }}</td>
                </tr>
                <tr class="t-tr-s16">
                    <td class="text-right c-text-alt">Subprograma:</td>
                    <td class="bg-white c-text-alt">{{ $rows->subp_numero }}</td>
                    <td id="subp_desc" class="bg-white">{{ $rows->subp_desc }}</td>
                </tr>
                <tr class="t-tr-s16">
                    <td class="text-right c-text-alt">Proyecto:</td>
                    <td class="bg-white c-text-alt">{{ $rows->proy_no }}</td>
                    <th id="proy_desc" class="bg-white c-primary-alt">{{ $rows->proy_desc }}</th>
                </tr>
                <tr class="t-tr-s16">
                    <td class="text-right c-text-alt">Dependencia General:</td>
                    <td class="bg-white c-text-alt">{{ $row->numero }}</td>
                    <td class="bg-white">{{ $row->area }}</td>
                </tr>
                <tr class="t-tr-s16">
                    <td class="text-right c-text-alt">Dependencia Auxiliar:</td>
                    <td class="bg-white c-text-alt">{{ $row->no_coord }}</td>
                    <td class="bg-white">{{ $row->coordinacion }}</td>
                </tr>
            </table>
        </div>
    </article>

    <div class="panel-group accordion s-16" id="accordion">
        @foreach ($info as $key => $v)
            <div class="panel panel-default">
            <div class="panel-heading  bg-white">
                <h4 class="panel-title c-primary">
                    <a data-toggle="collapse" data-parent="#accordion" href="#{{ $v->idreporte_reg }}">{{ $v->no_accion }} - {{ $v->descripcion }}</a>
                </h4>
            </div>
            <div id="{{ $v->idreporte_reg }}" class="panel-collapse collapse {{ $key == 0 ? 'in' : '' }}">
            <div class="panel-body bg-white text-center">

                <div class="row">
                    

                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <table class="table table-bordered">
                            <tr class="t-tr-s16">
                                <td></td>
                                <td width="100" class="text-center c-white bg-yellow-meta">1</td>
                                <td width="100" class="text-center c-white bg-green-meta">2</td>
                                <td width="100" class="text-center c-white bg-blue-meta">3</td>
                                <td width="100" class="text-center c-white bg-red-meta">4</td>
                                <td width="100" class="text-center">TOTAL</td>
                            </tr>
                            <tr class="t-tr-s16">
                                <td>Programado Anual</td>
                                <td>{{ $v->trim_1 }}</td>
                                <td>{{ $v->trim_2 }}</td>
                                <td>{{ $v->trim_3 }}</td>
                                <td>{{ $v->trim_4 }}</td>
                                <td>{{ $v->prog_anual }}</td>
                            </tr>
                            <tr class="t-tr-s16">
                                <td>Realizado</td>
                                <td>{{ $v->cant_1 }}</td>
                                <td>{{ $v->cant_2 }}</td>
                                <td>{{ $v->cant_3 }}</td>
                                <td>{{ $v->cant_4 }}</td>
                                <td>{{ $v->total_realizado }}</td>
                            </tr>
                            <tr class="t-tr-s16">
                                <td>Porcentaje</td>
                                <td>{{ number_format($v->por_1,2) }}%</td>
                                <td>{{ number_format($v->por_2,2) }}%</td>
                                <td>{{ number_format($v->por_3,2) }}%</td>
                                <td>{{ number_format($v->por_4,2) }}%</td>
                                <td>{{ number_format($v->total_porcentaje,2) }}%</td>
                            </tr>
                           </table>
                           <table class="table table-bordered">
                                <tr class="t-tr-s16">
                                    <th class="text-center">Trimestre</th>
                                    <th class="text-center">Inicial</th>
                                    <th class="text-center">Avance</th>
                                    <th class="text-center">Modificado</th>
                                </tr>
                                <tr class="t-tr-s16">
                                    <td>1</td>
                                    <td>{{ $v->inicial_1 }}</td>
                                    <td>{{ $v->avance_1 }}</td>
                                    <td>{{ $v->mod_1 }}</td>
                                </tr>
                                <tr class="t-tr-s16">
                                    <td>2</td>
                                    <td>{{ $v->inicial_2 }}</td>
                                    <td>{{ $v->avance_2 }}</td>
                                    <td>{{ $v->mod_2 }}</td>
                                </tr>
                                <tr class="t-tr-s16">
                                    <td>3</td>
                                    <td>{{ $v->inicial_3 }}</td>
                                    <td>{{ $v->avance_3 }}</td>
                                    <td>{{ $v->mod_3 }}</td>
                                </tr>
                                <tr class="t-tr-s16">
                                    <td>4</td>
                                    <td>{{ $v->inicial_4 }}</td>
                                    <td>{{ $v->avance_4 }}</td>
                                    <td>{{ $v->mod_4 }}</td>
                                </tr>
                        </table>

                    </div>
                   
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <canvas id="myChart_{{ $v->idreporte_reg }}" style="height:250px;"></canvas>
                        <script>
                        const ctx = document.getElementById('myChart_{{ $v->idreporte_reg }}').getContext('2d');
                        const myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['Trim #1','Realizado', 'Trim #2','Realizado', 'Trim #3','Realizado','Trim #4','Realizado'],
                                datasets: [{
                                    data: ["{{ $v->trim_1 }}", "{{ $v->cant_1 }}","{{ $v->trim_2 }}", "{{ $v->cant_2 }}","{{ $v->trim_3 }}", "{{ $v->cant_3 }}", "{{ $v->trim_4 }}","{{ $v->cant_4 }}"],
                                    backgroundColor: [
                                        'rgba(255, 192, 0,0.5)',
                                        'rgba(232, 29, 117,0.6)',
                                        'rgba(146, 208, 80,0.5)',
                                        'rgba(232, 29, 117,0.6)',
                                        'rgba(156, 194, 229,0.5)',
                                        'rgba(232, 29, 117,0.6)',
                                        'rgba(223, 107, 81,0.5)',
                                        'rgba(232, 29, 117,0.6)',
                                    ],
                                    borderColor: [
                                        'rgba(255, 192, 0,1)',
                                        '#E81D75',
                                        'rgba(146, 208, 80,1)',
                                        '#E81D75',
                                        'rgba(156, 194, 229,1)',
                                        '#E81D75',
                                        'rgba(223, 107, 81,1)',
                                        '#E81D75',
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
                        </script>
                    </div>

                    <div class="col-sm-4 col-md-4 col-lg-4 text-center">
                        <canvas class="text-center" id="Pie_{{ $v->idreporte_reg }}"></canvas>
                        <script>
                            const ctx = document.getElementById('Pie_{{ $v->idreporte_reg }}').getContext('2d');
                            ctx.canvas.parentNode.style.height = '300px';
                            ctx.canvas.parentNode.style.width = '300px';
                            const myChart = new Chart(ctx, {
                                type: 'pie',
                                data: {
                                    labels: ['Porcentaje Faltante','Porcentaje Realizado'],
                                    datasets: [{
                                        data: ["{{ $v->porcentaje_restante }}", "{{ $v->total_porcentaje }}"],
                                        backgroundColor: [
                                            'rgba(255, 192, 0,0.5)',
                                            'rgba(232, 29, 117,0.7)',
                                        ],
                                        borderColor: [
                                            'rgba(255, 192, 0,1)',
                                            '#E81D75',
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
                            </script>
                    </div>


                </div>
              
            </div>
            </div>
            </div>
        @endforeach
      
    </div>
    
</section>