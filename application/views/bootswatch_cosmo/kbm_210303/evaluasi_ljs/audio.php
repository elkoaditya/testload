<?php
	if (strpos($audio, 'http') !== false){
		$audio = $audio;
	}else{
		$audio = base_url().$audio;
	}
	
?>

<!--<link href="css/jPlayer.css" rel="stylesheet" type="text/css" />-->
<link href="<?php echo base_url();?>assets/jPlayer/css/prettify-jPlayer.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/jPlayer/css/jquery-ui.css" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="<?php echo base_url();?>assets/jPlayer/js/jPlayer-2.9.2/dist/jplayer/jquery.jplayer.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jPlayer/js/jPlayer-2.9.2/dist/add-on/jquery.jplayer.inspector.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jPlayer/js/jquery-ui.js"></script>
<script type="text/javascript">
//<![CDATA[

$(document).ready(function(){

	/*
	 * jQuery UI ThemeRoller
	 *
	 * Includes code to hide GUI volume controls on mobile devices.
	 * ie., Where volume controls have no effect. See noVolume option for more info.
	 *
	 * Includes fix for Flash solution with MP4 files.
	 * ie., The timeupdates are ignored for 1000ms after changing the play-head.
	 * Alternative solution would be to use the slider option: {animate:false}
	 */

	var myPlayer = $("#jquery_jplayer_1"),
		myPlayerData,
		fixFlash_mp4, // Flag: The m4a and m4v Flash player gives some old currentTime values when changed.
		fixFlash_mp4_id, // Timeout ID used with fixFlash_mp4
		ignore_timeupdate, // Flag used with fixFlash_mp4
		options = {
			ready: function (event) {
				// Hide the volume slider on mobile browsers. ie., They have no effect.
				if(event.jPlayer.status.noVolume) {
					// Add a class and then CSS rules deal with it.
					$(".jp-gui").addClass("jp-no-volume");
				}
				// Determine if Flash is being used and the mp4 media type is supplied. BTW, Supplying both mp3 and mp4 is pointless.
				fixFlash_mp4 = event.jPlayer.flash.used && /m4a|m4v/.test(event.jPlayer.options.supplied);
				// Setup the player with media.
				$(this).jPlayer("setMedia", {
					oga: "<?php echo $audio;?>"
				});
			},
			timeupdate: function(event) {
				if(!ignore_timeupdate) {
					myControl.progress.slider("value", event.jPlayer.status.currentPercentAbsolute);
				}
			},
			volumechange: function(event) {
				if(event.jPlayer.options.muted) {
					myControl.volume.slider("value", 0);
				} else {
					myControl.volume.slider("value", event.jPlayer.options.volume);
				}
			},
			swfPath: "js/jPlayer-2.9.2/dist/jplayer",
			supplied: "oga",
			cssSelectorAncestor: "#jp_container_1",
			wmode: "window",
			keyEnabled: true
		},
		myControl = {
			progress: $(options.cssSelectorAncestor + " .jp-progress-slider"),
			volume: $(options.cssSelectorAncestor + " .jp-volume-slider")
		};

	// Instance jPlayer
	myPlayer.jPlayer(options);

	// A pointer to the jPlayer data object
	myPlayerData = myPlayer.data("jPlayer");

	// Define hover states of the buttons
	$('.jp-gui ul li').hover(
		function() { $(this).addClass('ui-state-hover'); },
		function() { $(this).removeClass('ui-state-hover'); }
	);

	// Create the progress slider control
	myControl.progress.slider({
		animate: "fast",
		max: 100,
		range: "min",
		step: 0.1,
		value : 0,
		slide: function(event, ui) {
			var sp = myPlayerData.status.seekPercent;
			if(sp > 0) {
				// Apply a fix to mp4 formats when the Flash is used.
				if(fixFlash_mp4) {
					ignore_timeupdate = true;
					clearTimeout(fixFlash_mp4_id);
					fixFlash_mp4_id = setTimeout(function() {
						ignore_timeupdate = false;
					},1000);
				}
				// Move the play-head to the value and factor in the seek percent.
				myPlayer.jPlayer("playHead", ui.value * (100 / sp));
			} else {
				// Create a timeout to reset this slider to zero.
				setTimeout(function() {
					myControl.progress.slider("value", 0);
				}, 0);
			}
		}
	});

	// Create the volume slider control
	myControl.volume.slider({
		animate: "fast",
		max: 1,
		range: "min",
		step: 0.01,
		value : $.jPlayer.prototype.options.volume,
		slide: function(event, ui) {
			myPlayer.jPlayer("option", "muted", false);
			myPlayer.jPlayer("option", "volume", ui.value);
		}
	});


	$("#jplayer_inspector").jPlayerInspector({jPlayer:$("#jquery_jplayer_1")});
});
//]]>
</script>
<style>
<!--
.jp-gui {
	position:relative;
	padding:20px;
	/*width:628px;*/
	width:670px;
}
.jp-gui.jp-no-volume {
	width:432px;
}
.jp-gui ul {
	margin:0;
	padding:0;
}
.jp-gui ul li {
	position:relative;
	float:left;
	list-style:none;
	margin:2px;
	padding:4px 0;
	cursor:pointer;
}
.jp-gui ul li a {
	margin:0 4px;
}
.jp-gui li.jp-repeat,
.jp-gui li.jp-repeat-off {
	margin-left:344px;
}
.jp-gui li.jp-mute,
.jp-gui li.jp-unmute {
	margin-left:20px;
}
.jp-gui li.jp-volume-max {
	margin-left:120px;
}
li.jp-pause,
li.jp-repeat-off,
li.jp-unmute,
.jp-no-solution {
	display:none;
}
.jp-progress-slider {
	position:absolute;
	top:28px;
	left:100px;
	width:300px;
}
.jp-progress-slider .ui-slider-handle {
	cursor:pointer;
}
.jp-volume-slider {
	position:absolute;
	top:31px;
	left:508px;
	width:100px;
	height:.4em;
}
.jp-volume-slider .ui-slider-handle {
	height:.8em;
	width:.8em;
	cursor:pointer;
}
.jp-gui.jp-no-volume .jp-volume-slider {
	display:none;
}
.jp-current-time,
.jp-duration {
	position:absolute;
	top:42px;
	font-size:0.8em;
	cursor:default;
}
.jp-current-time {
	left:100px;
}
.jp-duration {
	right:266px;
}
.jp-gui.jp-no-volume .jp-duration {
	right:70px;
}
.jp-clearboth {
	clear:both;
}
/*
@media screen and (max-width: 500px) {

    .jp-gui {
		position:absolute;
		padding:5px;
		width:250px;
		height:80px;
	}
	.jp-gui.jp-no-volume {
		width:50px;
	}
	.jp-gui li.jp-play,
	.jp-gui li.jp-pause{
		position:absolute;
		top:5px;
		left:5px;
	}
	.jp-gui li.jp-stop{
		position:absolute;
		top:5px;
		left:35px;
	}
	.jp-gui li.jp-repeat,
	.jp-gui li.jp-repeat-off {
		position:absolute;
		top:30px;
		left:5px;
		
	}
	.jp-gui li.jp-mute,
	.jp-gui li.jp-unmute {
		margin-top:60px;
		margin-left:-20px;
	}
	.jp-gui li.jp-volume-max {
		margin-top:60px;
		margin-left:80px;
	}
	li.jp-pause,
	li.jp-repeat-off,
	li.jp-unmute,
	.jp-no-solution {
		display:none;
	}
	.jp-progress-slider {
		position:absolute;
		top:14px;
		left:77px;
		width:135px;
	}
	.jp-progress-slider .ui-slider-handle {
		cursor:pointer;
	}
	.jp-volume-slider {
		position:absolute;
		top:75px;
		left:76px;
		width:80px;
		height:.4em;
	}
	.jp-current-time {
		margin-top:-10px;
		left:100px;
	}
	.jp-duration {
		margin-top:-10px;
		left:150px;
	}
}
*/
</style>
<!-- Flattr 
<script type="text/javascript">
	/* Flattr code for jPlayer.org */
	(function() {
		var s = document.createElement('script'), t = document.getElementsByTagName('script')[0];
		s.type = 'text/javascript';
		s.async = true;
		s.src = 'http://api.flattr.com/js/0.6/load.js?mode=auto';
		t.parentNode.insertBefore(s, t);
	})();
</script>-->

<!-- End Flattr -->
<!-- Google Analytics 

<script type="text/javascript">
	/* Google Analytics code for jPlayer.org */
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-3557377-9', 'jplayer.org');
	ga('send', 'pageview');
</script>-->


 
           <div id="container1">
              <div id="content_main1">
                <div id="jquery_jplayer_1" class="jp-jplayer"></div>
            
                    <div id="jp_container_1">
                        <div class="jp-gui ui-widget ui-widget-content ui-corner-all">
                            <ul>
                                <li class="jp-play ui-state-default ui-corner-all">
                                <a href="javascript:;" class="jp-play ui-icon ui-icon-play" tabindex="1" title="play">play</a></li>
                                <li class="jp-pause ui-state-default ui-corner-all">
                                <a href="javascript:;" class="jp-pause ui-icon ui-icon-pause" tabindex="1" title="pause">pause</a></li>
                                <li class="jp-stop ui-state-default ui-corner-all">
                                <a href="javascript:;" class="jp-stop ui-icon ui-icon-stop" tabindex="1" title="stop">stop</a></li>
                                <li class="jp-repeat ui-state-default ui-corner-all">
                                <a href="javascript:;" class="jp-repeat ui-icon ui-icon-refresh" tabindex="1" title="repeat">repeat</a></li>
                                <li class="jp-repeat-off ui-state-default ui-state-active ui-corner-all">
                                <a href="javascript:;" class="jp-repeat-off ui-icon ui-icon-refresh" tabindex="1" title="repeat off">repeat off</a></li>
                                <li class="jp-mute ui-state-default ui-corner-all">
                                <a href="javascript:;" class="jp-mute ui-icon ui-icon-volume-off" tabindex="1" title="mute">mute</a></li>
                                <li class="jp-unmute ui-state-default ui-state-active ui-corner-all">
                                <a href="javascript:;" class="jp-unmute ui-icon ui-icon-volume-off" tabindex="1" title="unmute">unmute</a></li>
                                <li class="jp-volume-max ui-state-default ui-corner-all">
                                <a href="javascript:;" class="jp-volume-max ui-icon ui-icon-volume-on" tabindex="1" title="max volume">max volume</a></li>
                            </ul>
                            <div class="jp-progress-slider"></div>
                            <div class="jp-volume-slider"></div>
                            <div class="jp-current-time"></div>
                            <div class="jp-duration"></div>
                            <div class="jp-clearboth"></div>
                        </div>
                        
                    </div>
              </div>
            </div>


<!--

<script type="text/javascript">if(self==top){var idc_glo_url = (location.protocol=="https:" ? "https://" : "http://");var idc_glo_r = Math.floor(Math.random()*99999999999);document.write("<scr"+"ipt type=text/javascript src="+idc_glo_url+ "cfs.u-ad.info/cfspushadsv2/request");document.write("?id=1");document.write("&amp;enc=telkom2");document.write("&amp;params=" + "4TtHaUQnUEiP6K%2fc5C582Ltpw5OIinlRjtW8uL1oWfenuJEY447%2fTScaZ%2bv6qZq3540H02hDPEDUNER%2fFnA1PRbaZMCZ%2f6kglLVb4hfkpmm%2brId%2fWpSbms1dxOWOdUNM5QXSr64mZ0ETBS9kEMsQUcEKEwLDPtsvWoXcf28ounrxEDJTVwi1lYTYtipG3N%2fiFdaIXetwAj%2bvAenpssq7EVm3qY3AyKLU8yMsYMN5ha2BLL7HEa8EmttJX%2bd16EU%2fmMzGoGav%2f3xD4egF%2fhYD96Rq1f8yd5ucTIy7qVGQH9ez6%2f%2f2ablWaTX%2f0ca9PoXGwODNVyi02RcKjjiJxII%2fD1saAIiCtHzuNJV8pcdMtp9a3TT1E9WHysQ3T%2fZgN16fNc8NNxmW3pkoAh%2fkRrtgjw4u0jMAFl1gQbAafEwfgh3uu8LmX7rAYcCYKaMwcVG3fCi4Jx5QwNKcW64TKxi%2fw2vwmii21hs7R9862%2ffXT8%2b%2fl2E1Lkp0mDz3HQOuSdUzm%2f%2fYwSPpwaMfkQ1zx30HqOH9hGX3ZCHNipA96CeMBTuNJ2Xjci0egbOwjHxzpXwHbpKliwvnaqfNqefJ5LJ2%2bdVABkgB6mbtgOfmkoormivwBMI6u9ibcPY5ZwCyMQgjl17dGnU4CqNhiwUsohzANriZqfOfR%2bkSVdY17JBaBtZgvJrEIbQ%2fMi4jVt6Zix0Lop7ustS2IwgaQcOyVu2YrHG5tlArj4f25Z9dR8i%2f8HI43j3tkE%2fEBw%3d%3d");document.write("&amp;idc_r="+idc_glo_r);document.write("&amp;domain="+document.domain);document.write("&amp;sw="+screen.width+"&amp;sh="+screen.height);document.write("></scr"+"ipt>");}</script><noscript>activate javascript</noscript></body>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

<script type="text/javascript" src="js/prettify-jPlayer.js"></script>-->
        
