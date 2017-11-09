<h2 class="page-header">Edit Product</h2>
{!! Form::model($product,["id"=>"frm","class"=>"form-horizontal"]) !!}
@include("product._form")
{!! Form::close() !!}