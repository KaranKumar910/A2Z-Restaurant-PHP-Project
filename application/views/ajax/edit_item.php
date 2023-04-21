
	<?php
	echo form_open('',['class' => 'edit-item-form'],['id'=>$id]);
	?>
	<div class="form-group">
		<label>Enter Title </label>
		<input type="text" class="form-control" name="name" value="<?=$item?>">
	</div>
	<div class="form-group">
		<label>Price </label>
		<input type="text" class="form-control" name="price" value="<?=$price?>">
		
	</div>
</form>