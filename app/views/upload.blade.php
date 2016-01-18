@extends('layouts.dashboard')
@section('page_heading','Uploads')

@section('section')
<div class="col-sm-14">

<div class="row">
	<div class="col-sm-14">
		@section ('cotable_panel_title','Uploads')
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
		<table class="table table-bordered" id="dataTables-example">
			<thead>
				<tr>
					<th>Section</th>
					<th>Sub Section</th>
					<th>Shortname</th>
					<th>Upload Status</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			  @foreach($sections as $section)
				<tr>
					<td>{{$section->name_of_section}}</td>
					<td>{{$section->sub_section}}</td>
					<td>{{$section->shortname}}</td>
					@if($section->upload_status=='') 
						<td><a href=""><button type="button" class="btn btn-warning btn-circle upload" id="{{$section->id}}"><i class="fa fa-upload"></i></button></td>
  					@else
  						<td>{{$section->upload_status}}</td>
					@endif
					<td>
					<a href=""><button type="button" class="btn btn-danger btn-circle delete" id="{{$section->id}}"><i class="fa fa-trash" ></i></button></a>
					<a href="editSection?id={{$section->id}}"><button type="button" class="btn btn-warning btn-circle edit" id="{{$section->id}}"><i class="fa fa-pencil"></i></button></a>
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
<script type="text/javascript"> 
 $(document).ready(function(){
        
 $('.upload').click(function() {
        id = $(this).attr('id'); // table row ID 
        $.ajax({
                url: 'uploadFiles',
                type: 'GET',
                data: {id:id},
                success: function(response)
                {
                  //console.log(response);
                }
            });
       });

 $('.delete').click(function() {
        id = $(this).attr('id'); // table row ID 
      // alert(id);
        $.ajax({
                url: 'deleteSection',
                type: 'GET',
                data: {id:id},
                success: function(response)
                {
                  console.log(response);
                }
            });
       });

 /*$('.edit').click(function() {
        id = $(this).attr('id'); // table row ID 
        alert(id);
        $.ajax({
                url: 'editSection',
                type: 'GET',
                data: {id:id},
                success: function(response)
                {
                  console.log(response);
                }
            });
       });*/
      });
</script>
@stop