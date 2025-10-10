<tr id="tr_{{ $time }}">
   <td class="bg-white">
    <input type="hidden" name="idr[]" value="0">
    <input type="text" name="desc[]" class="form-control no-borders form-control-ses" placeholder="DESCRIPCIÓN Y CARACTERÍSTICAS DEL (OS)  BIEN (ES)" required>
   </td>
   <td class="bg-white">
    <input type="text" name="unidad[]" class="form-control no-borders form-control-ses" placeholder="UNIDAD DE MEDIDA" required>
   </td>
   <td class="bg-white">
    <input type="text" name="cantidad[]" class="form-control no-borders form-control-ses" placeholder="CANTIDAD SOLICITADA" id="cantidad{{ $time }}" onKeyUp="totalImporte({{ $time }})" required>
   </td>
   <td class="bg-white">
    <input type="text" name="costo[]" class="form-control no-borders form-control-ses" placeholder="COSTO UNITARIO" id="costo{{ $time }}" onKeyUp="totalImporte({{ $time }})" required>
   </td>
   <td></td>
   <td class="bg-white">
    <input type="text" name="importe[]" class="form-control no-borders form-control-ses" placeholder="IMPORTE" id="importe{{ $time }}" onKeyUp="totalImporte({{ $time }})" readonly required>
   </td>
   <td class="text-center no-borders">
        <i class="fa fa-trash-o c-danger cursor btndestroy s-16" id="{{ $time }}"></i>
    </td>
</tr>
