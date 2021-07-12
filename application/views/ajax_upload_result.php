<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JustBoil's Result Page</title>
<script language="javascript" type="text/javascript">
/*window.parent.postMessage("alert(document.location.href); document.location.href = http://<?php echo APP_SUBDOMAIN;?>/assets/tinymce_4.0.2/plugins/jbimages/dialog-v4.htm'", "*");
	window.open("", "", "width=200, height=100");
    alert(window.parent);*/
	//window.parent.location = 'http://<?php echo APP_SUBDOMAIN;?>/assets/tinymce_4.0.2/plugins/jbimages/dialog-v4.htm';
	//window.parent.location = 'http://<?php echo URL_MASTER;?>assets/tinymce_4.0.2/plugins/jbimages/dialog-v4.htm';
	//window.parent.location = '<?php echo APP_ROOT;?>/assets/tinymce_4.0.2/plugins/jbimages/dialog-v4.htm';
	//window.parent.location = 'http://<?php echo URL_MASTER;?>assets/tinymce_4.0.2/plugins/jbimages/dialog-v4.htm';
	/*document.domain = '<?php echo APP_SUBDOMAIN;?>';
	window.parent.window.jbImagesDialog.uploadFinish({
		filename:'<?php echo $file_name; ?>',
		result: '<?php echo $result; ?>',
		resultCode: '<?php echo $resultcode; ?>'
	});*/
	window.parent.postMessage('<?php echo $file_name; ?>?img=kbm', '*');
</script>
<style type="text/css">
	body {font-family: Courier, "Courier New", monospace; font-size:11px;}
</style>
</head>

<body>

Result: <?php echo $result; ?>

</body>
</html>
