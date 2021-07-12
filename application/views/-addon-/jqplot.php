<?php

if (isset($plugins))
	$plugins = (array) $plugins;
else
	$plugins = array();

echo link_tag("assets/jquery.jqplot_1.0.8/jquery.jqplot.min.css");
echo '<!--[if IE]><script type="text/javascript" src="' . base_url('assets/jquery.jqplot_1.0.8/excanvas.min.js') . '"></script><![endif]-->';
echo '<script type="text/javascript" src="' . base_url('assets/jquery.jqplot_1.0.8/jquery.jqplot.min.js') . '"></script>';

foreach ($plugins as $_plg)
	echo '<script type="text/javascript" src="' . base_url("assets/jquery.jqplot_1.0.8/plugins/jqplot.{$_plg}.js") . '"></script>';
