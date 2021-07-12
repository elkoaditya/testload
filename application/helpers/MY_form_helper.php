<?php

// file: app/helper/MY_form_helper

function form_cell($cfg, $row = array())
{
	$row = (array) $row;

	if (!is_array($cfg))
		return isset($row[$cfg]) ? $row[$cfg] : $cfg;

	///return'-';

	$ci = & get_instance();
	$unused = array('type', 'prefix', 'suffix', 'label');
	$input_type = array('input', 'datepicker', 'datapick', 'password', 'hidden', 'textarea', 'checkbox', 'checklist', 'radio', 'radioset', 'button', 'dropdown');
	$prefix = '';
	$suffix = '';
	$type = array_key_exists('type', $cfg) ? $cfg['type'] : FALSE;
	$type = ($type && in_array($type, $input_type) ) ? $type : FALSE;

	if ($ci->d['post_request'] && isset($cfg[0]) && is_string($cfg[0])):
		$val_data = data_eval($cfg, array($cfg[0] => $ci->input->post($cfg[0])));

		// deteksi tinymce

		$class = (string) array_node($cfg, 'class');
		$tinymce = strpos($class, 'tinymce');

	else:
		$val_data = data_eval($cfg, $row);

	endif;

	// non-input

	if ($type === FALSE)
		return $val_data;

	// decode entiti html, input & text termasuk tinymce
	if (is_string($val_data)):
		$val_data = html_entity_decode($val_data, ENT_QUOTES, 'UTF-8'); //html_entity_decode($val_data);
	endif;

	// prefix

	if (isset($cfg['prefix']))
		$prefix = $cfg['prefix'];

	// suffix

	if (isset($cfg['suffix']))
		if (!is_array($cfg['suffix']))
			$suffix = $cfg['suffix'];
		else
			foreach ($cfg['suffix'] as $inp)
				$suffix .= form_cell((array) $inp, $row);

	// hapus $cfg tak guna

	foreach (array_keys($cfg) as $i)
		if (is_int($i) OR in_array($i, $unused))
			unset($cfg[$i]);

	// no-input

	if (count($cfg) == 0 OR ! $type)
		return trim("{$prefix} {$val_data} {$suffix}");

	// set value

	if (!isset($cfg['value']))
		$cfg['value'] = ($type == 'password') ? '' : $val_data;

	// render input

	if (in_array($type, array('input', 'datepicker', 'password', 'textarea', 'checkbox', 'radio', 'button'))):
		$input = call_user_func("form_{$type}", $cfg);

	elseif ($type == 'radioset'):
		$input = form_radioset($cfg);

	elseif ($type == 'datapick'):
		$input = form_datapick($cfg);

	elseif ($type == 'dropdown'):
		$cfg['options'] = (is_array($cfg['options'])) ? $cfg['options'] : $ci->d[$cfg['options']];
		$extra = (isset($cfg['extra'])) ? $cfg['extra'] : '';
		$input = form_dropdown($cfg['name'], $cfg['options'], $cfg['value'], $extra);

	elseif ($type == 'checklist'):
		$input = form_checklist($cfg);

	else:
		$cfg['type'] = 'hidden';
		$input = form_input($cfg);

	endif;

	//return $prefix;

	return trim("{$prefix} {$input} {$suffix}");

}

function form_checklist($config)
{
	$config = (array) $config;
	$ci = & get_instance();
	$default_config = array(
		'name' => 'checklist',
		'div_list' => array(),
		'float' => TRUE,
		'caption' => FALSE,
		'div_item' => array(),
	);

	array_default($config, $default_config);

	if (!isset($config['value']))
		$config['value'] = array();
	else if (is_string($config['value']))
		$config['value'] = (array) json_decode($config['value'], TRUE);

	if (!is_array($config['options']))
		$config['options'] = $ci->d[$config['options']];

	// mulai generate

	$tmp = div($config['div_list']) . '<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">';

	if ($config['caption'] !== FALSE)
		$tmp .= "<tr><td><span class='capt'>{$config['caption']}</span></td></tr>";

	$tmp .='<tr><td><ul style="padding:0; list-style-type:none; margin: 0;">';

	foreach ($config['options'] as $val => $label):
		$tmp .=(($config['float']) ? '<li style="float: left;">' : '<li>' );
		$cek = array(
			'name' => "{$config['name']}[]",
			'id' => "{$config['name']}-{$val}",
			'class' => "ceklis-{$config['name']}",
			'value' => $val,
			'style' => 'margin: 2px 4px'
		);
		$cek['checked'] = ( ($config['value'] === TRUE) OR in_array($val, (array) $config['value']));
		$tmp .= div($config['div_item']) . form_label(form_checkbox($cek) . $label, $cek['id'], array('style' => 'margin-right:12px')) . '</div></li>';

	endforeach;

	$tmp .= '</ul></td></tr></table></div>';

	return $tmp;

}

function form_datapick($cfg)
{
	$ci = & get_instance();
	$defaults = array(
		'value' => '',
		'value_input' => array('id' => '', 'name' => ''),
		'label_input' => array(
			'id' => '',
			'name' => ''
		),
		'label_default' => '',
		'minlength' => 0,
		'source' => '',
		'row' => 'row',
		'after_effect' => '',
		'line_builder' => 'item.label',
		'input_element' => array(),
		'desc_element' => array(),
	);

	array_default($cfg, $defaults);

	$cfg['value_input']['value'] = $cfg['value'];
	$cfg['value_input']['type'] = 'hidden';

	$tmp = form_input($cfg['value_input']);

	$def_label = isset($cfg['label_input']['value']) ? $cfg['label_input']['value'] : '';
	$cfg['label_input']['value'] = set_value($cfg['label_input']['name'], $def_label);

	if (!$cfg['label_input']['value'] && $cfg['row']):
		if (is_array($cfg['row']))
			$cfg['row'] = (isset($ci->d[$cfg['row']])) ? $ci->d[$cfg['row']] : array();

		if ($cfg['row'])
			$cfg['label_input']['value'] = data_cell($cfg['label_input'], $cfg['row']);

		foreach (array_keys($cfg['label_input']) as $i)
			if (is_int($i))
				unset($cfg['label_input'][$i]);

	endif;

	$tmp .= form_input($cfg['label_input']);
	$cfg['source'] = base_url($cfg['source']);
	$r_input = array();
	$r_desc = array();

	foreach ($cfg['input_element'] as $e_id => $e_json):
		$cfg['after_effect'] .= NL . " $( \"#{$e_id}\" ).val( {$e_json} ); ";
		$r_input[] = "#{$e_id}";
	endforeach;

	foreach ($cfg['desc_element'] as $e_id => $e_json):
		$cfg['after_effect'] .= NL . " $( \"#{$e_id}\" ).text( {$e_json} ); ";
		$r_desc[] = "#{$e_id}";
	endforeach;

	// jquery autocomplete

	$r_input_cleaner = (count($r_input) > 0) ? ('$("' . implode(', ', $r_input) . ').val("");' ) : '';
	$r_desc_cleaner = (count($r_desc) > 0) ? ('$("' . implode(', ', $r_desc) . ').text("");' ) : '';
	$tmp .= NL
		. "<div id='{$cfg['label_input']['id']}-spinner' class='spinner'>&nbsp;</div>"
		. "<div id='{$cfg['label_input']['id']}-dumpter' class='cmd-icon ui-icon-circle-close' "
		. "onClick=\"dom('{$cfg['value_input']['id']}').value='';dom('{$cfg['label_input']['id']}').value='';{$r_input_cleaner}{$r_desc_cleaner}\" >&nbsp;</div>" . NL
		. "<script type=\"text/javascript\">" . NL
		. "$(function(){" . NL
		. "$('#{$cfg['label_input']['id']}-dumpter, #{$cfg['label_input']['id']}').hover(" . NL
		. "function() {   $('#{$cfg['label_input']['id']}-dumpter').show()"
		. ".position({my:'right middle',at:'right middle',of:'#{$cfg['label_input']['id']}',offset:'-2 0'}); }," . NL
		. "function() {   $('#{$cfg['label_input']['id']}-dumpter').hide();  }" . NL
		. ");" . NL
		. " $( \"#{$cfg['label_input']['id']}\" ).autocomplete({ " . NL
		. " minLength: {$cfg['minlength']}, " . NL
		. " source: '{$cfg['source']}', " . NL
		. " focus: function( event, ui ) { " . NL
		. " $( \"#{$cfg['label_input']['id']}\" ).val( ui.item.label ); " . NL
		. " return false; " . NL
		. " }, " . NL
		. " select: function( event, ui ) { " . NL
		. "	$( \"#{$cfg['label_input']['id']}\" ).val( ui.item.label ); " . NL
		. " $( \"#{$cfg['value_input']['id']}\" ).val( ui.item.value ); " . NL
		. $cfg['after_effect'] . NL //efek lain saat dipilih tulis disini
		. " return false; " . NL
		. " }, " . NL
		. " search: function() { " . NL
		. " $(\"#{$cfg['label_input']['id']}-spinner\").show().position({ " . NL
		. " my: \"right middle\", " . NL
		. " at: \"right middle\", " . NL
		. " of: \"#{$cfg['label_input']['id']}\", " . NL
		. " offset: \"-3 0\" " . NL
		. " }); " . NL
		. " }, " . NL
		. " open: function() { $(\"#{$cfg['label_input']['id']}-spinner\").hide(); }, " . NL
		. " change: function( event, ui ) { if ( !ui.item ) { $(this).val('{$cfg['label_default']}'); $(\"#{$cfg['value_input']['id']}\").val('');$(\"#{$cfg['label_input']['id']}-spinner\").hide();} } " . NL
		. " }) " . NL
		. " .data( \"autocomplete\" )._renderItem = function( ul, item ) { " . NL
		. " return $( \"<li></li>\" ).data( \"item.autocomplete\", item ) " . NL
		. " .append( \"<a>\" + {$cfg['line_builder']} + \"</a>\" ) " . NL
		. " .appendTo( ul ); " . NL
		. " }; " . NL
		. " });" . NL
		. "</script>" . NL;

	return $tmp;

}

function form_datepicker($cfg)
{
	$extra = NL
		. "<div id='{$cfg['id']}-dumpter' class='cmd-icon ui-icon-circle-close' "
		. "onClick=\"dom('{$cfg['id']}').value = '';\" >&nbsp;</div>" . NL
		. "<script type=\"text/javascript\">" . NL
		. "$(function(){" . NL
		. "$('#{$cfg['id']}-dumpter, #{$cfg['id']}').hover(" . NL
		. "function() {   $('#{$cfg['id']}-dumpter').show()"
		. ".position({my:'right middle',at:'right middle',of:'#{$cfg['id']}',offset:'-2 0'}); }," . NL
		. "function() {   $('#{$cfg['id']}-dumpter').hide();  }" . NL
		. ");" . NL
		. "$( '#{$cfg['id']}' ).datepicker({"
		. "dateFormat: 'dd-mm-yy' ,"
		. "dayNamesMin: ['Mgg', 'Sn', 'Sl', 'Rb', 'Km', 'Jm', 'Sb'],"
		. "gotoCurrent: true,"
		. "changeMonth: true,"
		. "changeYear: true";

	if (isset($cfg['mindate'])):
		$cfg['mindate'] = is_int($cfg['mindate']) ? $cfg['mindate'] : "'{$cfg['mindate']}'";
		$extra .= ", minDate: {$cfg['mindate']}";
		unset($cfg['mindate']);
	endif;

	if (isset($cfg['maxdate'])):
		$cfg['maxdate'] = is_int($cfg['maxdate']) ? $cfg['maxdate'] : "'{$cfg['maxdate']}'";
		$extra .= ", maxDate: {$cfg['maxdate']},";
		unset($cfg['maxdate']);
	endif;

	$extra .= "});"
		. " });</script>" . NL;
	return form_input($cfg) . $extra;

}

function form_opening($action = '', $attr = '', $sesi_var = 'form')
{

	$ci = & get_instance();
	$sesi_form = isset($ci->d[$sesi_var]) ? $ci->d[$sesi_var] : '';
	$action = ( $action == '' ) ? $ci->d['uri'] : $action;

	if (isset($sesi_form['upload']))
		unset($sesi_form['upload']);

	return form_open(base_url($action), $attr, $sesi_form);

}

function form_openmp($action = '', $attr = '', $sesi_var = 'form')
{

	$ci = & get_instance();
	$sesi_form = isset($ci->d[$sesi_var]) ? $ci->d[$sesi_var] : '';
	$action = ( $action == '' ) ? $ci->d['uri'] : $action;

	if (isset($sesi_form['upload']))
		unset($sesi_form['upload']);

	return form_open_multipart(base_url($action), $attr, $sesi_form);

}

function form_radioset($cfg)
{
	$cfg = (array) $cfg;

	if (!isset($cfg['value']))
		$cfg['value'] = NULL;

	$tmp = '<div id="rset_' . $cfg['name'] . '" class="rset">' . chr(13);

	foreach ($cfg['options'] as $key => $label)
	{
		$data = array(
			'name' => $cfg['name'],
			'id' => "rset_{$cfg['name']}_{$key}",
			'class' => "rset_{$cfg['name']}",
			'value' => $key,
			'checked' => ($cfg['value'] == $key),
			'style' => 'margin-right: 20px'
		);
		$tmp .= form_radio($data) . form_label($label, $data['id']) . chr(13);
	}

	$tmp .= "</div><script type=\"text/javascript\">$(function(){ $(\"#rset_{$cfg['name']}\").buttonset(); });</script>" . chr(13);
	return $tmp;

}

function form_render($cfg = 'form', $row = array())
{
	$ci = & get_instance();
	$defaults = array(
		'dsnode' => 'row',
		'action' => FALSE,
		'input' => array(),
		'properties' => array(
			'border' => 0,
		),
		'submit' => FALSE,
		'reset' => FALSE,
	);
	$res = '';

	if (!is_array($cfg))
		$cfg = subconfig($cfg);

	array_default($cfg, $defaults);
	$dsnode = $cfg['dsnode'];

	if (!is_array($row))
		$row = $ci->d[$row];

	else if (!$row && is_array($dsnode))
		$row = array_node($ci->d, $dsnode);

	else if (!$row && is_string($dsnode) && isset($ci->d[$dsnode]))
		$row = $ci->d[$dsnode];

	if (!isset($cfg['input']) OR ! is_array($cfg['input']) OR count($cfg['input']) == 0)
		return;

	// mulai generate

	if (is_string($cfg['action']))
		$res .= form_openmp($cfg['action']);
	else if ($cfg['action'])
		$res .= form_openmp();

	$res .= tag('table', $cfg['properties']) . NL;
	$label_width = (isset($cfg['width'][0])) ? " style=\"width: {$cfg['width'][0]}px;\"" : '';
	$data_width = (isset($cfg['width'][1])) ? " style=\"width: {$cfg['width'][1]}px;\"" : '';

	foreach ($cfg['input'] as $title => $data)
		$res .= "<tr>" . NL
			. "<td class='f-label' {$label_width}>{$title}</td>" . NL
			. "<td class='f-data' {$data_width}>" . form_cell($data, $row) . "</td>" . NL
			. '</tr>' . NL;

	if ($cfg['submit'] OR $cfg['reset']):
		$res .= "<tr>" . NL . "<td class='f-label'>&nbsp</td>" . NL;
		$res .= "<td class='f-data' {$data_width}>";

		if ($cfg['reset'])
			$res .= form_reset('reset', $cfg['reset']) . '&nbsp; &nbsp; &nbsp; ';

		if ($cfg['submit'])
			$res .= form_submit('submit', $cfg['submit']);

		$res .="</td>" . NL;
		$res .='</tr>' . NL;

	endif;

	$res .= '</table>' . NL;

	if ($cfg['action'])
		$res .= form_close();

	return $res;

}
