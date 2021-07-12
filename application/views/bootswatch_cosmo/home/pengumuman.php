 <?php
 $domain_pengumuman = array("sman8-smg.fresto.co", "sman9-smg.fresto.co", "sma-setiabudhi.fresto.co", "smk-penerbangan.smg.fresto.co");
 ?>
 <h2>
       PENGUMUMAN
        <hr/>
	</h2>
    
 <table border="0" width="100%" cellspacing="5px">
    
    	
        <tr><td>
        <?php 
		//print_r($pengumuman);
		//print_r($resultset);
		foreach($resultset['data'] as $config)
{
			if($config['key']=='pengumuman_depan')
			{
				echo "<h3>".$config['value']."</h3>";
			}
		}
 		//echo $pengumuman['config_value'];
		?>
        </td></tr>
        

    
 </table>