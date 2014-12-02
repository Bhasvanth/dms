<fieldset>
    <legend>Search Domains</legend>
	<form method="POST">
	<table>
	    <tr>
		    <td>Name</td>
		    <td>
			    <select name="name_condition" id="name_condition">
				    <option value="starts-with">starts with</option>
				    <option value="contains" selected>contains</option>
				    <option value="ends-with">ends with</option>
				</select>
				
			</td>
		    <td><input type="text" name="name" id="name"/></td>
		</tr>
		<tr>
		    <td>Min Length</td>
		    <td>
			   <input type="text" name="min-length" id="min-length" length="10"/>
			</td>
			<td>Maximum Length</td>
		    <td><input type="text" name="max-length" id="max-length"/></td>
		</tr>
		<tr>
		    <td>Others</td>
		    <td colspan="2">
			    <input type="checkbox" name="with-hyphens" id="with-hyphens" value="with-hyphens"/> With hyphens  <br>
			    <input type="checkbox" name="with-numbers" id="with-numbers" value="with-numbers"/> With numbers  <br>
			    <input type="checkbox" name="without" id="without" value="without"/> Without  
			</td>
		</tr>
		<tr>
		    <td>Start Date</td>
		    <td>
			    <input type="text" name="start_date" id="start_date" /> 
			</td>
			<td>End Date</td>
		    <td>
			    <input type="text" name="end_date" id="end_date" /> 
			</td>
		</tr>
		<tr>
		    <td>&nbsp;</td>
		    <td colspan="2">
			    <input type="submit" value="Filter"/>  
			    <input type="reset"  value="Clear"/>  
			</td>
			<td>&nbsp;</td>
		</tr>
	</table>
</fieldset>
<fieldset>
<legend>Search Results</legend>

<table>
    <tr>
        <th>Name</th>
        <th>Expiry Date</th>
    </tr>


    <?php foreach ($domains as $domain): ?>
    <tr>
        <td>
            <?php 
			echo $domain['Domain']['name'];
			//echo $this->Html->link($domain['Domain']['name'],array('controller' => 'domains', 'action' => 'view', $domain['Domain']['id'])); 
            ?>
        </td>
        <td><?php echo $domain['Domain']['expiry_date']; ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($domain); ?>
</table>
</form>
</fieldset>
