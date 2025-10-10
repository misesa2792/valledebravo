<table width="100%" class="my-table" >
    <tr>
        <th class="text-center">ELABORÓ (DEP. GENERAL)</th> 
        <th class="text-center">REVISÓ (TITULAR DE UIPPE O EQUIVALENTE)</th> 
        <th class="text-center">AUTORIZÓ (ENCARGADA DEL DESPACHO DE LA TESORERÍA MUNICIPAL)</th> 
    </tr>
    <tr>
        <td width="33%" class="text-center">
            <br>    
            <br>
            <br>
            <br>
            <div>{{ $request['txt_dep_gen'] }}</div>
            <div>NOMBRE Y FIRMA</div>    
        </td> 
        <td width="33%" class="text-center">
            <br>    
            <br>
            <br>
            <br>
            <div>{{ $request['txt_uippe'] }}</div>
            <div>NOMBRE Y FIRMA</div>    
        </td>  
        <td width="33%" class="text-center">
            <br>    
            <br>
            <br>
            <br>
            <div>{{ $request['txt_tesorero'] }}</div>
            <div>NOMBRE Y FIRMA</div>    
        </td>                     
    </tr>
</table>