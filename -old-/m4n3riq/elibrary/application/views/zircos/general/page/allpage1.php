<!DOCTYPE html>
<html lang="en">
  <head>
    <?=$pages['header']?>
    <?=$pages2['plugin_top']?>
    <style>
	#loading {
	   width: 100%;
	   height: 100%;
	   top: 0;
	   left: 0;
	   position: fixed;
	   display: block;
	   opacity: 0.7;
	   background-color: #fff;
	  /* z-index: 99;*/
	   text-align: center;
	}
/*
	#loading-image {
	  position: absolute;
	  top: 100px;
	  left: 240px;
	  z-index: 100;
	}*/
	</style>
  <!--</head>-->
  <!--</body>
</html>-->
  <body>
	<!--
	<div id="loading">
	  <img id="loading-image" src="<?=URL_MASTER;?>content/images/ajax-loader.gif" alt="Loading..." />
	</div>
	
	<div style="display:none;" id="myDivered" class="animate-bottom">
	-->
		<?=$pages['menu']?>
		<?=$page_content?>
		<?=$pages['footer']?>
		<?=$pages2['plugin_bot']?>
	<!--
	</div>
 
  <script language="javascript" type="text/javascript">
		 $(window).load(function() {
			$('#loading').hide();
			 document.getElementById("myDivered").style.display = "block";
		});
	</script>
	
	<!--</body>
</html>-->
</BODY>
</html>

