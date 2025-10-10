<div class="table-footer">
	<div class="row m-b-lg m-t-lg">

		<div class="col-xs-12 col-sm-5" style="margin-top:20px;">
			<div class="table-actions" >
			
				{!! Form::open(array('url'=>$pageModule.'/filter?return='.$return)) !!}
					{{--*/ $pages = array(5,10,20,30,50) /*--}}
					{{--*/ $orders = array('asc','desc') /*--}}
					
					<select name="rows" data-placeholder="{{ Lang::get('core.grid_show') }}" class="select-alt"  >
					<option value=""> {{ Lang::get('core.grid_page') }} </option>
					@foreach($pages as $p)
					<option value="{{ $p }}" 
						@if(isset($pager['rows']) && $pager['rows'] == $p) 
							selected="selected"
						@endif	
					>{{ $p }}</option>
					@endforeach
					</select>

					<select name="sort" data-placeholder="{{ Lang::get('core.grid_sort') }}" class="select-alt"  >
					<option value=""> {{ Lang::get('core.grid_sort') }} </option>	 
					@foreach($tableGrid as $field)
					@if($field['view'] =='1' && $field['sortable'] =='1') 
						<option value="{{ $field['field'] }}" 
							@if(isset($pager['sort']) && $pager['sort'] == $field['field']) 
								selected="selected"
							@endif	
						>{{ $field['label'] }}</option>
						@endif	  
					@endforeach
					
					</select>	
					<select name="order" data-placeholder="{{ Lang::get('core.grid_order') }}" class="select-alt">
					<option value=""> {{ Lang::get('core.grid_order') }}</option>
					@foreach($orders as $o)
					<option value="{{ $o }}"
						@if(isset($pager['order']) && $pager['order'] == $o)
							selected="selected"
						@endif	
					>{{ ucwords($o) }}</option>
					@endforeach
					</select>	
					<button type="submit" class="btn btn-primary btn-sm b-r-5">GO</button>	
					<input type="hidden" name="md" value="{{ (isset($masterdetail['filtermd']) ? $masterdetail['filtermd'] : '') }}" />
				{!! Form::close() !!}
			</div>
		</div>

		<div class="col-xs-12 col-sm-2" style="margin-top:20px;">
				<p class="text-center s-16">Total : <b>{{ $pagination->total() }}</b></p>		
		</div>

		<div class="col-xs-12 col-sm-5 text-right">			 
			{!! $pagination->appends($pager)->render() !!}
		</div>

	</div>
</div>	
	
	