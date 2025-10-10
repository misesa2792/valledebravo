	<div class="table-footer">
	<div class="row">
	 <div class="col-xs-12 col-sm-5" style="margin-top:20px;">
	  <div class="table-actions" >
	 
	   {!! Form::open(array('url'=>$pageModule.'/filter?return='.$return)) !!}
		   {{--*/ $pages = array(5,10,20,30,50) /*--}}
		   {{--*/ $orders = array('asc','desc') /*--}}
		
		
		<button type="submit" class="btn btn-primary btn-sm">GO</button>	
		<input type="hidden" name="md" value="{{ (isset($masterdetail['filtermd']) ? $masterdetail['filtermd'] : '') }}" />
	  {!! Form::close() !!}
	  </div>					
	  </div>
	   <div class="col-xs-12 col-sm-2" style="margin-top:20px;">
		<p class="text-center" >
		Total : <b>{{ $pagination->total() }}</b>
		</p>		
	   </div>
		<div class="col-xs-12 col-sm-5 text-right">			 
	  {!! $pagination->appends($pager)->render() !!}
	  </div>
	  </div>
	</div>	
	
	