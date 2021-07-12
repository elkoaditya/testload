<?php
echo NL . '<script type="text/javascript" src="' . base_url('assets/tinymce_4.0.2/tinymce.min.js') . '"></script>' . NL;
?>

<script type="text/javascript">
	tinymce.init({
		selector: "textarea.tinymce",
		theme: "modern",
		//language: 'fr_FR',
		width: '100%',
		height: 600,
		plugins: [
			"eqneditor advlist autolink link image lists charmap print preview hr anchor pagebreak", // spellchecker",
			"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
			"save table contextmenu directionality emoticons template paste textcolor",
			"jbimages"
		],
		//content_css: "css/content.css",
		toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image media | forecolor backcolor emoticons | eqneditor asciimath asciimathcharmap asciisvg | youtube jbimages",
		style_formats: [
			{title: 'Bold text', inline: 'b'},
			{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
			{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
			{title: 'Example 1', inline: 'span', classes: 'example1'},
			{title: 'Example 2', inline: 'span', classes: 'example2'},
			{title: 'Table styles'},
			{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
		],
		AScgiloc: '<?php base_url(); ?>/imathas/svgimg.php',
		ASdloc: '<?php base_url(); ?>/assets/tinymce_4.0.2/plugins/asciisvg/js/d.svg',
		relative_urls: false
	});
	tinymce.init({
		selector: "textarea.tinymce_mini",
		theme: "modern",
		//idth: 400,
		//height: 100,
		plugins: [
			"eqneditor advlist autolink link image lists charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
			"save table contextmenu directionality emoticons template paste textcolor",
			"jbimages"
		],
		AScgiloc: '<?php base_url(); ?>/imathas/svgimg.php',
		ASdloc: '<?php base_url(); ?>/assets/tinymce_4.0.2/plugins/asciisvg/js/d.svg',
		relative_urls: false
	});
</script>