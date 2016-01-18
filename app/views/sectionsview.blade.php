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
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Section</th>
					<th>Sub Section</th>
					<th>Shortname</th>
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
				</tr>
				 @endforeach
				
			</tbody>
		</table>	
		<?php echo $sections->links(); ?>
		@endsection
		@include('widgets.panel', array('header'=>true, 'as'=>'cotable'))
	</div>
</div>
</div>
{{ HTML::script('assets/scripts/jquery.min.js'); }}

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
      });
</script>
@stop