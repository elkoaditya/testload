<?php
	echo NL . '<script type="text/javascript" src="' . base_url('assets/tinymce/tinymce.min.js') . '"></script>' . NL;
?>
<style>
	.hidden{display:none;}
</style>
<input name="image" type="file" id="upload" class="hidden" onchange="">
<script>
  /*
  tinymce.init({
		selector: "textarea",  // change this value according to your HTML
		height: 400,
		plugins: [
		   "advlist autolink link image charmap print lists preview hr anchor spellchecker",
		   "searchreplace visualblocks code fullscreen media nonbreaking",
		   "insertdatetime save table contextmenu textcolor powerpaste"
		],
	  powerpaste_word_import: "prompt",
	  powerpaste_html_import: "prompt",
	  powerpaste_allow_local_images: "true",
	  
	   images_upload_url: '<?=base_url()?>postacceptor',
	   //images_upload_url: 'jbimages/upload',
	    //images_upload_url: '<?=base_url()?>jbimages/upload/english',
		//images_upload_base_path: '/images',
		images_upload_credentials: true,
		paste_data_images: true,
		
	});
	*/
	$(document).ready(function() {
		tinymce.init({
			selector: "textarea",
			theme: "modern",
			paste_data_images: true,
			plugins: [
			  "advlist autolink lists link image charmap print preview hr anchor pagebreak",
			  "searchreplace wordcount visualblocks visualchars code fullscreen",
			  "insertdatetime media nonbreaking save table contextmenu directionality",
			  "emoticons template paste textcolor colorpicker textpattern",
			  "eqneditor"
			],
			toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
			toolbar2: "print preview media | forecolor backcolor emoticons | eqneditor ",
			image_advtab: true,
			
			file_picker_callback: function(callback, value, meta) {
			  if (meta.filetype == 'image') {
				$('#upload').trigger('click');
				$('#upload').on('change', function() {
				  var file = this.files[0];
				  var reader = new FileReader();
				  reader.onload = function(e) {
					callback(e.target.result, {
					  alt: ''
					});
				  };
				  reader.readAsDataURL(file);
				});
			  }
			},
			images_upload_url: '<?=base_url()?>postacceptor',
			templates: [{
			  title: 'Test template 1',
			  content: 'Test 1'
			}, {
			  title: 'Test template 2',
			  content: 'Test 2'
			}]
		  });
	  });
  </script>