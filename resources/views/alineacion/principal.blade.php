<section class="table-resp m-b-lg" style="min-height:300px;">
    <article class="col-sm-12 col-md-12 col-lg-12 m-t-md">
		@foreach (json_decode($rows_pilares) as $v)
			@foreach ($v->rows_anios as $a)
			@if($a->anio == 2023)
				<section class="col-sm-2 col-md-2 col-lg-2 f-bold text-center v">
					<div class="col-sm-12 col-md-12 col-lg-12 m-b-md">
					<div class="bg-white p-xs b-r-10 border-gray full-width s-16">{{ $v->periodo }}</div>
					</div>
				</section>
		
				<section class="col-sm-10 col-md-10 col-lg-10 b-line-y p-md">
					<span class="line-circle-y text-center font-bold tips" title="{{ $a->anio }}">{{ $a->anio }}</span>
				
					<div class="col-sm-12 col-md-12 col-lg-12 bg-white box-shadow b-r-10 p-md b-r-c" id="line-comm" >
						<div class="col-sm-12 col-md-12 col-lg-12 text-justify line-texto s-12 b-b-gray p-xs com">
							<div class="col-sm-10 col-md-10 col-lg-10 s-16">Alineación de Metas</div>
							<div class="col-sm-2 col-md-2 col-lg-2 text-right">
								<a href="{{ URL::to($pageModule.'/exportar?k='.SiteHelpers::CF_encode_json(array('idi'=>$idi,'anio'=>$a->anio,'idanio'=>$a->idanio, 'idperiodo'=>$v->idperiodo))) }}" class="btn btn-xs btn-white b-r-30" target="_blank"><i class="fa icon-file-excel lit"></i> Exportar</a>
								<a href="{{ URL::to($pageModule.'/pdf?k='.SiteHelpers::CF_encode_json(array('idi'=>$idi,'anio'=>$a->anio,'idanio'=>$a->idanio, 'idperiodo'=>$v->idperiodo))) }}" class="btn btn-xs btn-white b-r-30" target="_blank"><i class="fa icon-file-excel lit"></i> Exportar</a>
							</div>
						</div>
				
						<div class="col-sm-12 col-md-12 col-lg-12 m-t-md text-justify line-texto no-padding" >
							@foreach ($v->rows_pilares as $row)
									<a  href="{{ URL::to($pageModule.'/pdm?k='.SiteHelpers::CF_encode_json(array('idi'=>$idi,'anio'=>$a->anio,'idanio'=>$a->idanio, 'idperiodo'=>$v->idperiodo, 'idpilar'=>$row->idpdm_pilares)) ) }}" class="bg-hover-gray p-sm col-sm-12 col-md-12 col-lg-12 p-xs c-text-alt s-16" title="Abrir">
										<div class="col-md-9 c-text">{{ $row->pilares }}</div>
										<div class="col-md-2 c-text">{{ $row->tipo }}</div>
										<div class="col-md-1 text-right"><i class="fa icon-arrow-right5 cursor s-20"  style="color: var({{ $row->color }});"></i></div>
									</a>
							@endforeach
						</div>
					</div>
				</section>
			@endif
			@endforeach
		@endforeach
    </article>
</section>
