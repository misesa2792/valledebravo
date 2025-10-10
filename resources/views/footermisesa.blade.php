<div class="col-md-12" style="padding-right:0px;">
	<div class="col-xs-12 col-md-6 text-center m-t-xs s-16 c-text">
		Total : <span class="fun">{{ $pagination->total() }}</span>
	</div>
	<div class="col-xs-12 col-sm-6 text-right" style="padding-right: 0px;">
	{!! str_replace('/?', '?',$pagination->render()) !!}
	</div>
</div>
