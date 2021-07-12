<?php

/**
 * User: Yusuf Fachrudin S
 * Date: 09/08/2015
 * CV. PINASTHIKA NURAGA
 */
if (!function_exists('view_loader')) {

	function cek_dataexists($data = '') {
		if (!array_key_exists("label",$data))
		{
			$data['label'] = "";
		}
		if (!array_key_exists("name",$data))
		{
			$data['name'] = "";
		}
		if (!array_key_exists("placeholder",$data))
		{
			$data['placeholder'] = "";
		}
		if (!array_key_exists("help",$data))
		{
			$data['help'] = "";
		}
		if (!array_key_exists("onchange",$data))
		{
			$data['onchange'] = "";
		}
		if (!array_key_exists("readonly",$data))
		{
			$data['readonly'] = "";
		}
		if (!array_key_exists("required",$data))
		{
			$data['required'] = "";
		}
		return $data;
	}
	function form_input_text1($d = array(),$col_label1=3,$col_label2=8) {
		$data = cek_dataexists($d);
			$html = '
				  
				<div class="form-group">
					<label class="col-md-'.$col_label1.' control-label">'.$data['label'].'';
			if($data['required']!=''){
				$html .= '<span class="text-danger">*</span>';
			}			
			$html .= '</label>
					<div class="col-md-'.$col_label2.'">
						<input type="text" name="'.$data['name'].'" id="'.$data['name'].'" class="form-control" 
						placeholder="'.$data['placeholder'].'" '.$data['onchange'].' value="'.$data['value'].'" 
						'.$data['readonly'].' '.$data['required'].'>
					</div>
				</div>
			';
		return $html;
    }
	function form_input_text2($d = array(),$col_label1=3,$col_label2=8) {
		$data = cek_dataexists($d);
			$html = '
				  <div class="form-group form-md-line-input form-md-floating-label">
					<div class="input-group col-md-'.$col_label1.'">
														
						<input type="text" name="'.$data['name'].'" id="'.$data['name'].'" class="form-control" placeholder="'.$data['placeholder'].'" '.$data['onchange'].'>
														<span class="help-block">'.$data['help'].'</span>
						<span class="input-group-addon">
						</span>
					</div>';
					if($data['label'] !=""){
			$html .= '<label class="control-label col-md-'.$col_label2.'">'.$data['label'].'</label>';
					}
			$html .= '										
				</div>
			';
		return $html;
    }
	function form_input_date1($d = array(),$no=1,$col_label1=3,$col_label2=8) {
		$data = cek_dataexists($d);
			$html = '
				<div class="form-group">
					<label class="col-md-'.$col_label1.' control-label">'.$data['label'].'</label>
					<div class="input-group">
						<input type="text" name="'.$data['name'].'" class="form-control" 
						placeholder="mm/dd/yyyy" id="datepicker_'.$no.'" '.$data['onchange'].' value="'.$data['value'].'">
						<span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
					</div>
				</div>
				<script>
					jQuery(document).ready(function () {
						jQuery("#datepicker_'.$no.'").datepicker({
							autoclose: true,
							todayHighlight: true
						});
					});
				</script>
			';
		return $html;
    }
	function form_input_date2($d = array(),$col_label1=3,$col_label2=8) {
		$data = cek_dataexists($d);
			$html = '
				<div class="form-group">
					<label class="col-md-'.$col_label1.' control-label">'.$data['label'].'</label>
					<div class="input-group">
						<input type="text" name="'.$data['name'].'" class="form-control datepicker" 
						id="'.$data['name'].'" '.$data['onchange'].' value="'.$data['value'].'" data-mask="99-99-9999" >
						
					</div>
				</div>
			';
		return $html;
    }
	function form_input_select1($d = '',$col_label1=3,$col_label2=8) {
		$data = cek_dataexists($d);
			$html = '
				   <div class="form-group">
                            <label class="col-sm-'.$col_label1.' control-label">'.$data['label'].'';
			if($data['required']!=''){
				$html .= '<span class="text-danger">*</span>';
			}			
			$html .= '</label>
                            <div class="col-sm-'.$col_label2.'">
									<select class="form-control " name="'.$data['name'].'" id="'.$data['name'].'" 
									'.$data['onchange'].' '.$data['readonly'].' '.$data['required'].'>
										<option value="">- pilih -</option>';
			foreach($data['select'] as $select)
			{
				$selected ='';
				if($data['value']==$select['value'])
				{	$selected = 'selected';	}
				$html .= '<option value="'.$select['value'].'" '.$selected.'>'.$select['label'].'</option>';
			}
			$html .= '				</select>
                            </div>
                        </div>
			';
		return $html;
    }
	
	function form_input_textarea1($d = array(),$col_label1=3,$col_label2=8) {
		$data = cek_dataexists($d);
			$html = '
				  <div class="form-group">
					<label class="control-label col-md-'.$col_label1.'">'.$data['label'].'';
			if($data['required']!=''){
				$html .= '<span class="text-danger">*</span>';
			}			
			$html .= '</label>
					<div class=" col-md-'.$col_label2.'">
														
						<textarea name="'.$data['name'].'" rows="5" class="form-control" '.$data['readonly'].
						' '.$data['required'].'/>'.$data['value'].'</textarea>
														
						
						
					</div>
													
				</div>
			';
		return $html;
    }
	
	function form_input_password1($d = array(),$col_label1=3,$col_label2=8) {
		$data = cek_dataexists($d);
			$html = '
				  <div class="form-group">
					<label class="control-label col-md-'.$col_label1.'">'.$data['label'].'';
			if($data['required']!=''){
				$html .= '<span class="text-danger">*</span>';
			}			
			$html .= '</label>
					<div class="col-md-'.$col_label2.'">
														
						<input type="password" name="'.$data['name'].'" class="form-control" 
						placeholder="'.$data['placeholder'].'" '.$data['onchange'].' value="'.$data['value'].'">
												
					</div>
													
				</div>
			';
		return $html;
    }
}