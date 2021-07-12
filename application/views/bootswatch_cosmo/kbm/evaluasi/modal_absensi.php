<style>

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  position: relative;
  background-color: #fefefe;
  margin: auto;
  padding: 0;
  border: 1px solid #888;
  width: 80%;
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
  -webkit-animation-name: animatetop;
  -webkit-animation-duration: 0.4s;
  animation-name: animatetop;
  animation-duration: 0.4s
}

/* Add Animation */
@-webkit-keyframes animatetop {
  from {top:-300px; opacity:0} 
  to {top:0; opacity:1}
}

@keyframes animatetop {
  from {top:-300px; opacity:0}
  to {top:0; opacity:1}
}

/* The Close Button */
.close {
  color: white;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

.modal-header {
  padding: 2px 16px;
  background-color: #ffad18;
  color: white;
}

.modal-body {padding: 2px 16px;}

.modal-footer {
  padding: 2px 16px;
  background-color: #ffad18;
  color: white;
}
</style>

<link href="<?=base_url()?>/assets/signature_pad_master/assets/jquery.signaturepad.css" rel="stylesheet">

<!-- The Modal -->
<div id="myModal2" class="modal" style="margin-left:0px; top:0%; display: none;">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
	  <br><br>
    </div>
    <div class="modal-body" align="center">
      <p><h3>Tanda Tangan</h3></p>
      
		<form id="absensi_form" method="post" action="">
			<input type='hidden' id='id_evaluasi' name='id' value=''>
			<input type='hidden' id='ltz' name='ltz' value=''>
			<input type='hidden' id='ltz2' name='ltz2' value=''>
			<input type='hidden' id='image' name='image' value=''>
			
			<div class="sigPad" id="smoothed" style="width:404px;">
			<ul class="sigNav" style="display: block;">
				<li class="drawIt"><a href="#draw-it" class="current">Tulis</a></li>
				<li class="clearButton" style="display: list-item;"><a href="#clear" id="hapus_image">Hapus</a></li>
			</ul>
			<div class="sig sigWrapper current" style="height: auto; display: block;">
				<div class="typed" style="display: none;"></div>
					<canvas class="pad" width="400" height="250"></canvas>
					<input type="hidden" id="ttd" name="ttd" class="output" value="">
				</div>
			</div>
			
			<p id="demo"></p>
			
			<button type = "button" class="btn btn-default cancel"> Cancel </button>
			<button type = "button" class="btn btn-success " onclick="javascript:send_absensi()">Lanjut</button>
			
		</form>
	  
	  <br><br>
    </div>
    <div class="modal-footer">
     <br><br>
    </div>
  </div>

</div>

<script>
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var cancel = document.getElementsByClassName("cancel")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
cancel.onclick = function() {
  modal.style.display = "none";
}
// Get the modal
var modal = document.getElementById('myModal2');

function modalAbsensi( id, ltz, ltz2) {
  
   modal.style.display = "block";
   document.getElementById('id_evaluasi').value = id;
   document.getElementById('ltz').value = ltz;
   document.getElementById('ltz2').value = ltz2;
   document.getElementById("hapus_image").click(); // Click on the checkbox
}

</script>

<script src="<?=base_url()?>/assets/signature_pad_master/assets/numeric-1.2.6.min.js"></script> 
<script src="<?=base_url()?>/assets/signature_pad_master/assets/bezier.js"></script> 
<script src="<?=base_url()?>/assets/signature_pad_master/jquery.signaturepad.js"></script> 
<script>
	
    $(document).ready(function() {
		
      var instance = $('#smoothed').signaturePad({
		  drawOnly:true, 
		  drawBezierCurves:true, 
		  lineTop:200,
		  penColour :'#000000',

		 
		  onDrawEnd :function (){
			  document.getElementById('image').value = instance.getSignatureImage();
			  
			  //document.getElementById("demo").innerHTML = '<img src="'+document.getElementById('image').value+'" alt="Red dot" />';
			  
		  },
		  errorMessageDraw :'Tolong isi tanda tangan'
		});
		
		var image = instance.getSignatureImage();
    });

	function send_absensi(){

		user	= '<?php echo $user["id"];?>';
		ttd		= document.getElementById('ttd').value;
		id 		= document.getElementById('id_evaluasi').value;
		ltz 	= document.getElementById('ltz').value;
		ltz2 	= document.getElementById('ltz2').value;
		image 	= document.getElementById('image').value;   
		
		$.ajax({ //saves changes from Handsontable
			  url: "<?php echo base_url('kbm/evaluasi_tool/input_absensi'); ?>",
			  dataType: "json",
			  type: "POST",
			  data: {user_id:user,evaluasi_id:id,ltz:ltz,ltz2:ltz2,ttd:ttd,image:image}, //returns full array of grid data
			  //data: change, //contains only information about changed cells
			  success: function (data) {
				//console.log("saved", data);
				if(data.status==0){
					$('#status_kerjakan_'+id).html('<div style="background-color:#FF4444; color:white;" > Absen aktif 30menit sebelum Jadwal Dimulai </div>');
				
				}else if(data.status==4){
					$('#status_kerjakan_'+id).html('<div style="background-color:#FF4444; color:white;" > Evaluasi Sudah Selesai ,Absen Tidak diperkenankan </div>');
				
				}else if(data.status==3){
					$('#status_kerjakan_'+id).html('<div style="background-color:#FF4444; color:white;" > Isi Tanda Tangan saat Absen </div>');
				
				}else if(data.status==2){
					location.reload();
					
				}else{
					$('#status_kerjakan_'+id).html('');
					$('#kerjakan_'+id).html('<div align="left"> <a href="<?=base_url()?>kbm/evaluasi_ljs/form?id='+id+'" class="btn btn-success" title="kerjakan evaluasi ini"><i class="icon-pencil"></i> Kerjakan</a></div>');
				
				}
				
				modal.style.display = "none";
				
			 },
			  error: function (data) {
				//location.reload();
				$('#status_kerjakan_'+id).html('<div style="background-color:#FF4444; color:white;"> Gagal Absen, silahkan cek Internet</div>');
			  }
		});

			
	}

</script> 
<script src="<?=base_url()?>/assets/signature_pad_master/assets/json2.min.js"></script>