<section class="table-resp">
    <div class="col-md-12">

		<div class="col-md-12 m-t-md">
			<label for="Descripcion" class=" control-label col-md-3 text-left s-16 c-text-alt"> Fecha Inicio: </label>
			<div class="col-md-9">
				{!! Form::text('fecha', $row['fecha_inicio'],array('class'=>'form-control', 'placeholder'=>'0000-00-00', 'required','readonly')) !!}
			</div>
		</div>

		<div class="col-md-12 m-t-md">
			<label for="Descripcion" class=" control-label col-md-3 text-left s-16 c-text-alt"> Fecha Fin: </label>
			<div class="col-md-9">
				{!! Form::text('fecha', $row['fecha_fin'],array('class'=>'form-control', 'placeholder'=>'0000-00-00', 'required','readonly')) !!}
			</div>
		</div> 

		<div class="col-md-12 m-t-md">
			<label for="Descripcion" class=" control-label col-md-3 text-left s-16 c-text-alt"> Titulo del evento: </label>
			<div class="col-md-9">
				{!! Form::text('evento', $row['evento'],array('class'=>'form-control', 'placeholder'=>'Ingresa título', 'required','readonly')) !!}
			</div>
		</div>
		
		<div class="col-md-12 m-t-md">
			<label for="Descripcion" class=" control-label col-md-3 text-left s-16 c-text-alt"> Descripción del evento: </label>
			<div class="col-md-9">
				{!! Form::textarea('descripcion', $row['descripcion'],array('class'=>'form-control', 'placeholder'=>'Ingresa descripción','readonly' )) !!}
			</div>
		</div> 


		@if(Auth::user()->group_id ==1 || Auth::user()->group_id == 2)
			<article class="col-sm-12 col-md-12 text-left m-t-md m-b-md">
				<button type="button" name="save" class="btn btn-danger btn-sm btn btneliminar"><i class="fa fa-trash-o"></i> Eliminar</button>
			</article>
		@endif
    </div>
</section>

<script>

	$(".btneliminar").click(function(e){
		e.preventDefault();
		swal({
        title : 'Estás seguro de eliminar el evento?',
        icon : 'warning',
        buttons : true,
        dangerMode : true
        }).then((willDelete) => {
            if(willDelete){
               	axios.delete("{{ URL::to('calendario/evento') }}",{
					params : {id: "{{ $id }}"}
				}).then(response =>{
					var res = response.data;
					toastr.success(row.message);
					calendar.fullCalendar('refetchEvents');
				}).catch(error => {
					toastr.error("Error, vuelve a intentar!");
                    $("#sximo-modal").modal("toggle");
		            calendar.refetchEvents();
				})
            }
        })
	})
</script>