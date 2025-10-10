<div class="tab-container">
    <ul class="nav nav-tabs">
        <li class="{{ $active == 1 ? 'active' : 'no-active' }}"><a href="{{ URL::to('planpdf/pdf') }}"> <i class="fa icon-file-pdf s-12"></i> PDF</a></li>
        <li class="{{ $active == 2 ? 'active' : 'no-active' }}"><a href="{{ URL::to('planpdf/files') }}"> <i class="fa fa-download s-12"></i> Archivos</a></li>
        <li class="{{ $active == 3 ? 'active' : 'no-active' }}"><a href="{{ URL::to('planpdf/navigation') }}"><i class="fa icon-target s-12"></i> Navegación</a></li>
        <li class="{{ $active == 4 ? 'active' : 'no-active' }}"><a href="{{ URL::to('planpdf/users') }}"><i class="fa icon-users s-12"></i> Actividad</a></li>
    </ul>
</div>