<table width="100%" class="my-table" >
    <tr>
        <th class="text-center">Solicitó</th> 
        <th class="text-center">Vo. Bo.</th> 
        <th class="text-center">Autorizó</th> 
    </tr>
    <tr>
        <td width="33%" class="text-center">
            <br>    
            <br>
            <br>
            <br>
            <div>{{ $request['txt_secretario'] }}</div>
            <div>SECRETARIO DEL AYUNTAMIENTO</div>    
        </td> 
        <td width="33%" class="text-center">
            <br>    
            <br>
            <br>
            <br>
            <div>{{ $request['txt_uippe'] }}</div>
            <div>TITULAR DE LA UIPPE</div>    
        </td>  
        <td width="33%" class="text-center">
            <br>    
            <br>
            <br>
            <br>
            <div>{{ $request['txt_tesorero'] }}</div>
            <div>TESORERO MUNICIPAL</div>    
        </td>                     
    </tr>

    <tr>
        <td width="33%" class="text-center">
            <br>    
            <br>
            <br>
            <br>
            <div>{{ $request['txt_programacion'] }}</div>
            <div>JEFE DEL DEPTO. DE PROGRAMACIÓN Y CONTROL PRESUPUESTAL</div>    
        </td> 
        <td width="33%" class="blanco"></td>  
        <td width="33%" class="text-center">
            <br>    
            <br>
            <br>
            <br>
            <div>{{ $request['txt_egresos'] }}</div>
            <div>DIRECTOR DE EGRESOS</div>    
        </td>                     
    </tr>

</table>