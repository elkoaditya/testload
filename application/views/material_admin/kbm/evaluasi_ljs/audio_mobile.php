<?php


?>


<!--<link rel="stylesheet" href="<?php echo base_url();?>assets/jPlayer_circle/css/not.the.skin.css">-->
<link rel="stylesheet" href="<?php echo base_url();?>assets/jPlayer_circle/circle.skin/circle.player.css">

<!--<script type="text/javascript" src="<?php echo base_url();?>assets/jPlayer_circle/js/jquery.min.js"></script>-->
<script type="text/javascript" src="<?php echo base_url();?>assets/jPlayer_circle/js/jquery.transform2d.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jPlayer_circle/js/jquery.grab.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jPlayer_circle/js/jquery.jplayer.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jPlayer_circle/js/mod.csstransforms.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jPlayer_circle/js/circle.player.js"></script>

<script type="text/javascript">
		$(document).ready(function(){

			/*
			 * Instance CirclePlayer inside jQuery doc ready
			 *
			 * CirclePlayer(jPlayerSelector, media, options)
			 *   jPlayerSelector: String - The css selector of the jPlayer div.
			 *   media: Object - The media object used in jPlayer("setMedia",media).
			 *   options: Object - The jPlayer options.
			 *
			 * Multiple instances must set the cssSelectorAncestor in the jPlayer options. Defaults to "#cp_container_1" in CirclePlayer.
			 */

			var myCirclePlayer = new CirclePlayer("#jquery_jplayer_1",
			{
				//m4a: "http://www.jplayer.org/audio/m4a/Miaow-07-Bubble.m4a",
				oga: "<?php echo base_url().$audio;?>"
			}, {
				cssSelectorAncestor: "#cp_container_1"
			});

			// This code creates a 2nd instance. Delete if not required.

			
		});
		</script>
	

		<!-- The jPlayer div must not be hidden. Keep it at the root of the body element to avoid any such problems. -->
		<div id="jquery_jplayer_1" class="cp-jplayer"></div>

		<div class="prototype-wrapper"> <!-- A wrapper to emulate use in a webpage and center align -->


			<!-- The container for the interface can go where you want to display it. Show and hide it as you need. -->

			<div id="cp_container_1" class="cp-container">
				<div class="cp-buffer-holder"> <!-- .cp-gt50 only needed when buffer is > than 50% -->
					<div class="cp-buffer-1"></div>
					<div class="cp-buffer-2"></div>
				</div>
				<div class="cp-progress-holder"> <!-- .cp-gt50 only needed when progress is > than 50% -->
					<div class="cp-progress-1"></div>
					<div class="cp-progress-2"></div>
				</div>
				<div class="cp-circle-control"></div>
				<ul class="cp-controls">
					<li><a class="cp-play" tabindex="1">play</a></li>
					<li><a class="cp-pause" style="display:none;" tabindex="1">pause</a></li> <!-- Needs the inline style here, or jQuery.show() uses display:inline instead of display:block -->
				</ul>
			</div>


		</div>