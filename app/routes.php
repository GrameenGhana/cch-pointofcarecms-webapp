<?php

Route::get('/', function()
{
     $pages=Pages::all();
	return View::make('table')->with(['pages'=>$pages]);
});
Route::get('onePage', function()
{
       $oldPage = Pages::where('id','=',Input::get('id'))->first();
   return $oldPage->page_url;
});
Route::get('/tables', function()
{
    $pages=Pages::all();
	return View::make('table')->with(['pages'=>$pages]);
});
Route::get('/upload', function()
{
    $sections=Sections::all();
    return View::make('upload')->with(['sections'=>$sections]);
});
Route::get('/allUploads', function()
{
    $uploads=Uploads::all();
    return $uploads;
});
Route::get('/uploadFiles', function()
{
    chmod(public_path() .'\\'.'uploads',0777);

    $sections=Sections::all();
    $section_values =Sections::where('id', '=',Input::get('id'))->first();
   
    $path = public_path().'\\'.'sections\\'.$section_values->shortname;
    $zipFileName = $section_values->shortname.'.zip';
    touch(public_path().'\\'.'uploads\\'.$zipFileName);
    $zip = new ZipArchive;
     if (($zip->open(public_path() .'\\'.'uploads\\'. $zipFileName, ZipArchive::CREATE)) === TRUE) {

  // Copy all the files from the folder and place them in the archive.
        foreach (glob($path . '/*') as $fileName) {
                $file = basename($fileName);                
                $zip->addFile(realpath($fileName), $file);
            }                       
            $zip->close();

            $headers = array(
                'Content-Type' => 'application/zip',
            );
    $upload = new Uploads;
            $upload->section_name = $section_values->name_of_section;
            $upload->section_shortname = $section_values->shortname;
            $upload->section_url = $section_values->section_url;
            $upload->sub_section = $section_values->sub_section;
            $upload->file_url = public_path() .'\\'.'uploads\\'. $zipFileName;   
            $upload->save();
            $page =  DB::table('sections')
                ->where('id', Input::get('id'))
                ->update(array('upload_status' => "Uploaded",
                               ));         
        } else {
            return View::make('upload')->withMessage('Creating zip file Failed');
        }
    return View::make('upload')->with(['sections'=>$sections]);
});

Route::get('/add', function()
{
	$sections= Sections::lists('name_of_section', 'name_of_section');
	$pages = Pages::lists('page_description', 'page_link_value');
	return View::make('edit')->with(['sections' =>$sections,'pages'=>$pages]);
});

Route::get('/forms', function()
{
    $sections= Sections::lists('name_of_section', 'name_of_section');
    $pages = Pages::lists('page_description', 'page_link_value');
   // $page_values =Pages::where('id', '=',Input::get('id'))->first();
  $pages=Pages::all();
    return View::make('table')->with(['pages'=>$pages]);
});
Route::get('/edit', function()
{
    $sections= Sections::lists('name_of_section', 'name_of_section');
    $pages = Pages::lists('page_description', 'page_link_value');
    $page_values =Pages::where('id', '=',Input::get('id'))->first();
       /* $fileContents= file_get_contents($page_values->page_url);
        $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
        $fileContents = trim(str_replace('"', "'", $fileContents));
        $simpleXml = simplexml_load_string($fileContents);
        $json = json_encode($simpleXml);
        $values=json_decode($json,true);*/
      //  return $values;
//return Pages::all();
       // return $values['form']['field'][0]['@attributes']['group'];
  //  return $page_values->page_url;
      
    return View::make('form')->with(['sections' =>$sections,
                                    'pages'=>$pages,
                                    'page_values'=>$page_values]);
});

Route::get('/editSection', function()
{
    $section_values =Sections::where('id', '=',Input::get('id'))->first();
       /* $fileContents= file_get_contents($page_values->page_url);
        $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
        $fileContents = trim(str_replace('"', "'", $fileContents));
        $simpleXml = simplexml_load_string($fileContents);
        $json = json_encode($simpleXml);
        $values=json_decode($json,true);*/
      //  return $section_values;
//return Pages::all();
       // return $values['form']['field'][0]['@attributes']['group'];
  //  return $page_values->page_url;     
    return View::make('editSection')->with(['section_values'=>$section_values]);
});
Route::get('/delete', function()
{
   $page_values =Pages::where('id', '=',Input::get('id'))->first();
    DB::table('pages')->where('id', '=', Input::get('id'))->delete();
     $pages=Pages::all();
    if (File::exists($page_values->page_url)) {
            File::delete($page_values->page_url);
        } 
      
    return View::make('table')->with(['message' =>"Page deleted successfully",'pages'=>$pages]);
});

Route::get('/deleteSection', function()
{
   $page_values =Sections::where('id', '=',Input::get('id'))->first();
    DB::table('sections')->where('id', '=', Input::get('id'))->delete();
     $sections=Sections::all();
    if (File::exists($page_values->section_url)) {
            File::deleteDirectory($page_values->section_url);
        } 
      
    return View::make('upload')->with(['message' =>"Section deleted successfully",'sections'=>$sections]);
});


Route::get('/section', function()
{
	return View::make('sections');
});
Route::post('addSection', function()
    {    
    	$sections = Sections::where('name_of_section','=',Input::get('name_of_section'))->first();
    	$path = public_path().'\\'.'sections\\'.Input::get('shortname');
 $section = [
            'name_of_section' => Input::get('name_of_section'),
            'sub_section' => Input::get('sub_section'),
            'shortname' =>  Input::get('shortname'),
            'section_url'=>$path,
        ];
       $sections = [
           'name_of_section' => Input::get('name_of_section'),
            'sub_section' => Input::get('sub_section'),
            'shortname' =>  Input::get('shortname'),           
        ];
       $rule  =  array(
                    'name_of_section' => 'required',
                    'shortname' => 'required',
                ) ;
 
            $validator = Validator::make($sections,$rule);
             if ($validator->fails())
            {
                    return Redirect::to('/section')
                            ->withErrors($validator->messages());
            }
            else
            {
            if((Input::get('sub_section')!="CWC References")&&(Input::get('sub_section')!="CWC Calculators")){
                //echo "Not ready";
                     File::makeDirectory($path, $mode = 0777, true, true);
            }	else{
                 //echo "ready";
            }
           
             $sectionData = new Sections($section);
          
              $sectionData->save();
                        return Redirect::to('/section')
                            ->withMessage('Section created');     
            }
       
});
Route::post('editSectionValue', function()
    {    
        $sections = Sections::where('id','=',Input::get('id'))->first();
        $pages = Pages::where('page_section','=',$sections->name_of_section)->get();
        $array=(array)$pages;
        $path = public_path().'\\'.'sections\\'.Input::get('shortname');
        $Uploadpath = public_path().'\\'.'uploads\\'.$sections->shortname;
 $section = [
            'name_of_section' => Input::get('name_of_section'),
            'sub_section' => Input::get('sub_section'),
            'shortname' =>  Input::get('shortname'),
            'section_url'=>$path,
        ];
       $sectionValues = [
           'name_of_section' => Input::get('name_of_section'),
            'sub_section' => Input::get('sub_section'),
            'shortname' =>  Input::get('shortname'),           
        ];
       $rule  =  array(
                    'name_of_section' => 'required',
                    'shortname' => 'required',
                ) ;
 
            $validator = Validator::make($sectionValues,$rule);
             if ($validator->fails())
            {
                    return Redirect::to('/editSection?id='.$sections->id)
                            ->withErrors($validator->messages());
            }
            else
            {
            if((Input::get('sub_section')!="CWC References")&&(Input::get('sub_section')!="CWC Calculators")){
                if(File::exists($sections->section_url)){
                     File::makeDirectory($path, $mode = 0777, true, true);
                     if($pages->count()>1){
                       /* foreach ($pages as $p) {
                          if(File::exists($p->page_url)){
                             File::copy($p->page_url, $path.'\\'.$p->page_shortname.'.xml');
                          } 
                        }*/
                        $files=File::files($sections->section_url);
                        $fileDetails=[];
                        foreach ($files as $f) {
                            if(File::exists($f)){
                                $fileDetails=pathinfo($f);
                                File::copy($f, $path.'\\'.$fileDetails['basename']);

                            }
                        }
                         
                     }   
                   File::deleteDirectory($sections->section_url);
                     if(File::exists($Uploadpath.".zip")){
                      File::delete($Uploadpath.".zip");
                    }   
                }    
            }   
        if($pages->count()>1){
            foreach ($pages as $p) {
               $page =  DB::table('pages')
                 ->where('id', $p->id)
                 ->update(array('page_url' =>public_path().'\\'.'sections\\'.Input::get('shortname').'\\'.$p->page_shortname.'.xml',
                'page_link_value'=> Input::get('shortname').'/'.$p->page_shortname,
                'page_section'=>Input::get('name_of_section'),
                'page_description'=>Input::get('name_of_section').'>'.$p->page_name,
                 'page_subtitle'=>Input::get('sub_section').':'.Input::get('name_of_section').'>'.$p->page_name,
             ));     
                }   
                                  }
            $sectionsEdit =  DB::table('sections')
                ->where('id', Input::get('id'))
                ->update(array('name_of_section' =>Input::get('name_of_section'),
                               'sub_section'=> Input::get('sub_section'),
                               'shortname'=>Input::get('shortname'),
                               'section_url'=>$path,
                               'upload_status'=>""
                               ));      
                        return Redirect::to('/editSection?id='.$sections->id)
                            ->withMessage('Section edited');     
                           // return $pages->count();
            }
       
});
Route::post('addPage', function()
    {    
$rule  =  array(
                    'page_description'  => 'required',
                    'page_name'  => 'required',
                    'page_title'    => 'required',
                    'page_subtitle' => 'required',
                    'type_of_page'     => 'required',
                    'page_section'  => 'required',
                    'page_shortname'=> 'required',
                ) ;
      $validator = Validator::make(Input::all(), $rule);
        if ($validator->fails()) {
            return Redirect::to('/edit')
                            ->with('flash_error', 'true')
                            ->withInput()
                            ->withErrors($validator);
        } else {
            $section = Sections::where('name_of_section','=',Input::get('page_section'))->first();
            $xmlFileName =$section->section_url.'\\'.Input::get('page_shortname').'.xml';
            $page = new Pages;
            $page->page_description = Input::get('page_description');
            $page->page_name = Input::get('page_name');
            $page->type_of_page = Input::get('type_of_page');
            $page->page_title = Input::get('page_title');
            $page->page_subtitle = Input::get('page_subtitle').": ".Input::get('page_description');
            $page->page_section = Input::get('page_section');
            $page->page_link_value = $section->shortname."/".Input::get('page_shortname');
            $page->color_code = Input::get('color_code');
            $page->page_shortname = Input::get('page_shortname');
            $page->page_url = $xmlFileName;
//            
            $page->save();
        }
      return Redirect::to('/add')->withMessage('Page created successfully');
});
Route::post('addPageDetails', function()
    {    
        if (Input::hasFile('image')){
            $image = Input::file('image');
            $name=$image->getClientOriginalName();
        }

         $oldPage = Pages::where('id','=',Input::get('id'))->first();
             if (File::exists($oldPage->page_url)) {
                 File::delete($oldPage->page_url);
                } 

    	$rule  =  array(
                    'page_description'    => 'required',
                    'page_name'  => 'required',
                    'page_title' => 'required',
                    'page_subtitle'   => 'required',
                    'type_of_page'   => 'required',
                    'page_section'   => 'required',
                    'page_shortname'   => 'required',
                ) ;
      $validator = Validator::make(Input::all(), $rule);
        if ($validator->fails()) {
            return Redirect::to('/forms')
                            ->with('flash_error', 'true')
                            ->withInput()
                            ->withErrors($validator);
        } else {

            $first_action_cnt = Input::get('first_action_cnt');
            $second_action_cnt = Input::get('second_action_cnt');
            $transport_action_cnt = Input::get('transport_cnt');
            $action_cnt = Input::get('action_cnt');
            $question_cnt = Input::get('question_cnt');
             $layout_cnt = Input::get('layout_cnt');
             $noreferral_cnt = Input::get('noreferral_cnt');
//          
              $section = Sections::where('name_of_section','=',Input::get('page_section'))->first();
 			$xmlFileName =$section->section_url.'\\'.Input::get('page_shortname').'.xml';
         /*
            $page = new Pages;
            $page->name_of_page = Input::get('name_of_page');
            $page->type_of_page = Input::get('page_type');
            $page->page_title = Input::get('page_title');
            $page->page_subtitle = Input::get('page_subtitle').": ".Input::get('name_of_page');
            $page->page_section = Input::get('page_section');
            $page->page_link_value = $section->shortname."/".Input::get('page_shortname');
            $page->color_code = Input::get('color_code');
            $page->page_shortname = Input::get('page_shortname');
            $page->page_url = $xmlFileName;
//            */
          //  $page->save();
             $page =  DB::table('pages')
               ->where('id', Input::get('id'))
               ->update(array('page_description' => Input::get('page_description'),
                              'type_of_page' => Input::get('type_of_page'),
                              'page_name' => Input::get('page_name'),
                              'page_title'=> Input::get('page_title'),
                              'page_subtitle'=>Input::get('page_subtitle').": ".Input::get('page_description'),
                               'page_section'=>Input::get('page_section'),
                               'page_link_value'=>$section->shortname."/".Input::get('page_shortname'),
                               'color_code'=>Input::get('color_code'),
                               'page_shortname'=>Input::get('page_shortname'),
                                'page_url'=>$xmlFileName,
                               ));
			$xmlFile=fopen($xmlFileName, "w");
           
				$xmlgui = new SimpleXMLElement('<xmlgui/>');
                $form=$xmlgui->addChild('form');
                 $form->addAttribute('name',Input::get('page_shortname'));
                 $form->addAttribute('type_of_page',Input::get('type_of_page'));
                $form->addAttribute('page_title',Input::get('page_title'));
                $form->addAttribute('page_subtitle',Input::get('page_subtitle').": ".Input::get('page_description'));
                $form->addAttribute('color_code',Input::get('color_code'));
				// $xmlgui = $xml->addChild('xmlgui');
            	if(Input::get('type_of_page')=="Take Action Page"){
 					$field=$form->addChild('field');
 					$field->addAttribute('name',Input::get("definition"));
 					$field->addAttribute('link','');
 					$field->addAttribute('type','definition');
 					$field->addAttribute('group','definition');
                    $field->addAttribute('color_code','');
                    $field->addAttribute('property','');
                    $field->addAttribute('options','');

                    $first_actions_head_xml_field=$form->addChild('field');
                    $first_actions_head_xml_field->addAttribute('name','Take Action: '.Input::get('page_name'));
                    $first_actions_head_xml_field->addAttribute('link','');
                    $first_actions_head_xml_field->addAttribute('type','first_section_head');
                    $first_actions_head_xml_field->addAttribute('group','first_actions');
                    $first_actions_head_xml_field->addAttribute('color_code','');
                    $first_actions_head_xml_field->addAttribute('property','');
                    $first_actions_head_xml_field->addAttribute('options','');
                        if (Input::hasFile('image')){
                            $first_actions_image_xml_field=$form->addChild('field');
                            $first_actions_image_xml_field->addAttribute('name',$section->shortname."/".$name);
                            $first_actions_image_xml_field->addAttribute('link','');
                            $first_actions_image_xml_field->addAttribute('type','image');
                            $first_actions_image_xml_field->addAttribute('group','first_actions');
                            $first_actions_image_xml_field->addAttribute('color_code','');
                            $first_actions_image_xml_field->addAttribute('property','');
                            $first_actions_image_xml_field->addAttribute('options','');
                }



 					for ($i = 1; $i <= $first_action_cnt; $i++) {

                      //  $subitemcnt = Input::get("first_action_sub_cnt_s$i");
 						$first_actions_xml_field=$form->addChild('field');
 						$first_actions_xml_field->addAttribute('name',Input::get("first_action_s$i"));
 						$first_actions_xml_field->addAttribute('link',Input::get("first_link_type_s$i"));
                        if(Input::get("first_action_sub_s$i")=="yes"){
                            $first_actions_xml_field->addAttribute('type','first_actions_sub');
                        }else{
                             $first_actions_xml_field->addAttribute('type','first_actions');
                        }
 						$first_actions_xml_field->addAttribute('group','first_actions');
                        $first_actions_xml_field->addAttribute('color_code','');
                        $first_actions_xml_field->addAttribute('property',Input::get("first_action_property_s$i"));
                        $first_actions_xml_field->addAttribute('options','');
                       if (Input::hasFile("first_action_image_s$i")){

                            $image = Input::file("first_action_image_s$i");
                            $name=$image->getClientOriginalName();

                            $first_actions_image_xml_field=$form->addChild('field');
                            $first_actions_image_xml_field->addAttribute('name',$section->shortname."/".$name);
                            $first_actions_image_xml_field->addAttribute('link','');
                            $first_actions_image_xml_field->addAttribute('type','image');
                            $first_actions_image_xml_field->addAttribute('group','first_actions');
                            $first_actions_image_xml_field->addAttribute('color_code','');
                            $first_actions_image_xml_field->addAttribute('property','');
                            $first_actions_image_xml_field->addAttribute('options','');
                            $image->move($section->section_url.'\\', $image->getClientOriginalName());
                        }
            }
            if(Input::get("referral")=="No referral"){
                    $transport_actions_head_xml_field=$form->addChild('field');
                    $transport_actions_head_xml_field->addAttribute('name','Patient Education: ');
                    $transport_actions_head_xml_field->addAttribute('link','');
                    $transport_actions_head_xml_field->addAttribute('type','transport_section_head');
                    $transport_actions_head_xml_field->addAttribute('group','transport_actions');
                    $transport_actions_head_xml_field->addAttribute('color_code','');
                    $transport_actions_head_xml_field->addAttribute('property','');
                    $transport_actions_head_xml_field->addAttribute('options','');
            }else{
                  $transport_actions_head_xml_field=$form->addChild('field');
                    $transport_actions_head_xml_field->addAttribute('name','While waiting for transport: ');
                    $transport_actions_head_xml_field->addAttribute('link','');
                    $transport_actions_head_xml_field->addAttribute('type','transport_section_head');
                    $transport_actions_head_xml_field->addAttribute('group','transport_actions');
                    $transport_actions_head_xml_field->addAttribute('color_code','');
                    $transport_actions_head_xml_field->addAttribute('property','');
                    $transport_actions_head_xml_field->addAttribute('options','');
            }
           
             for ($j = 1; $j <= $transport_action_cnt; $j++) {
                if(Input::get("referral")=="No referral"){
                    $transport_xml_field=$form->addChild('field');
                        $transport_xml_field->addAttribute('name',Input::get("noreferral_s$j"));
                        $transport_xml_field->addAttribute('link',Input::get("noreferral_link_type_s$j"));
                         if(Input::get("noreferral_sub_s$j")=="yes"){
                            $transport_xml_field->addAttribute('type','transport_actions_sub');
                        }else{
                             $transport_xml_field->addAttribute('type','transport_actions');
                        }
                        $transport_xml_field->addAttribute('group','transport_actions');
                         $transport_xml_field->addAttribute('color_code','');
                         $transport_xml_field->addAttribute('property',Input::get("transport_property_s$j"));
                         $transport_xml_field->addAttribute('options','');
                           if (Input::hasFile("noreferral_action_image_s$j")){
                                $image = Input::file("noreferral_action_image_s$j");
                                $name=$image->getClientOriginalName();
                                $transport_image_xml_field=$form->addChild('field');
                                $transport_image_xml_field->addAttribute('name',$section->shortname."/".$name);
                                $transport_image_xml_field->addAttribute('link','');
                                $transport_image_xml_field->addAttribute('type','image');
                                $transport_image_xml_field->addAttribute('group','transport_actions');
                                $transport_image_xml_field->addAttribute('color_code','');
                                $transport_image_xml_field->addAttribute('property','');
                                $transport_image_xml_field->addAttribute('options','');
                              $image->move($section->section_url.'\\', $image->getClientOriginalName());
                        }

                }else{
                        $transport_xml_field=$form->addChild('field');
                        $transport_xml_field->addAttribute('name',Input::get("transport_s$j"));
                        $transport_xml_field->addAttribute('link',Input::get("transport_link_type_s$j"));
                         if(Input::get("transport_sub_s$j")=="yes"){
                            $transport_xml_field->addAttribute('type','transport_actions_sub');
                        }else{
                             $transport_xml_field->addAttribute('type','transport_actions');
                        }
                        $transport_xml_field->addAttribute('group','transport_actions');
                         $transport_xml_field->addAttribute('color_code','');
                         $transport_xml_field->addAttribute('property',Input::get("transport_property_s$j"));
                         $transport_xml_field->addAttribute('options','');
                           if (Input::hasFile("transport_action_image_s$j")){
                                $image = Input::file("transport_action_image_s$j");
                                $name=$image->getClientOriginalName();
                                $transport_image_xml_field=$form->addChild('field');
                                $transport_image_xml_field->addAttribute('name',$section->shortname."/".$name);
                                $transport_image_xml_field->addAttribute('link','');
                                $transport_image_xml_field->addAttribute('type','image');
                                $transport_image_xml_field->addAttribute('group','transport_actions');
                                $transport_image_xml_field->addAttribute('color_code','');
                                $transport_image_xml_field->addAttribute('property','');
                                $transport_image_xml_field->addAttribute('options','');
                              $image->move($section->section_url.'\\', $image->getClientOriginalName());   
                        }
                    }
                }
            for ($k = 1; $k <= $second_action_cnt; $k++) {
            	$second_actions_xml_field=$form->addChild('field');
 						$second_actions_xml_field->addAttribute('name',Input::get("second_action_s$k"));
 						$second_actions_xml_field->addAttribute('link',Input::get("second_link_type_s$k"));
                         if(Input::get("second_action_sub_s$k")=="yes"){
                            $second_actions_xml_field->addAttribute('type','second_actions_sub');
                        }else{
                             $second_actions_xml_field->addAttribute('type','second_actions');
                        }
 						$second_actions_xml_field->addAttribute('group','second_actions');
                        $second_actions_xml_field->addAttribute('color_code','');
                        $second_actions_xml_field->addAttribute('property',Input::get("second_action_property_s$k"));
                          $second_actions_xml_field->addAttribute('options','');
                 if (Input::hasFile("second_action_image_s$k")){
                                $image = Input::file("second_action_image_s$k");
                                $name=$image->getClientOriginalName();
                                $second_action_image_xml_field=$form->addChild('field');
                                $second_action_image_xml_field->addAttribute('name',$section->shortname."/".$name);
                                $second_action_image_xml_field->addAttribute('link','');
                                $second_action_image_xml_field->addAttribute('type','image');
                                $second_action_image_xml_field->addAttribute('group','second_actions');
                                $second_action_image_xml_field->addAttribute('color_code','');
                                $second_action_image_xml_field->addAttribute('property','');
                                $second_action_image_xml_field->addAttribute('options','');
                              $image->move($section->section_url.'\\', $image->getClientOriginalName());
                        }
                } 
                 for ($i = 1; $i <= $action_cnt; $i++) { 
                        Input::get("action_s$i");
                        $actionDetailCnt = Input::get("action_detail_cnt_s$i");
                    
                        $action_xml_field=$form->addChild('field');
                        $action_xml_field->addAttribute('name',Input::get("action_s$i"));
                        $action_xml_field->addAttribute('color_code',Input::get("color_s$i"));
                        $action_xml_field->addAttribute('property','');
                        $action_xml_field->addAttribute('link',Input::get("link_type_s$i"));
                        $action_xml_field->addAttribute('type','button');
                        $action_xml_field->addAttribute('group','actions');  
                        $action_xml_field->addAttribute('options','');  
                }
                 
            		
                //Question Page
            	}else if(Input::get('type_of_page')=="Question Page"){
            		for ($i = 1; $i <= $question_cnt; $i++) {

                		$answerCnt = Input::get("answer_cnt_s$i");
                		$question_xml_field=$form->addChild('field');
 						$question_xml_field->addAttribute('name',Input::get("question_s$i"));
 						$question_xml_field->addAttribute('link','');
 						$question_xml_field->addAttribute('type','question');
 						$question_xml_field->addAttribute('group','questions'); 
                        $question_xml_field->addAttribute('color_code','');
                        $question_xml_field->addAttribute('property','');
                        $question_xml_field->addAttribute('options','');
                	for ($k = 1; $k <= $answerCnt; $k++) {
                   		 $ik = "_s$i" . "__$k";
                   		
                   		$answer_xml_field=$form->addChild('field');
 						$answer_xml_field->addAttribute('name',Input::get("question$ik"));
 						$answer_xml_field->addAttribute('link',Input::get("link_type$ik"));
 						$answer_xml_field->addAttribute('type','answers');
 						$answer_xml_field->addAttribute('group','answers'); 
                        $answer_xml_field->addAttribute('color_code','');
                        $answer_xml_field->addAttribute('property','');
                        $answer_xml_field->addAttribute('options',Input::get("definition$ik"));
                }
            }
            		for ($i = 1; $i <= $action_cnt; $i++) {	
                		Input::get("action_s$i");
                		$actionDetailCnt = Input::get("action_detail_cnt_s$i");
                	
                   		$action_xml_field=$form->addChild('field');
 						$action_xml_field->addAttribute('name',Input::get("action_s$i"));
                        $action_xml_field->addAttribute('color_code',Input::get("color_s$i"));
                        $action_xml_field->addAttribute('property','');
                        $action_xml_field->addAttribute('link',Input::get("link_type_s$i"));
 						$action_xml_field->addAttribute('type','button');
 						$action_xml_field->addAttribute('group','actions'); 
                        $action_xml_field->addAttribute('options','');
            	}
            }else if(Input::get('type_of_page')=="Take Action Classification Page"){
                    for ($i = 1; $i <= $question_cnt; $i++) {

                        $answerCnt = Input::get("answer_cnt_s$i");

                        $question_xml_field=$form->addChild('field');
                        $question_xml_field->addAttribute('name',Input::get("question_s$i"));
                        $question_xml_field->addAttribute('link','');
                        $question_xml_field->addAttribute('type','question');
                        $question_xml_field->addAttribute('group','questions'); 
                        $question_xml_field->addAttribute('color_code','');
                        $question_xml_field->addAttribute('property','');
                        $question_xml_field->addAttribute('options','');
                    for ($k = 1; $k <= $answerCnt; $k++) {
                         $ik = "_s$i" . "__$k";
                        
                        $answer_xml_field=$form->addChild('field');
                        $answer_xml_field->addAttribute('name',Input::get("question$ik"));
                        $answer_xml_field->addAttribute('link',Input::get("link_type$ik"));
                        $answer_xml_field->addAttribute('type','answers');
                        $answer_xml_field->addAttribute('group','answers'); 
                        $answer_xml_field->addAttribute('color_code','');
                        $answer_xml_field->addAttribute('property','');
                        $answer_xml_field->addAttribute('options',Input::get("definition$ik"));
                }
            }
                    for ($i = 1; $i <= $action_cnt; $i++) { 
                        Input::get("action_s$i");
                        $actionDetailCnt = Input::get("action_detail_cnt_s$i");
                    
                        $action_xml_field=$form->addChild('field');
                        $action_xml_field->addAttribute('name',Input::get("action_s$i"));
                        $action_xml_field->addAttribute('color_code',Input::get("color_s$i"));
                        $action_xml_field->addAttribute('property','');
                        $action_xml_field->addAttribute('link',Input::get("link_type_s$i"));
                        $action_xml_field->addAttribute('type','button');
                        $action_xml_field->addAttribute('group','actions'); 
                        $action_xml_field->addAttribute('options','');
                }
            }
            	//Info Page
            	else if(Input::get('type_of_page')=="Info Page"){
            			for ($i = 1; $i <= $layout_cnt; $i++) {	
                			$header_xml_field=$form->addChild('field');
 							$header_xml_field->addAttribute('name',Input::get("page_header_s$i"));
 							$header_xml_field->addAttribute('link','');
 							$header_xml_field->addAttribute('type','header');
 							$header_xml_field->addAttribute('group','section_header'); 
                            $header_xml_field->addAttribute('color_code','');
                            $header_xml_field->addAttribute('property','');
                            $header_xml_field->addAttribute('options','');
                			$elementCnt = Input::get("element_cnt_s$i");
                	for ($k = 1; $k <= $elementCnt; $k++) {
                   		 $ik = "_s$i" . "__$k";
                   		$section_items_xml_field=$form->addChild('field');
 							$section_items_xml_field->addAttribute('name',Input::get("page_header$ik"));
 							$section_items_xml_field->addAttribute('link',Input::get("link_type$ik"));
                            if(Input::get("page_item_sub$ik")=="yes"){
                            $section_items_xml_field->addAttribute('type','section_items_sub');
                        }else{
                             $section_items_xml_field->addAttribute('type','section_items');
                        }
 							$section_items_xml_field->addAttribute('group','section_items');  
                            $section_items_xml_field->addAttribute('color_code','');   
                            $section_items_xml_field->addAttribute('property',Input::get("page_item_property$ik"));   
                            $section_items_xml_field->addAttribute('options','');      
               if (Input::hasFile("page_item_image$ik")){
                                $image = Input::file("page_item_image$ik");
                                $name=$image->getClientOriginalName();
                                $transport_image_xml_field=$form->addChild('field');
                                $transport_image_xml_field->addAttribute('name',$section->shortname."/".$name);
                                $transport_image_xml_field->addAttribute('link','');
                                $transport_image_xml_field->addAttribute('type','image');
                                $transport_image_xml_field->addAttribute('group','section_items');
                                $transport_image_xml_field->addAttribute('color_code','');
                                $transport_image_xml_field->addAttribute('property','');   
                                $transport_image_xml_field->addAttribute('options','');
                              $image->move($section->section_url.'\\', $image->getClientOriginalName());
                        }
                }
            }
            		  for ($i = 1; $i <= $action_cnt; $i++) { 
                        Input::get("action_s$i");
                        $actionDetailCnt = Input::get("action_detail_cnt_s$i");
                        $action_xml_field=$form->addChild('field');
                        $action_xml_field->addAttribute('name',Input::get("action_s$i"));
                        $action_xml_field->addAttribute('color_code',Input::get("color_s$i"));
                        $action_xml_field->addAttribute('link',Input::get("link_type_s$i"));
                        $action_xml_field->addAttribute('type','button');
                        $action_xml_field->addAttribute('group','actions');  
                        $action_xml_field->addAttribute('property','');   
                        $action_xml_field->addAttribute('options','');  
                }
            	}
            	$xmlgui->asXML($xmlFileName);
            return Redirect::to('/forms')
                            ->withMessage('Page created successfully');  
        } 
});
