<?php

// filename : app/helper/dataset

function ds_list($cfg = 'list', $result = array()) {
	$ci = & get_instance();
	$default_config = array(
			'dsnode' => 'resultset',
			'float' => FALSE,
			'data' => 'nama',
			'empty_message' => '-',
	);

	if (!is_array($cfg))
		$cfg = cfgc($cfg);

	array_default($cfg, $default_config);
	$dsnode = $cfg['dsnode'];

	if (!is_array($result))
		$result = $ci->d[$result];

	else if (!$result && is_array($dsnode))
		$result = array_node($ci->d, $dsnode);

	else if (!$result && is_string($dsnode) && isset($ci->d[$dsnode]))
		$result = $ci->d[$dsnode];

	if ($result['selected_rows'] == 0)
		return $cfg['empty_message'];

	if (count($result['data']) == 1)
		return data_eval($cfg['data'], $result['data'][0]);

	$tmp = '<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;"><tr><td><ul style="padding-left: 20px; margin: 0;">';

	foreach ($result['data'] as $row)
		$tmp .= ( ( $cfg['float'] ) ? '<li style="float: left; margin-right: 30px;">' : '<li>') . data_eval($cfg['data'], $row) . '</li>';

	$tmp .= '</ul></td></tr></table>';
	return $tmp;
}

function ds_listing($cfg = 'listing', $result = array()) {
	$ci = & get_instance();
	$stat = '';
	$defaults = array(
			'dsnode' => 'resultset',
			'pagination_link' => FALSE,
			'show_stat' => 'complete',
			'row_id' => 'id',
			'row_link' => FALSE,
			'grouping' => FALSE,
			'jquery' => FALSE,
			'div_properties' => array(
			),
			'ordered' => TRUE,
			'list_properties' => array(
					'type' => 1
			),
			'item_div_properties' => array(
					'class' => ''
			),
			'item_prefix_properties' => array(
					'class' => ''
			),
			'item_label_properties' => array(
					'class' => ''
			),
			'item_desc_properties' => array(
					'class' => ''
			),
			'empty_message' => '<p><i>data kosong</i></p>',
	);

	if (!is_array($cfg))
		$cfg = cfgc($cfg);

	$id = isset($cfg['id']) ? $cfg['id'] : microtime();
	$defaults['id'] = "{$id}-div";
	$defaults['div_properties']['id'] = "{$id}-div";
	$defaults['list_properties']['id'] = "{$id}-list";

	array_default($cfg, $defaults);

	if (!is_array($result))
		$result = $ci->d[$result];

	else if (!$result && is_array($cfg['dsnode']))
		$result = array_node($ci->d, $cfg['dsnode']);

	else if (!$result && is_string($cfg['dsnode']) && isset($ci->d[$cfg['dsnode']]))
		$result = $ci->d[$cfg['dsnode']];

	if ($result['selected_rows'] == 0)
		return $cfg['empty_message'];

	$cfg['item_div_properties']['class'] .= " li-div {$id}-item";
	$cfg['item_prefix_properties']['class'] .= " li-prefix {$id}-item-prefix";
	$cfg['item_label_properties']['class'] .= " li-label {$id}-item-label";
	$cfg['item_desc_properties']['class'] .= " li-desc {$id}-item-desc";

	// mulai render

	$tmp = div($cfg['div_properties']) . '<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;"><tr><td>';

	if ($result['pagination'])
		$stat .= "{$result['pagination']} &nbsp; &nbsp;";

	if ($cfg['show_stat'] === 'complete' && $result['overload'] == TRUE)
		$stat .= "Hasil nomor {$result['start']} sampai {$result['end']}. total lebih dari {$result['total_rows']} baris.";

	else if ($cfg['show_stat'] === 'complete')
		$stat .= "Hasil nomor {$result['start']} sampai {$result['end']} dari {$result['total_rows']} baris.";

	else if ($cfg['show_stat'] && $result['overload'] == TRUE)
		$stat .= "Total lebih dari {$result['total_rows']} baris.";

	else if ($cfg['show_stat'])
		$stat .= "Total {$result['total_rows']} baris.";

	if ($stat != '')
		$tmp .= "<div>{$stat}</div>";

	$tag = ($cfg['ordered']) ? 'ol' : 'ul';
	$tmp .= tag($tag, $cfg['list_properties']);
	$group = array();

	if (is_array($cfg['grouping'])):
		foreach ($cfg['grouping']['column'] as $_col)
			$group[$_col] = NULL;
	endif;

	foreach ($result['data'] as $idx => $row):

		// item grouping

		if (is_array($cfg['grouping'])):

			$_curgrup = array();

			foreach ($cfg['grouping']['column'] as $_col)
				$_curgrup[$_col] = $row[$_col];

			$_diff = array_diff_assoc($_curgrup, $group);

			if ($_diff):
				$group = $_curgrup;
				$_li_attr = 'style="list-style-type: none;"';
				$_div_attr = 'class="listing-group"';
				$_html = '';

				foreach ($cfg['grouping']['title'] as $item)
					$_html .= data_eval($item, $row);

				$tmp .= li($_li_attr, div($_div_attr, $_html));

			endif;


		endif;

		// item

		$tmp .= ( $cfg['ordered'] ) ? '<li value="' . ($result['start'] + $idx ) . '"> ' : '<li> ';
		$row_id = (isset($row[$cfg['row_id']])) ? $row[$cfg['row_id']] : $idx;
		$item_attr = $cfg['item_div_properties'];
		$item_attr['id'] = "{$id}-item-{$row_id}";
		$tmp .= div($item_attr);

		if (isset($cfg['prefix'])):
			$prefix_div = $cfg['item_prefix_properties'];
			$prefix_div['id'] = "{$id}-item-{$row_id}-prefix";
			$tmp .= div($prefix_div);

			foreach ($cfg['prefix'] as $item)
				$tmp .= data_eval($item, $row);

			$tmp .= '</div>';

		endif;

		if (isset($cfg['label'])):
			$label_div = $cfg['item_label_properties'];
			$label_div['id'] = "{$id}-item-{$row_id}-label";
			$tmp .= tag('div', $label_div);
			$label = '';

			foreach ($cfg['label'] as $item)
				$label .= data_eval($item, $row);

			if ($cfg['row_link'] && isset($row[$cfg['row_id']]))
				$tmp .= a("{$cfg['row_link']}/{$row[$cfg['row_id']]}", $label);
			else
				$tmp .= "<b>{$label}</b>";

			$tmp .= '</div>';

		endif;

		if (isset($cfg['desc'])):
			$desc_div = $cfg['item_desc_properties'];
			$desc_div['id'] = "{$id}-item-{$row_id}-desc";
			$tmp .= div($desc_div);

			foreach ($cfg['desc'] as $item)
				$tmp .= data_eval($item, $row);

			$tmp .= '</div>';

		endif;

		$tmp .= '</div></li>';

	endforeach;

	$tmp .=( $cfg['ordered'] ) ? '</ol> ' : '</ul> ';

	if ($stat)
		$tmp .= "<p style='margin-left: 20px;'>{$stat}</p>";

	$tmp .= '</td></tr></table></div>';

	return $tmp;
}

function ds_row($cfg = 'detail', $row = array()) {
	$ci = & get_instance();
	$defaults = array(
			'dsnode' => 'row',
			'properties' => array('border' => 0),
	);

	if (!is_array($cfg))
		$cfg = cfgc($cfg);

	array_default($cfg, $defaults);
	$dsnode = $cfg['dsnode'];

	if (!is_array($row))
		$row = $ci->d[$row];

	else if (!$row && is_array($dsnode))
		$row = array_node($ci->d, $dsnode);

	else if (!$row && is_string($dsnode) && isset($ci->d[$dsnode]))
		$row = $ci->d[$dsnode];

	if (!isset($cfg['data']) OR !is_array($cfg['data']) OR count($cfg['data']) == 0):
		$cfg['data'] = array();

		foreach (array_keys($row) as $value)
			$cfg['data'][$value] = array($value);

	endif;

	// mulai generate

	$tmp = tag('table', $cfg['properties']);
	$label_width = (isset($cfg['width'][0])) ? " style=\"width: {$cfg['width'][0]}px;\"" : '';
	$data_width = (isset($cfg['width'][1])) ? " style=\"width: {$cfg['width'][1]}px;\"" : '';

	foreach ($cfg['data'] as $title => $data):
		$tdata = data_cell($data, $row);
		$tmp .= "<tr>" . NL
					. "<td class=\"t-label\" {$label_width}>{$title}</td>" . NL
					. "<td class=\"t-data\" {$data_width}>{$tdata}</td>" . NL
					. '</tr>' . NL;

	endforeach;

	$tmp .= '</table>' . NL;

	return $tmp;
}

function ds_table($cfg = 'table', $result = array()) {
	$ci = & get_instance();
	$default_config = array(
			'dsnode' => 'resultset',
			'show_header' => TRUE,
			'pagination_link' => TRUE,
			'show_stat' => FALSE,
			'show_number' => TRUE,
			'row_id' => 'id',
			'row_action' => FALSE,
			'row_link' => FALSE,
			'jquery' => FALSE,
			'div_properties' => array(),
			'table_properties' => array(
					'id' => microtime(),
					'class' => 'table',
			//'cellpadding' => 0,
			//'cellspacing' => 1,
			//'border' => 0,
			//'style' => 'margin: 5px; min-height: 300px;',
			),
			'header_class' => '',
			'alt_header_class' => '',
			'data_class' => '',
			'alt_data_class' => '',
			'empty_message' => '<p><i>data kosong</i></p>',
			'grouping' => FALSE,
	);

	if (!is_array($cfg))
		$cfg = cfgc($cfg);

	array_default($cfg, $default_config);
	$dsnode = $cfg['dsnode'];

	//return print_r($result, TRUE);

	if (!is_array($result))
		$result = $ci->d[$result];

	else if (!$result && is_array($dsnode))
		$result = array_node($ci->d, $dsnode);

	else if (!$result && is_string($dsnode) && isset($ci->d[$dsnode]))
		$result = $ci->d[$dsnode];

	if ($result['selected_rows'] == 0)
		return $cfg['empty_message'];

	//$cfg['start_number'] = $result['index'] + 1;
	$cfg['header_class'] .= ' t-head';
	$cfg['alt_header_class'] .= ' t-alt-head';
	$cfg['data_class'] .= ' t-data';
	$cfg['alt_data_class'] .= ' t-alt-data';

	// config default kolom

	if (!isset($cfg['data'])):
		foreach (array_keys($result['data'][0]) as $header)
			$cfg['data'][$header] = $header;
	endif;

	// jquery class

	if ($cfg['jquery']):
		$cfg['header_class'] .= ' ui-widget-header';
		$cfg['alt_header_class'] .= ' ui-widget-header';
		$cfg['data_class'] .= ' ui-state-default';
		$cfg['alt_data_class'] .= ' ui-state-active';

	else:
		$cfg['header_class'] .= ' my-widget-header';
		$cfg['alt_header_class'] .= ' my-widget-content';
		$cfg['data_class'] .= ' my-state-default';
		$cfg['alt_data_class'] .= ' my-state-active';

	endif;

	// mulai generate html

	$tmp = div($cfg['div_properties']);
	$stat = $result['pagination'];

	if ($stat)
		$stat .= '&nbsp; &nbsp;';

	if ($cfg['show_stat'] === 'complete' && $result['overload'] == TRUE)
		$stat .= "Hasil nomor {$result['start']} sampai {$result['end']}. total lebih dari {$result['total_rows']} baris.";

	else if ($cfg['show_stat'] === 'complete')
		$stat .= "Hasil nomor {$result['start']} sampai {$result['end']} dari {$result['total_rows']} baris.";

	else if ($cfg['show_stat'] && isset($result['overload']) && $result['overload'] == TRUE)
		$stat .= "Total lebih dari {$result['total_rows']} baris.";

	else if ($cfg['show_stat'])
		$stat .= "Total {$result['total_rows']} baris.";

	if ($stat)
		$tmp .= "<p style='margin-left: 20px;'>{$stat}</p>";

	$tmp .= "<div class='table-responsive'>";
	
	$tmp .= tag('table', $cfg['table_properties']);

	// generate header

	if ($cfg['show_header']):
		$headers = array_keys($cfg['data']);
		$tmp .= '<thead><tr>';
		// $tmp .= '<thead style="border-bottom: 1px #000;"><tr>';
		$jml_head = 0;
		$jml_alt = 0;

		if ($cfg['show_number']):
			$tmp .= "<td class=\"{$cfg['header_class']}\" style=\"min-width: 10px;\"><b>#</b></td>" . NL;
			$jml_head++;

		endif;

		foreach ($headers as $head):
			$width = (isset($cfg['data'][$head]['width'])) ? "style=\"min-width: {$cfg['data'][$head]['width']}px;\"" : '';
			$tmp .= "<td class=\"{$cfg['header_class']}\" {$width}>{$head}</td>";
			$jml_head++;

		endforeach;

		// alt-data. baris tambahan/kedua

		if (isset($cfg['alt-data']) && is_array($cfg['alt-data'])):

			$tmp .= '</tr><tr>';

			if ($cfg['show_number']):
				$tmp .= "<td class=\"{$cfg['alt_header_class']}\">&nbsp;</td>" . NL;
				$jml_alt++;

			endif;

			foreach ($cfg['alt-data'] as $kol => $cf):
				$is_colspan = (isset($cf['colspan']) && is_numeric($cf['colspan']) && $cf['colspan'] > 1 && $cf['colspan'] < 10);
				$colspan = ($is_colspan) ? " colspan=\"{$cf['colspan']}\"" : '';
				$tmp .= "<td class=\"{$cfg['alt_header_class']}\" {$colspan}>{$kol}</td>" . NL;
				$jml_alt++;

			endforeach;

		endif;
		$total_kolom = ($jml_alt > $jml_head) ? $jml_alt : $jml_head;
		$tmp .= '</tr></thead><tbody></tbody>';

	endif;

	// generate data

	$group = array();

	if (is_array($cfg['grouping'])):
		foreach ($cfg['grouping']['column'] as $_col)
			$group[$_col] = NULL;
	endif;

	foreach ($result['data'] as $no => $row):

		// item grouping

		if (is_array($cfg['grouping'])):

			$_curgrup = array();

			foreach ($cfg['grouping']['column'] as $_col)
				$_curgrup[$_col] = $row[$_col];

			$_diff = array_diff_assoc($_curgrup, $group);

			if ($_diff):
				$group = $_curgrup;
				$tmp .= "<thead><tr><td colspan=\"{$total_kolom}\" class=\"record-group\">";

				foreach ($cfg['grouping']['title'] as $item)
					$tmp .= data_eval($item, $row);

				$tmp .= '</td></tr></thead>';

			endif;


		endif;

		// item

		$no = url_title($no, '_', TRUE);
		$id_baris = 'table-' . $no;
		$tmp .= "<tbody id=\"{$id_baris}\" ";

		if ($cfg['row_action']):
			$tmp .= "onClick=\"{$cfg['row_action']}({$no})\" class=\"t-row pointer\" title=\" Klik untuk melihat detail \" ";

		elseif ($cfg['row_link']):
			$alamat = base_url($cfg['row_link'] . '/' . $row[$cfg['row_id']]);
			$tmp .= 'onclick="window.open(\'' . $alamat . '\',\'_self\') "'
						. ' class="t-row pointer" title=" Klik untuk melihat detail " ';

		else:
			$tmp .= "class=\"t-row\" ";

		endif;

		$tmp .= '><tr>' . NL;
		$data_class = $cfg['data_class'] . ' ' . $id_baris;

		if ($cfg['show_number']):
			$id_cell = $id_baris . '-no';
			$tmp .= "<td id=\"{$id_cell}\" class=\"{$data_class}\">" . ($result['start'] + $no ) . '</td>' . NL;

		endif;

		foreach ($cfg['data'] as $title => $data):
			$title = url_title($title, '_', TRUE);
			$id_cell = $id_baris . '-' . $title;
			$tdata = data_cell($data, $row);
			$tmp .= "<td id=\"{$id_cell}\" class=\"{$data_class}\">{$tdata}</td>" . NL;

		endforeach;

		// alt-data. baris tambahan/kedua

		if (isset($cfg['alt-data']) && is_array($cfg['alt-data'])):

			$tmp .= "</tr><tr id=\"{$id_baris}-alt_data\">";

			if ($cfg['show_number']):
				$id_cell = $id_baris . '-no';
				$tmp .= "<td id=\"{$id_cell}\" class=\"{$cfg['alt_data_class']}\">&nbsp;</td>" . NL;

			endif;

			foreach ($cfg['alt-data'] as $title => $data):
				$title = url_title($title, '_', TRUE);
				$id_cell = $id_baris . '-' . $title;
				$tdata = data_cell($data, $row);
				$is_colspan = (isset($data['colspan']) && is_numeric($data['colspan']) && $data['colspan'] > 1 && $data['colspan'] < 10);
				$colspan = ($is_colspan) ? " colspan=\"{$data['colspan']}\"" : '';
				$tmp .= "<td id=\"{$id_cell}\" class=\"{$cfg['alt_data_class']}\" {$colspan}>{$tdata}</td>" . NL;

			endforeach;

		endif;

		$tmp .= '</tr></tbody>';

	endforeach;

	/*
	  $tmp .= '<tr><td style="border:0;padding:0" colspan="' . $total_kolom . '">'
	  . '<hr color="#aaa" size="1px" style="margin: 0;"/>'
	  . '</td></tr>'
	  . '</table>';
	 *
	 */
	$tmp .= '</table>';

	$tmp .= '</div>';
	//ending

	if ($stat)
		$tmp .= "<p style='margin-left: 20px;'>{$stat}</p>";

	$tmp .= '</div>';

	return $tmp;
}

function ds_ul($list, $attr) {
	$dat = tag('ul', $attr);

	foreach ($list as $idx => $val):

		$dat .= '<li>';

		if (is_array($val))
			$dat .= "{$idx} : " . ds_ul($val, $attr);
		else if (!is_int($idx))
			$dat .= "{$idx} : {$val}";
		else
			$dat .= $val;

		$dat .= '</li>';

	endforeach;

	return "{$dat}</ul>";
}
