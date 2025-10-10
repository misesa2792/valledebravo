<tr id="tr_{{ $time }}">
   <td class="bg-white" colspan="2">
    <input type="hidden" name="idr[]" value="0">
    <input type="text" name="desc[]" class="form-control no-borders form-control-ses" placeholder="DESCRIPCIÓN Y CARACTERÍSTICAS DEL (OS)  BIEN (ES)" required>
   </td>
   <td></td>
   <td class="bg-white">
    <input type="text" name="importe[]" class="form-control no-borders form-control-ses" placeholder="IMPORTE" id="importe{{ $time }}" onKeyUp="totalImporte({{ $time }})" required>
   </td>
   <td class="text-center no-borders">
        <script>
            $(".mySelect{{ $time }}").select2();
        </script>
        <i class="fa fa-trash-o c-danger cursor btndestroy s-16" id="{{ $time }}"></i>
    </td>
</tr>
