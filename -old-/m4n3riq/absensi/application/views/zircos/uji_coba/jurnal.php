<form action="<?=base_url()?>service/insert_jurnal" method="post">
	<table>
		<tr>
			<td>role</td>
			<td><input type="text" name="role" value="sdm"></td>
		</tr>
		<tr>
			<td>user_id</td>
			<td><input type="text" name="user"></td>
		</tr>
		<tr>
			<td>judul</td>
			<td><input type="text" name="judul"></td>
		</tr>
		<tr>
			<td>url</td>
			<td><input type="text" name="url"></td>
		</tr>
		<tr>
			<td>type</td>
			<td><input type="text" name="type"></td>
		</tr>
		<tr>
			<td><button type="submit">Submit</button></td>
		</tr>
	
	</table>
</form>