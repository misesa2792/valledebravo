<form id="saveInfo" method="post" class="form-horizontal">

  <article class="col-md-12">

    <table class="table table-bordered bg-white">

      <tr class="t-tr-s14">

        <th width="20"></th>

        <th>Número</th>

        <th>Dependencia General</th>

      </tr>

			@foreach ($rows as $aux)

        <tr class="t-tr-s14">

          <td>

								<input type="checkbox" name="permiso[]" value="{{ $aux['id'] }}" @if($aux['std']) checked @endif> 

          </td>

          <td class="text-center">{{ $aux['no'] }}</td>

          <td>{{ $aux['na'] }}</td>

        </tr>

      @endforeach

    </table>

  </article>



		<article class="col-sm-12 col-md-12 text-center m-t-md m-b-md">

			<button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left "></i> Cancelar </button>

			<button type="submit" name="save" class="btn btn-primary btn-sm btnsave"><i class="fa fa-save"></i> Guardar</button>

		</article>

</form>



 <script type="text/javascript">

 function mayus(e) {

    e.value = e.value.toUpperCase();

 }

 

 $(".mySelect2").select2();

 

 $("#saveInfo").on("submit", function(e){

    e.preventDefault();

    var formData = new FormData(document.getElementById("saveInfo"));

    $.ajax("{{ URL::to('usuarios/saveaccesos?idu='.$idu) }}", {

      type: 'post',

      dataType: "html",

      data: formData,

      cache: false,

      contentType: false,

      processData: false,

      beforeSend: function(){

        $(".btnsave").prop("disabled",true).html(btnSaveSpinner);

      },success: function(res){

        let row = JSON.parse(res);

        if(row.status == 'ok'){

          $("#sximo-modal").modal("toggle");

          query();

          toastr.success(row.message);

        }else{

          toastr.error(row.message);

        }

        $(".btnsave").prop("disabled",false).html(btnSave);

      }, error : function(err){

        toastr.error(mss_tmp.error);

        $(".btnsave").prop("disabled",false).html(btnSave);

      }

	});

});

 </script>

