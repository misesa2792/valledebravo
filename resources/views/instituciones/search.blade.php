{{--*/ 
    $row = json_decode($rows);
/*--}}

@if(count($row) > 0)
@foreach ($row as $v)
<div class="col-md-12">
  <article class="col-sm-12 col-md-12 col-lg-12 contArticle">
          
      <section class="col-sm-2 col-md-2 col-lg-2 f-bold text-right line-fecha">
        <div class="col-md-12 s-16">
            {{ $v->municipio }}
        </div>
        <div class="col-md-12 s-16">
          {{ $v->no_municipio }}
      </div>
      </section>

      <section class="col-sm-10 col-md-10 col-lg-10 @if($v->estatus == 1) b-line-s @else b-line-r @endif p-md">

          <span class="@if($v->estatus == 1) line-circle-s @else line-circle-r @endif text-center font-bold tips ">
            <i class="fa fa-plus-circle s-20 cursor btnagregar" id="{{ $v->id }}"></i>
          </span>
      
          <div class="col-sm-12 col-md-12 col-lg-12 bg-white b-r-10 p-xs b-r-c" id="line-comm" >
              <article class="col-sm-12 col-md-12 col-lg-12 text-justify line-texto no-padding">

                @if(count($v->rowsInstituciones) > 0)
                  <table class="table no-margins border-gray table-hover">
                      @foreach ($v->rowsInstituciones as $aux)
                        <tr class="t-tr-s14">
                          <td class="text-center" width="40">
                              <i class="@if($aux->active == 1) fa fa-unlock c-success @else fa fa-lock c-danger @endif s-16  tips" id="{{ $aux->id }}" title="Estatus"> </i>
                          </td>
                          <td width="40" class="text-right">{{ $aux->no_institucion }}</td>
                          <td>{{ $aux->institucion }}</td>
                          <td width="30">
							              <a  href="{{ URL::to('instituciones/years/'.$aux->id) }}" class="tips btn btn-xs btn-white" title="Configuración"><i class="fa fa-sitemap fun"></i></a>
                          </td>
                          <td width="30">
							              <a  href="{{ URL::to('instituciones/module/'.$aux->id) }}" class="tips btn btn-xs btn-white" title="Permisos por año Ya no Usar"><i class="fa fa-calendar c-yellow"></i></a>
                          </td>
                          <td width="30">
							              <a  href="{{ URL::to('instituciones/newmodule/'.$aux->id) }}" class="tips btn btn-xs btn-white" title="Permisos por año"><i class="fa fa-calendar c-green"></i></a>
                          </td>
                          <td width="30">
							              <a  href="{{ URL::to('instituciones/users?id='.$aux->id.'&idtd='.$aux->idtp) }}" class="tips btn btn-xs btn-white" title="Usuarios"><i class="fa fa-users c-danger"></i></a>
                          </td>
                        </tr>
                      @endforeach
                  </table>
                @else 
                  <div class="col-md-12 p-xs">
                    <div class="text-center c-text-alt s-16">No se encontraron Registros!</div>
                  </div>
                @endif
              </article>
          </div>
      </section>
      
  </article>
</div>
@endforeach

<div class="col-md-12 no-padding">
    @include('footermisesa')
</div>


<script>
  	$(".tips").tooltip();
   $(".btnagregar").click(function(e){
        e.preventDefault();
        modalMisesa("{{ URL::to($pageModule.'/update') }}",{idm:$(this).attr("id")}, "Agregar Organismo",'50%');
    })
</script>

@else

<div class="col-md-12 m-t-lg">
    <h1 class="text-center com"> <i class="fa  fa-folder-open-o s-40"></i> </h1>
    <h2 class="text-center com">No se encontraron Registros!</h2>
</div>

@endif
