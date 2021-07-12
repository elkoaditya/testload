<?php 
$session_user = $this->session->userdata('user');
	foreach($menu as $m){
		if($m->menu_name_eng=='user')
		{ 
			$title_eng		= $m->menu_name_eng;
			$title_ind		= $m->menu_name_ind;
			$title_class	= $m->menu_class;
		}
    }
	
	
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1>Daftar <?=$title_ind;?></h1>
            <ol class="breadcrumb">
          <li><a href="<?php echo site_url("/core");?>"><i class="fa fa-file"></i> Home</a></li>
          <li class="active"><i class="<?=$title_class;?>"></i> <?=$title_ind;?></li>
        </ol> 
        </div>
        <!-- /.col-lg-12 -->
    </div>
            <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
        <?php 
	
	if($session_user->user_position_id=='1')
	{?>
               <form action="<?php echo site_url("/".$title_eng."/form/insert");?>" method="post">
    &nbsp;&nbsp;<button name="tambah" type="submit" class="btn btn-primary btn-sm"> Tambah <?=$title_ind;?></button>
   </form>
   <?php }?>  
   
               <br/>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Data 
                </div>
                <!-- /.panel-heading -->
                        
        
          
    <div class="panel-body">
    	<div class="table-responsive">
			
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Cabang</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <?php 
				if($session_user->user_position_id=='1')
				{?>
                        <th>Edit</th>
                        <th>Delete</th>
                         <?php }?>
                    </tr>
                </thead> 
                <tbody> 
	<?php
	$no=0;
	foreach($user as $u)
	{ 
		$no++;
	?>
            <tr>
            	<td align="right"><?=$no;?>
                <td><?=$u->user_branch;?></td>
                <td><?=$u->user_name;?></td>
                <td align="center"><?=$u->user_position_name;?></td>
                <td align="center"><?=$u->user_phone;?></td>
                <td align="center"><?=$u->user_email;?></td>
                <td><?=$u->user_address;?></td>
                
                <?php 
				if($session_user->user_position_id=='1')
				{?>
                <td align="center">
                <a href="<?php echo site_url("/".$title_eng."/form/update/".$u->user_id);?>"><img src="<?php echo base_url("public/img/pencil.png");?>" /></a></td>
                <td align="center">
                <a href="javascript:void(0)" onclick="hapus('<?=$u->user_id;?>','<?=$u->user_name;?>')"><img src="<?php echo base_url("public/img/cross.png");?>" /></a></td>
            	<?php }?>
            </tr>
            
	<?php
		
	}
	
	?>
	     	</tbody>
          </table>
			</div>
          </div>
       </div>
      </div>
   </div>

</div>

<script>

function hapus(id,nama){
	$.prompt("Menghapus Data <?php echo $title_ind;?> <font color='#FF0000'>"+nama+"</font>", {
		title: "Peringatan",
		buttons: { "Ya": true, "Tidak": false },
		submit: function(e,v,m,f){
			// use e.preventDefault() to prevent closing when needed or return false. 
			// e.preventDefault(); 
			if(v==1)
			{location.href = "<?php echo site_url('/'.$title_eng.'/home/delete');?>/"+id;}
		}
	});
}



</script>
