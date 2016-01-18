@extends ('layouts.dashboard')
@section('page_heading','Sections')

@section('section')
<div class="col-sm-12">
<div class="row">
    <div class="col-lg-6">
        @if ($errors->any())
            <ul>
            {{ implode('', $errors->all('<div class="alert alert-danger fade in"> <a href="#" class="close" data-dismiss="alert">&times;</a><strong>Error!</strong> :message</div>')) }}
            </ul>
        @endif
        @if (Session::has('message'))
            <div class="alert alert-success fade in"> <a href="#" class="close" data-dismiss="alert">&times;</a><strong>Success!</strong> {{ Session::get('message') }}</div>
        @endif
        <form role="form" method="post" action="addSection">
            <div class="form-group">
                <label>Name of Section</label>
                <input class="form-control" name="name_of_section" id="name_of_section">
            </div>
             <div class="form-group">
                <label>Sub Section</label>
                <select class="form-control" id="sub_section" name="sub_section">
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
                <label>Shortname</label>
                <input class="form-control" placeholder="Enter text" name="shortname" id="shortname">
                 <span class="btn-warning btn-circle" style="cursor:pointer" id="generate">Generate Shortname</span>
            </div>
            
            <button type="submit" class="btn btn-success">Create section</button>
            <button type="reset" class="btn btn-danger">Reset</button>
        </form>
    </div>
    
</div>
</div>
{{ HTML::script('assets/scripts/jquery.min.js'); }}
{{ HTML::script('assets/scripts/bootstrap.min.js'); }}
<script type="text/javascript">
    $(document).ready(function() {
    $("#generate").click(function () {
    var lower = $('input#name_of_section').val().toLowerCase(); // to lower case
    var hyp = lower.replace(/ /g,"_");         
    $("#shortname").val(hyp);
});
    });
</script>
@stop