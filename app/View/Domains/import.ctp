<?php echo $this->Session->flash();?>
<fieldset>
    <legend>Upload Domains</legend>
	<form method="POST"  enctype="multipart/form-data">
	<table>
	    <tr>
		    <td>File</td>
		    <td><input type="file" name="data[Domains][domainsList]" id="domainsList"/></td>
		</tr>
		<tr>
		    <td>&nbsp;</td>
		    <td>
			    <input type="submit" value="Upload"/>  
			</td>
		</tr>
	</table>
	</form>
</fieldset>
