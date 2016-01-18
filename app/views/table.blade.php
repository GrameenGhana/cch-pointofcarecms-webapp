@extends('layouts.dashboard')
@section('page_heading','Pages')

@section('section')
<div class="col-sm-14">

<div class="row">
	<div class="col-sm-14">
		@section ('cotable_panel_title','Pages')
		@section ('cotable_panel_body')
		  @if ($errors->any())
            <ul>
            {{ implode('', $errors->all('<div class="alert alert-danger fade in"> <a href="#" class="close" data-dismiss="alert">&times;</a><strong>Error!</strong> :message</div>')) }}
            </ul>
        @endif
        @if (Session::has('message'))
            <div class="alert alert-success fade in"> <a href="#" class="close" data-dismiss="alert">&times;</a><strong>Success!</strong> {{ Session::get('message') }}</div>
        @endif
        <div class="dataTable_wrapper"> 
		<table class="table table-striped table-bordered"  id="dataTables-example">
			<thead>
				<tr>
					<th>Page Desc</th>
					<th>Page Section</th>
					<th>Page Shortname</th>
					<th>Page Type</th>
					<th>Page Subtitle</th>
					<th>Status</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			  @foreach($pages as $page)
				<tr>
					<td>{{$page->page_name}}</td>
					<td>{{$page->page_section}}</td>
					<td>{{$page->page_shortname}}</td>
					<td>{{$page->type_of_page}}</td>
					<td>{{$page->page_subtitle}}</td>
					@if(file_exists($page->page_url)) 
						<td><span class="btn btn-success btn-circle"><i class="fa fa-check"></i></span></td>
  					@else
  						<td><span class="btn btn-danger btn-circle"><i class="fa fa-times"></i></span></td>
					@endif
					<td>
					<a href="delete?id={{$page->id}}"><button type="button" class="btn btn-danger btn-circle delete"><i class="fa fa-trash"></i></button></a>
					<a href="edit?id={{$page->id}}"><button type="button" class="btn btn-warning btn-circle" id="{{$page->id}}"><i class="fa fa-pencil"></i></button></a>
					</td>
				</tr>
				 @endforeach
				
			</tbody>
		</table>	
		</div>
		@endsection
		@include('widgets.panel', array('header'=>true, 'as'=>'cotable'))
	</div>
</div>
</div>
{{ HTML::script('assets/scripts/jquery.min.js'); }}
{{ HTML::script('assets/scripts/bower_components/datatables/media/js/jquery.dataTables.min.js'); }}
{{ HTML::script('assets/scripts/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js'); }}
<script type="text/javascript" charset="utf8">
   // $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true,
                 paging: true
 //       });
    });
    </script>
<!--<script src="{{ asset("assets/scripts/jquery.min.js") }}" type="text/javascript"></script>-->

<script type="text/javascript"> 
 $(document).ready(function(){
        
 $('.edit').click(function() {
        id = $(this).attr('id'); // table row ID 
        $.ajax({
                url: 'edit',
                type: 'GET',
                data: {id:id},
                success: function(response)
                {
                  console.log(response);
                }
            });
       });
      });
</script>

 
@stop