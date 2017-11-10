<h2 class="page-header">New Product</h2>
{!! Form::open(["id"=>"frm","class"=>"form-horizontal"]) !!}
@include("product._form")
{!! Form::close() !!}
<!-- 

<div class="container-fluid">
	<form action="{{route('')}}" id="frm" class="form-horizontal">
		@include("product._form")
	</form>
</div> -->