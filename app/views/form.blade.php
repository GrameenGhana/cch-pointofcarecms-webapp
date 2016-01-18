@extends ('layouts.dashboard')
@section('page_heading','Pages')

@section('section')
<div class="row">
{{ Form::open(array('url'=> 'addPageDetails','method'=>'post','files'=>true)) }}
<input type="hidden" value="{{$page_values->id}}" name="id" id="id">
<div class="col-md-12">
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
               {{ Form::select('page_section',[null=>'Select']+$sections,$page_values->page_section,array('class'=>'form-control','id' => 'page_section'))}}   
                <p class="help-block">Required**</p>
            </div>
            <div class="form-group">
                <label>Page Description</label>
                <input class="form-control" name="page_description" id="page_description" value="{{$page_values->page_description}}">
                <p class="help-block">Provide page name after ">"**</p>
            </div>
             <div class="form-group">
                <label>Page Name</label>
                <input class="form-control" name="page_name" id="page_name" value="{{$page_values->page_name}}">
                <p class="help-block">Enter a name for the page eg. 'Difficulty Breathing'**</p>
            </div>
             <div class="form-group">
                <label>Page Shortname</label>
                <input class="form-control" name="page_shortname" id="page_shortname" value="{{$page_values->page_shortname}}">
                <span class="btn-warning btn-circle" style="cursor:pointer" id="generate">Generate Shortname</span>
            </div>
            <div class="form-group">
                <label>Page Title</label>
                 {{ Form::select('page_title',[null=>'Select']+['Point of Care'=>'Point of Care'],$page_values->page_title,array('class'=>'form-control','id' => 'page_title'))}}  
              <!--  <select class="form-control" id="page_title" name="page_title">
                <option>Select</option>
                    <option>Point of Care</option>
                </select>-->
            </div>
            <div class="form-group">
                <label>Page Subtitle</label>
                 {{ Form::select('page_subtitle',[null=>'Select']+['ANC Diagnostic'=>'ANC Diagnostic','ANC Counselling'=>'ANC Counselling','PNC Diagnostic'=>'PNC Diagnostic','PNC Counselling'=>'PNC Counselling','CWC Diagnostic'=>'CWC Diagnostic','CWC Counselling'=>'CWC Counselling','CWC References'=>'CWC References','CWC Calculators'=>'CWC Calculators'],$page_values->page_subtitle,array('class'=>'form-control','id' => 'page_subtitle'))}}   
            
            </div>
             <div class="form-group">
                <label>Referral Case</label>
               <select class="form-control" name="referral" id="referral">
                 <option>Select</option>
                    <option>No referral</option>
                    <option>Referral</option>
                </select>
                 <p class="help-block">No referral if section has no "While waiting for Transport"</p>
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
                <label>Emergency Level (For Take Action Pages)</label>
                <select class="form-control" name="color_code">]
                 <option>Select</option>
                    <option>Red</option>
                    <option>Amber</option>
                    <option>Green</option>
                </select>
            </div>
            
              <div class="form-group" id="definition" name="definition">
                <label>Definition</label>
                <textarea class="form-control" rows="3" name="definition"></textarea>
            </div>
             
            <!-- Modals-->
          
                </fieldset>
            </div>
        </div>
    </div>


     <div class="col-md-12" id="first_action">
        <div class="box box-primary">
            <div class="box-body" style="padding-top:50px">
                <fieldset><legend><strong>First Take Action Items <i class="fa fa-medkit"></i></strong></legend>   
                    <div id="first_action_container">
                        <span class="right" style="float: right;padding: 5px">
                                    <button type="button" onclick="addFirstActionItem()" title="Add New Action" class="btn btn-primary"><i class="fa fa-plus"></i>Add First Action</button>
                                </span>
                        <div id="first_action_s1">
                            <div class="row">
                                <h3>First Action 1</h3>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        {{ Form::label('header','Action Text') }}
                                        <input type="text" id="first_action_s1" name="first_action_s1" value="" class="form-control" />
                                    </div>
                                </div>
                                 <div class="col-xs-6">
                                    <div class="form-group">
                                    <div class="col-xs-3">
                                        {{ Form::label('header','Is sub item?') }}
                                        <input type="checkbox" id="first_action_sub_s1" name="first_action_sub_s1" value="yes" class="form-control"/>  
                                    </div>
                                        <div class="col-xs-3">
                                             {{ Form::label('header','Text property') }}
                                           <select class="form-control" id="first_action_property_s1" name="first_action_property_s1">
                                            <option>Select</option>
                                               <option>Bold</option>
                                               <option style="color:red">Bold Red</option>
                                               <option style="color:blue">Bold Blue</option>
                                               <option style="color:black;font-style:italic">Italic</option>
                                               <option style="color:red;font-style:italic">Italic Red</option>
                                               <option style="color:blue;font-style:italic">Italic Blue</option>
                                               <option>Underlined</option>
                                               <option style="color:red">Underlined Red</option>
                                               <option style="color:blue">Underlined Blue</option>
                                           </select>
                                        </div>
                                        
                                    </div>
                                </div>
                               
                            </div> 
                             <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                {{ Form::label('first_link_type_s1','Page Link') }}
                                                {{ Form::select('first_link_type_s1',[null=>'Select']+$pages,'',array('class'=>'form-control'))}}
                                            </div>
                                        </div>
                                         <div class="col-xs-6">
                                            <div class="form-group">
                                            <label>Image</label>
                                            <input type="file" id="first_action_image_s1" name="first_action_image_s1" class="form-control"/> 
                                        </div>
                                        </div>
                                    </div> 
                         <input type="hidden" value="1" name="first_action_sub_cnt_s1" id="first_action_sub_cnt_s1"/>                         
                        </div>
                    </div>
                </fieldset>

            </div>
        </div>
        <input type="hidden" value="1" name="first_action_cnt" id="first_action_cnt"/>

    </div>
      <div class="col-md-12" id="transport">
        <div class="box box-primary">
            <div class="box-body" style="padding-top:50px">
                <fieldset><legend><strong>While Waiting For Transport Action Items</strong><i class="fa fa-ambulance"></i></legend>   
                    <div id="transport_container">
                        <span class="right" style="float: right;padding: 5px">
                                    <button type="button" onclick="addTransportActionItem()" title="Add New Action" class="btn btn-primary"><i class="fa fa-plus"></i>Add Transport Action</button>
                                </span>
                        <div id="transport_s1">
                            <div class="row">
                                <h3>Waiting For Transport Action 1</h3>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        {{ Form::label('header','Action Text') }}
                                        <input type="text" id="transport_s1" name="transport_s1" value="" class="form-control" />
                                    </div>
                                </div>
                                 <div class="col-xs-6">
                                    <div class="form-group">
                                    <div class="col-xs-3">
                                        {{ Form::label('header','Is sub item?') }}
                                        <input type="checkbox" id="transport_sub_s1" name="transport_sub_s1" value="yes" class="form-control"/>  
                                    </div>
                                        <div class="col-xs-3">
                                             {{ Form::label('header','Text property') }}
                                           <select class="form-control" id="transport_property_s1" name="transport_property_s1">
                                            <option>Select</option>
                                               <option>Bold</option>
                                               <option style="color:red">Bold Red</option>
                                               <option style="color:blue">Bold Blue</option>
                                               <option style="color:black;font-style:italic">Italic</option>
                                               <option style="color:red;font-style:italic">Italic Red</option>
                                               <option style="color:blue;font-style:italic">Italic Blue</option>
                                               <option>Underlined</option>
                                               <option style="color:red">Underlined Red</option>
                                               <option style="color:blue">Underlined Blue</option>
                                           </select>
                                        </div>
                                        
                                    </div>
                                </div>

                            </div>      
                             <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                {{ Form::label('transport_link_type_s1','Page Link') }}
                                                {{ Form::select('transport_link_type_s1',[null=>'Select']+$pages,'',array('class'=>'form-control'))}}
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                            <label>Image</label>
                                            <input type="file" id="transport_action_image_s1" name="transport_action_image_s1" class="form-control"/> 
                                        </div>
                                        </div>
                                    </div>                      
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <input type="hidden" value="1" name="transport_cnt" id="transport_cnt"/>
    </div>
          <div class="col-md-12" id="referral_section">
        <div class="box box-primary">
            <div class="box-body" style="padding-top:50px">
                <fieldset><legend><strong>No Referral Action Items</strong><i class="fa fa-medkit"></i></legend>   
                    <div id="noreferral_container">
                        <span class="right" style="float: right;padding: 5px">
                                    <button type="button" onclick="addNoReferralActionItem()" title="Add New Action" class="btn btn-primary"><i class="fa fa-plus"></i>Add Action</button>
                                </span>
                        <div id="noreferral_s1">
                            <div class="row">
                                <h3>No Referral Action 1</h3>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        {{ Form::label('header','Action Text') }}
                                        <input type="text" id="noreferral_s1" name="noreferral_s1" value="" class="form-control" />
                                    </div>
                                </div>
                                 <div class="col-xs-6">
                                    <div class="form-group">
                                    <div class="col-xs-3">
                                        {{ Form::label('header','Is sub item?') }}
                                        <input type="checkbox" id="noreferral_sub_s1" name="noreferral_sub_s1" value="yes" class="form-control"/>  
                                    </div>
                                        <div class="col-xs-3">
                                             {{ Form::label('header','Text property') }}
                                           <select class="form-control" id="noreferral_property_s1" name="noreferral_property_s1">
                                            <option>Select</option>
                                               <option>Bold</option>
                                               <option style="color:red">Bold Red</option>
                                               <option style="color:blue">Bold Blue</option>
                                               <option style="color:black;font-style:italic">Italic</option>
                                               <option style="color:red;font-style:italic">Italic Red</option>
                                               <option style="color:blue;font-style:italic">Italic Blue</option>
                                               <option>Underlined</option>
                                               <option style="color:red">Underlined Red</option>
                                               <option style="color:blue">Underlined Blue</option>
                                           </select>
                                        </div>
                                        
                                    </div>
                                </div>

                            </div>      
                             <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                {{ Form::label('noreferral_link_type_s1','Page Link') }}
                                                {{ Form::select('noreferral_link_type_s1',[null=>'Select']+$pages,'',array('class'=>'form-control'))}}
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                            <label>Image</label>
                                            <input type="file" id="noreferral_action_image_s1" name="noreferral_action_image_s1" class="form-control"/> 
                                        </div>
                                        </div>
                                    </div>                      
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <input type="hidden" value="1" name="noreferral_cnt" id="noreferral_cnt"/>
    </div>
     <div class="col-md-12" id="second_action" >
        <div class="box box-primary">
            <div class="box-body"  style="padding-top:50px">
                <fieldset><legend><strong>Second Take Action Items</strong><i class="fa fa-medkit"></i></legend>   
                    <div id="second_action_container">
                        <span class="right" style="float: right;padding: 5px">
                                    <button type="button" onclick="addSecondActionItem()" title="Add New Action" class="btn btn-primary"><i class="fa fa-plus"></i>Add Second Action</button>
                                </span>
                        <div id="second_action_s1">
                            <div class="row">
                                <h3>Second Action 1</h3>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        {{ Form::label('header','Action Text') }}
                                        <input type="text" id="second_action_s1" name="second_action_s1" value="" class="form-control" />
                                    </div>
                                </div>
                                 <div class="col-xs-6">
                                    <div class="form-group">
                                    <div class="col-xs-3">
                                        {{ Form::label('header','Is sub item?') }}
                                        <input type="checkbox" id="second_action_sub_s1" name="second_action_sub_s1" value="yes" class="form-control"/>  
                                    </div>
                                        <div class="col-xs-3">
                                             {{ Form::label('header','Text property') }}
                                           <select class="form-control" id="second_action_property_s1" name="second_action_property_s1">
                                            <option>Select</option>
                                               <option>Bold</option>
                                               <option style="color:red">Bold Red</option>
                                               <option style="color:blue">Bold Blue</option>
                                               <option style="color:black;font-style:italic">Italic</option>
                                               <option style="color:red;font-style:italic">Italic Red</option>
                                               <option style="color:blue;font-style:italic">Italic Blue</option>
                                               <option>Underlined</option>
                                               <option style="color:red">Underlined Red</option>
                                               <option style="color:blue">Underlined Blue</option>
                                           </select>
                                        </div>
                                        
                                    </div>
                                </div>
                                 
                            </div>    
                             <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                {{ Form::label('second_link_type_s1','Page Link') }}
                                                {{ Form::select('second_link_type_s1',[null=>'Select']+$pages,'',array('class'=>'form-control'))}}
                                            </div>
                                        </div>  
                                         <div class="col-xs-6">
                                            <div class="form-group">
                                            <label>Image</label>
                                            <input type="file" id="second_action_image_s1" name="second_action_image_s1" class="form-control"/> 
                                        </div>
                                        </div>    
                        </div>    
                         <input type="hidden" value="1" name="second_action_sub_cnt_s1" id="second_action_sub_cnt_s1"/>                    
                        </div>
                    </div>
                </fieldset>

            </div>
        </div>
        <input type="hidden" value="1" name="second_action_cnt" id="second_action_cnt"/>
        
    </div>  
 
<div class="col-md-12" id="answer_items">
        <div class="box box-primary">
            <div class="box-body">
                <fieldset><legend>Page Question</legend>   
                    <div id="question_container">
                        <span class="right" style="float: right;padding: 5px">
                                    <button type="button" onclick="addQuestionItem()" title="Add New Question" class="btn btn-primary"><i class="fa fa-plus"></i>Add Question</button>
                                </span>
                        <div id="question_s1">
                            <div class="row">
                                <h3>Question 1</h3>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        {{ Form::label('header','Question') }}
                                        <input type="text" id="question_s1" name="question_s1" value="" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <legend style="margin-bottom: 0px">
                                <span class="right" style="float: right;padding: 5px">
                                    <button type="button" onclick="addAnswerElement('_s1')" title="Add Answer" class="btn btn-primary"><i class="fa fa-plus"></i>Add answer</button>
                                </span>Answers</legend>
                            <div id="answer_s1" style="">

                                <div class="" style="background-color: #f0f0f0;padding: 5px;border-bottom: solid 1px #ccc;margin-bottom: 5px" id="answer_pages_s1__1">
                                    <h5>Answer 1</h5>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                {{ Form::label('question_s1__1','Item') }}    
                                               <input type="text" id="question_s1__1" name="question_s1__1" value="" class="form-control" />
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                {{ Form::label('link_type_s1__1','Page Link') }}
                                                {{ Form::select('link_type_s1__1',[null=>'Select']+$pages,'',array('class'=>'form-control'))}}
                                            </div>
                                        </div>
                                    </div>
                                     <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                {{ Form::label('definition_s1__1','Definition') }}
                                               <input type="text" id="definition_s1__1" name="definition_s1__1" value="" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="answer_cnt_s1" id="answer_cnt_s1" value="1" />
                            </div>
                        </div>
                    </div>
                </fieldset>

            </div>
        </div>
        <input type="hidden" value="1" name="question_cnt" id="question_cnt"/>
    </div> 
    
  <div class="col-md-12" id="items">
        <div class="box box-primary">
            <div class="box-body">
                <fieldset><legend>Page Sections</legend>   
                    <div id="layout_container">
                        <span class="right" style="float: right;padding: 5px">
                                    <button type="button" onclick="addLayoutItem()" title="Add New Element" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></button>
                                </span>
                        <div id="layout_s1">
                            <div class="row">
                                <h3>Page Section 1</h3>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        {{ Form::label('header','Page Header') }}
                                        <input type="text" id="page_header_s1" name="page_header_s1" value="" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <legend style="margin-bottom: 0px">
                                <span class="right" style="float: right;padding: 5px">
                                    <button type="button" onclick="addNewElement('_s1')" title="Add New Page Item" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></button>
                                </span>Page Items</legend>
                            <div id="pItem_s1" style="">

                                <div class="" style="background-color: #f0f0f0;padding: 5px;border-bottom: solid 1px #ccc;margin-bottom: 5px" id="element_pages_s1__1">
                                    <h3>Page Item 1</h3>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                {{ Form::label('page_header_s1__1','Item') }}    
                                               <input type="text" id="page_header_s1__1" name="page_header_s1__1" value="" class="form-control" />
                                            </div>
                                        </div>
                                                 <div class="col-xs-6">
                                    <div class="form-group">
                                    <div class="col-xs-3">
                                        {{ Form::label('header','Is sub item?') }}
                                        <input type="checkbox" id="page_item_sub_s1__1" name="page_item_sub_s1__1" value="yes" class="form-control"/>  
                                    </div>
                                        <div class="col-xs-3">
                                             {{ Form::label('header','Text property') }}
                                           <select class="form-control" id="page_item_property_s1__1" name="page_item_property_s1__1">
                                            <option>Select</option>
                                               <option>Bold</option>
                                               <option style="color:red">Bold Red</option>
                                               <option style="color:blue">Bold Blue</option>
                                               <option style="color:black;font-style:italic">Italic</option>
                                               <option style="color:red;font-style:italic">Italic Red</option>
                                               <option style="color:blue;font-style:italic">Italic Blue</option>
                                               <option>Underlined</option>
                                               <option style="color:red">Underlined Red</option>
                                               <option style="color:blue">Underlined Blue</option>
                                           </select>
                                        </div>
                                        
                                    </div>
                                </div>
                                       
                            </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                {{ Form::label('link_type_s1__1','Page Link') }}
                                                {{ Form::select('link_type_s1__1',[null=>'Select']+$pages,'',array('class'=>'form-control'))}}
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                            <label>Image</label>
                                            <input type="file" id="page_item_image_s1__1" name="page_item_image_s1__1" class="form-control"/> 
                                        </div>
                                        </div>    
                                    </div>
                                      <input type="hidden" name="page_subitem_cnt_s1" id="page_subitem_cnt_s1" value="1" />
                                </div>
                                <input type="hidden" name="element_cnt_s1" id="element_cnt_s1" value="1" />
                               
                            </div>

                        </div>
                    </div>
                </fieldset>

            </div>
        </div>
    </div>  
         <div class="col-md-12" id="actions">
        <div class="box box-primary">
            <div class="box-body">
                <fieldset><legend>Action Items</legend>   
                    <div id="action_container">
                        <span class="right" style="float: right;padding: 5px">
                                    <button type="button" onclick="addActionItem()" title="Add New Action" class="btn btn-primary"><i class="fa fa-plus"></i>Add Action</button>
                                </span>
                        <div id="action_s1">
                            <div class="row">
                                <h3>Action 1</h3>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        {{ Form::label('header','Action Text') }}
                                        <input type="text" id="action_s1" name="action_s1" value="" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <legend style="margin-bottom: 0px">
                                <span class="right" style="float: right;padding: 5px">
                                    <!--<button type="button" onclick="addActionElement('_s1')" title="Add Answer" class="btn btn-primary"><i class="fa fa-plus"></i>Add details</button>-->
                                </span>Action Details</legend>
                                    <h5>Action Detail 1 </h5>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                {{ Form::label(' color_s1','Color Coding') }}  
                                                 <select class="form-control" id="color_s1" name="color_s1">
                                                  <option>Default</option>
                                                 <option>Red</option>
                                                 <option>Amber</option>
                                                 <option>Green</option>
                                               </select> 
                                             
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                {{ Form::label('link_type_s1','Page Link') }}
                                                {{ Form::select('link_type_s1',[null=>'Select']+$pages,'',array('class'=>'form-control'))}}
                                            </div>
                                        </div>
                                    </div>
                            <div id="action_details_s1" style="">

                                <div class="" style="background-color: #fff;border-bottom: solid 1px #ccc;margin-bottom: 5px" id="action_details_pages_s1__1">
                                
                                </div>
                                <input type="hidden" name="action_detail_cnt_s1" id="action_detail_cnt_s1" value="1" />
                            </div>
                        </div>
                    </div>
                </fieldset>

            </div>
        </div>
        <input type="hidden" value="1" name="action_cnt" id="action_cnt"/>
    </div>
    <input type="hidden" value="1" name="layout_cnt" id="layout_cnt"/>
      <button type="submit" class="btn btn-success">Create Page</button>
            <button type="reset" class="btn btn-danger">Reset</button>  
    {{ Form::close()}}
</div>
{{ HTML::script('assets/scripts/jquery.min.js'); }}
{{ HTML::script('assets/scripts/bootstrap.min.js'); }}
<!--<script src="{{ asset("assets/scripts/jquery.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset("assets/scripts/bootstrap.min.js") }}" type="text/javascript"></script>-->

<script type="text/javascript">
     function addLayoutItem() {
//        alert("Add layout Item");
        currentElementCnt = $("#layout_cnt" ).val();
        currentElementCnt++;
        firstContent = $("#layout_s1").html();
        firstContent = firstContent.replace(/_s1/g, '_s' + currentElementCnt);
        firstPitem =$("#element_pages_s1__1").html();
        firstPitem = firstPitem.replace(/_s1/g, '_s' + currentElementCnt);

        firstContent = firstContent.replace(/Page Section 1/g, "Page Section "+currentElementCnt);
        $(firstContent).find("input").val("");
        $(firstContent).find("h3").html("Page Section "+ currentElementCnt);
//        alert(firstPitem)
        $(firstContent).find("#pItem_s"+(currentElementCnt)).html(firstPitem);
        $(firstContent).find("select").val("");
        $(firstContent).find("textarea").val("");
        $("#layout_cnt").val(currentElementCnt);
        $("#layout_container").append(firstContent);
    }
    function addNewElement(idx) {
        currentElementCnt = $("#element_cnt" + idx).val();
        currentElementCnt++;
        firstContent = $("#element_pages_s1__1").html();
        firstContent = firstContent.replace(/__1/g, '__' + currentElementCnt);
        firstContent = firstContent.replace(/Page Item 1/g,"Page Item "+currentElementCnt);
        $(firstContent).find("input").val("");
        $(firstContent).find("h5").html("Page Item "+currentElementCnt);
        $(firstContent).find("select").val("");
        $(firstContent).find("textarea").val("");
        $("#element_cnt"+idx).val(currentElementCnt);
        $("#pItem"+idx).append(firstContent);
    }
 function addQuestionItem() {
//        alert("Add layout Item");
        currentElementCnt = $("#question_cnt" ).val();
        currentElementCnt++;
        firstContent = $("#question_s1").html();
        firstContent = firstContent.replace(/_s1/g, '_s' + currentElementCnt);
        firstPitem =$("#answer_pages_s1__1").html();
        firstPitem = firstPitem.replace(/_s1/g, '_s' + currentElementCnt);

        firstContent = firstContent.replace(/Question 1/g, "Question "+currentElementCnt);
        $(firstContent).find("input").val("");
        $(firstContent).find("h3").html("Question "+currentElementCnt);
//        alert(firstPitem)
        $(firstContent).find("#answer_s"+(currentElementCnt)).html(firstPitem);
        $(firstContent).find("select").val("");
        $(firstContent).find("textarea").val("");
        $("#question_cnt").val(currentElementCnt);
        $("#question_container").append(firstContent);
    }
    function addAnswerElement(idx) {
        currentElementCnt = $("#answer_cnt" + idx).val();
        currentElementCnt++;
        firstContent = $("#answer_pages_s1__1").html();
        firstContent = firstContent.replace(/__1/g, '__' + currentElementCnt);
        firstContent = firstContent.replace(/Answer 1/g, "Answer "+currentElementCnt);
        $(firstContent).find("input").val("");
        $(firstContent).find("h5").html("Answer "+currentElementCnt);
        $(firstContent).find("select").val("");
        $(firstContent).find("textarea").val("");
        $("#answer_cnt"+idx).val(currentElementCnt);
        $("#answer"+idx).append(firstContent);
    }
function addActionItem() {
//        alert("Add layout Item");
        currentElementCnt = $("#action_cnt" ).val();
        currentElementCnt++;
        firstContent = $("#action_s1").html();
        firstContent = firstContent.replace(/_s1/g, '_s' + currentElementCnt);
       // firstPitem =$("#action_details_pages_s1__1").html();
       // firstPitem = firstPitem.replace(/_s1/g, '_s' + currentElementCnt);

        firstContent = firstContent.replace(/Action 1/g, "Action "+currentElementCnt);
        $(firstContent).find("input").val("");
        $(firstContent).find("h3").html("Action "+currentElementCnt);
//        alert(firstPitem)
        //$(firstContent).find("#action_details_s"+(currentElementCnt)).html(firstPitem);
        $(firstContent).find("select").val("");
        $(firstContent).find("textarea").val("");
        $("#action_cnt").val(currentElementCnt);
        $("#action_container").append(firstContent);
    }
   function addSecondActionItem() {
//        alert("Add layout Item");
        currentElementCnt = $("#second_action_cnt" ).val();
        currentElementCnt++;
        firstContent = $("#second_action_s1").html();
        firstContent = firstContent.replace(/_s1/g, '_s' + currentElementCnt);
        firstContent = firstContent.replace(/Second Action 1/g, "Second Action "+currentElementCnt);
        $(firstContent).find("input").val("");
        $(firstContent).find("h3").html( "Second Action "+currentElementCnt);
        $("#second_action_cnt").val(currentElementCnt);
        $("#second_action_container").append(firstContent);
    }
    function addFirstActionItem() {
//        alert("Add layout Item");
        currentElementCnt = $("#first_action_cnt" ).val();
        currentElementCnt++;
        firstContent = $("#first_action_s1").html();
        firstContent = firstContent.replace(/_s1/g, '_s' + currentElementCnt);
        firstContent = firstContent.replace(/First Action 1/g, "First Action "+currentElementCnt);
        $(firstContent).find("input").val("");
        $(firstContent).find("h3").html( "First Action "+currentElementCnt);
        $("#first_action_cnt").val(currentElementCnt);
        $("#first_action_container").append(firstContent);
    }
    function addFirstActionSubItem() {
//        alert("Add layout Item");
        currentElementCnt = $("#first_action_sub_cnt_s1" ).val();
        currentElementCnt++;
        firstContent = $("#first_action_sub_s1").html();
        firstContent = firstContent.replace(/_s1/g, '_s' + currentElementCnt);
       // firstContent = firstContent.replace(/#1 First Action/g, '#' + currentElementCnt + " First Action");
        $(firstContent).find("input").val("");
        //$(firstContent).find("h1").html("#" + currentElementCnt + " First Action");
        $("#first_action_sub_cnt_s1").val(currentElementCnt);
        $("#first_action_sub_s1").append($(firstContent).find("input").val(""));
    }
     function addSecondActionSubItem() {
//        alert("Add layout Item");
        currentElementCnt = $("#second_action_sub_cnt_s1" ).val();
        currentElementCnt++;
        firstContent = $("#second_action_sub_s1").html();
        firstContent = firstContent.replace(/_s1/g, '_s' + currentElementCnt);
       // firstContent = firstContent.replace(/#1 First Action/g, '#' + currentElementCnt + " First Action");
        $(firstContent).find("input").val("");
        //$(firstContent).find("h1").html("#" + currentElementCnt + " First Action");
        $("#second_action_sub_cnt_s1").val(currentElementCnt);
        $("#second_action_sub_s1").append($(firstContent).find("input").val(""));
    }
     function addPageSubItem() {
//        alert("Add layout Item");
        currentElementCnt = $("#page_subitem_cnt_s1" ).val();
        currentElementCnt++;
        firstContent = $("#page_item_sub_s1").html();
        firstContent = firstContent.replace(/_s1/g, '_s' + currentElementCnt);
       // firstContent = firstContent.replace(/#1 First Action/g, '#' + currentElementCnt + " First Action");
        $(firstContent).find("input").val("");
        //$(firstContent).find("h1").html("#" + currentElementCnt + " First Action");
        $("#page_subitem_cnt_s1").val(currentElementCnt);
        $("#page_item_sub_s1").append($(firstContent).find("input").val(""));
    }
function addTransportActionItem() {
//        alert("Add layout Item");
        currentElementCnt = $("#transport_cnt" ).val();
        currentElementCnt++;
        firstContent = $("#transport_s1").html();
        firstContent = firstContent.replace(/_s1/g, '_s' + currentElementCnt);
        firstContent = firstContent.replace(/Waiting For Transport Action 1/g,  "Waiting For Transport Action "+currentElementCnt);
        $(firstContent).find("input").val("");
        $(firstContent).find("h3").html( "Waiting For Transport Action "+currentElementCnt);
        $("#transport_cnt").val(currentElementCnt);
        $("#transport_container").append(firstContent);
    }
    function addNoReferralActionItem() {
        //alert("Add layout Item");
        currentElementCnt = $("#noreferral_cnt" ).val();
        currentElementCnt++;
        firstContent = $("#noreferral_s1").html();
        firstContent = firstContent.replace(/_s1/g, '_s' + currentElementCnt);
        firstContent = firstContent.replace(/No Referral Action 1/g,"No Referral Action "+currentElementCnt);
        $(firstContent).find("input").val("");
        $(firstContent).find("h3").html( "No Referral Action "+ currentElementCnt);
        $("#noreferral_cnt").val(currentElementCnt);
        $("#noreferral_container").append(firstContent);
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
    $("#page_section").change(function () {
      var id=$('#page_section option:selected').text();
    $("#page_description").val(id+"> ");
    $("#page_name").val("");
    $("#page_shortname").val("");

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

<script type="text/javascript">
    $(document).ready(function() {
    $("#filename").click(function () {
      
            alert($('#first_action_image_s1').val());

});
    });
</script>
<script type="text/javascript">
     $(document).ready(function() {
    $("#emergency_level").hide();
    $("#definition").hide();
    $("#question_header").hide();
    $("#image").hide();
    $("#first_action").hide();
    $("#transport").hide();
    $("#second_action").hide();
    $("#answer_items").hide();
    $("#actions").hide();
    $("#items").hide();
        $("#referral_section").hide();


    $("#type_of_page").change(function(){
        var id=$('#type_of_page option:selected').text();
        //alert(id);
        if(id=="Take Action Page"){
             var referral=$('#referral option:selected').text();
            $("#emergency_level").show();
            $("#definition").hide();
            $("#image").show();
            $("#first_action").show();
            $("#second_action").show();
            $("#question_header").hide();
            $("#answer_items").hide();
            $("#items").hide();
            $("#actions").show();
            if(referral=="No referral"){
               $("#referral_section").show();  
            }else{
               $("#transport").show(); 
            }
           
        }else if(id=="Question Page"){
             $("#emergency_level").hide();
            $("#definition").hide();
            $("#image").hide();
            $("#first_action").hide();
            $("#transport").hide();
            $("#second_action").hide();
            $("#question_header").show();
            $("#answer_items").show();
            $("#items").hide();
             $("#referral_section").hide();
            $("#actions").show();
        }else if(id=="Info Page"){
             $("#emergency_level").hide();
            $("#definition").hide();
            $("#image").hide();
            $("#first_action").hide();
            $("#transport").hide();
            $("#second_action").hide();
            $("#question_header").hide();
            $("#answer_items").hide();
            $("#items").show();
            $("#actions").show();
            $("#referral_section").hide();
        }
        else if(id=="Take Action Classification Page"){
         $("#emergency_level").hide();
            $("#definition").hide();
            $("#image").hide();
            $("#first_action").hide();
            $("#transport").hide();
            $("#second_action").hide();
            $("#question_header").show();
            $("#answer_items").show();
            $("#items").hide();
            $("#actions").show();
            $("#referral_section").hide();
        }
  
});
    });
</script>
@stop