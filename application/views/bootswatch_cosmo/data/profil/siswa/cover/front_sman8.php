
	<div id="bg_cover" class=" page_bg1">

		<style>

			.cover-label{
				border: #000 thin solid;
				padding: 10px 18px 10px 18px;
				font-size: 22px;
			}

			#cover-title{
				font-size: 16px;
				font-weight: bold;
				font-family: "Times New Roman";
			}

			#w-nama{
				margin: 12px 50px 28px 50px;
			}

			#w-nisn{
				margin: 12px 140px 28px 140px;
			}
			.identitas{
				font-size: 14px;
				
				font-style: italic;
				font-family: "Times New Roman";
				line-height: 20px;
			}

		</style>

		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		
		<div id="cover-title" class="center">
			RAPOR <br>
			SEKOLAH MENENGAH ATAS<BR/>
			(SMA)
			<BR/>
			
		</div>

		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		
		<div class="center" style="padding: 0 0 0 200px " >
			<table>
			 <tr>
			  <td class="identitas" width="30%"> NAMA </td>
			  <td class="identitas">: <?php echo strtoupper($row["nama"]); ?> </td>
			 </tr>
			 <tr>
			  <td class="identitas"> NIS / NISN </td>
			  <td class="identitas">: <?php echo $row["nis"]; ?> / <?php echo $row["nisn"]; ?> </td>
			 </tr>
			</table>
		</div>

		
		<br/><br/>


	</div>

	<?= '<pagebreak />'; ?>