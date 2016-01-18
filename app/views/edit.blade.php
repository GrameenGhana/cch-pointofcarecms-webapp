@extends ('layouts.dashboard')
@section('page_heading','Pages')

@section('section')
<div class="row">
{{ Form::open(array('url'=> 'addPage','method'=>'post','files'=>true)) }}
<div class="col-md-6">
   @if ($errors->any())
            <ul>
            {{ implode('', $errors->all('<div class="alert alert-danger fade in"> <a href="#" class="close" data-dismiss="alert">&times;</a><strong>Error!</strong> :message</div>')) }}
            </ul>
        @endif
        @if (Session::has('message'))
            <div class="alert alert-success fade in"> <a href="#" class="close" data-dismiss="alert">&times;</a><strong>Success!</strong> {{ Session::get('message') }}</div>
        @endif
        <div class="box box-primary">
            <div class="box-body">
                <fieldset><legend>Default Page Details</legend>   
                  <div class="form-group">
                <label>Page Section</label>
                 {{ Form::select('page_section',[null=>'Select']+$sections,'',array('class'=>'form-control','id' => 'page_section'))}}   
                <p class="help-block">Required**</p>
            </div>
            <div class="form-group">
                <label>Page Description</label>
                <input class="form-control" name="page_description" id="page_description">
                <p class="help-block">Provide page name after ">"**</p>
            </div>
             <div class="form-group">
                <label>Page Name</label>
                <input class="form-control" name="page_name" id="page_name">
                <p class="help-block">Enter a name for the page eg. 'Difficulty Breathing'**</p>
            </div>
             <div class="form-group">
                <label>Page Shortname</label>
                <input class="form-control" name="page_shortname" id="page_shortname">
                <span class="btn-warning btn-circle" style="cursor:pointer" id="generate">Generate Shortname</span>
            </div>
            <div class="form-group">
                <label>Page Title</label>
                <select class="form-control" id="page_title" name="page_title">
                <option>Select</option>
                    <option>Point of Care</option>
                </select>
             
            </div>
            <div class="form-group">
                <label>Page Subtitle</label>
                <select class="form-control" id="page_subtitle" name="page_subtitle">
                <option>Select</option>
                    <option>ANC Diagnostic</option>
                    <option>ANC Counselling</option>
                    <option>PNC Diagnostic</option>
                    <option>PNC Counselling</option>
                    <option>CWC Diagnostic</option>
                    <option>CWC Counselling</option>
                    <option>CWC References</option>
                    <option>CWC Calculators</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Page Type</label>
                <select class="form-control" id="type_of_page" name="type_of_page">
                <option>Select</option>
                    <option>Take Action Page</option>
                    <option>Take Action Classification Page</option>
                    <option>Question Page</option>
                    <option>Info Page</option>
                    <option>Reference Page</option>
                    <option>Calculator Page</option>
                </select>
            </div>
            <div class="form-group" id="emergency_level" >
                <label>Emergency Level (For take action pages only)</label>
                <select class="form-control" name="color_code">]
                <option>Select</option>
                    <option>Red</option>
                    <option>Amber</option>
                    <option>Green</option>
                </select>
            </div>
        
            <!-- Modals-->
            <button type="submit" class="btn btn-success">Create Page</button>
            <button type="reset" class="btn btn-danger">Reset</button>  
                </fieldset>
            </div>
        </div>
    </div>
{{ HTML::script('assets/scripts/jquery.min.js'); }}
{{ HTML::script('assets/scripts/bootstrap.min.js'); }}

<script type="text/javascript">
    $(document).ready(function() {
    $("#page_section").change(function () {
      var id=$('#page_section option:selected').text();
    $("#page_description").val(id+"> ");
});
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
    $("#generate").click(function () {
    var lower = $('input#page_name').val().toLowerCase(); // to lower case
    var hyp = lower.replace(/ /g,"_");         
    $("#page_shortname").val(hyp);

});
    });
</script>

@stop