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



<!-- The Modal -->
<div id="myModal" class="modal" style="margin-left:0px; top:0%; display: none;">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
	  <br><br>
    </div>
    <div class="modal-body">
      <p><h3>Reloback: Tambahan Waktu</h3></p>
      <form method="get" action="<?=base_url()?>kbm/evaluasi_ljs/roleback">
		<input type='hidden' id='id_ljs' name='id' value=''>
		<input type='text' id='timed' name='time' placeholder="hh:ii" class="input input-medium waktud">
		<br>
		<button type = "button" class="btn btn-default cancel"> Cancel </button>
		<button type = "submit" class="btn btn-success"> Ok </button>
	  </form>
	  <br><br>
    </div>
    <div class="modal-footer">
     <br><br>
    </div>
  </div>

</div>
<?php 
	
	addon('timepicker');
?>
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
var modal = document.getElementById('myModal');

function modelRoleback(value) {
  
   modal.style.display = "block";
   document.getElementById('id_ljs').value = value;
}

$(function() {
	
	$('.waktu').timepicker({
		dateFormat: "yy-mm-dd",
		beforeShow: function( input ) {
				setTimeout(function () {
					$(input).datepicker("widget").find(".ui-datepicker-current").hide();
					
				}, 1 );
			}
			
		});
});
</script>