<script>

jQuery(document).ready(function(){

	//choix d'une image
	jQuery('.add_falling_image').click(function(e) {

	    var _this = this;
	    e.preventDefault();

	    var image = wp.media({ 
	        title: 'Upload Image',
	        // mutiple: true if you want to upload multiple files at once
	        multiple: false

	    }).open()
	    .on('select', function(e){

	        // This will return the selected image from the Media Uploader, the result is an object
	        var uploaded_image = image.state().get('selection').first();

	        // Output to the console uploaded_image
	        var image_url = uploaded_image.toJSON().url;

	        //enregistrement Ajax
	        jQuery.post(ajaxurl, {action: 'falling_image_add', image: image_url, _ajax_nonce: '<?php echo wp_create_nonce( "falling_image_add" ); ?>'}, function(id){

	    		jQuery(".falling_images").append('<input type="checkbox" name="images[]" value="'+id+'" /> <img src="'+image_url+'" />');

	    	});

	    });

	});

});

</script>
<h2>Failling things settings</h2>
<form action="" method="post" class="leafs_form">

	<?php wp_nonce_field( 'leafs_settings' ); ?>
	<label>Active images</label>
	<span class="falling_images">
	<?php
		foreach($images as $image)
		{
			$headers = @get_headers($image->image);
			if($headers[0] == 'HTTP/1.1 200 OK')
				echo '<input type="checkbox" name="images[]" value="'.$image->id.'" '.($image->active == 1 ? 'checked="checked"' : '').' /><img src="'.$image->image.'" /> ';
		}
	?>
	</span>
	<br />
	<a href="#" class="add_falling_image">Add an image</a><br />
	<label>Falling items quantity: </label>
	<input type="text" name="quantity" value="<?php echo $quantity ?>" /> (1 to 100)<br />
	<br />
	<label>Falling item speed: </label>
	<input type="text" name="speed" value="<?php echo $speed ?>" /> (1 to 5)<br />
	<label>Move left/right: </label>
	<input type="checkbox" name="move_lr" value="1" <?php echo ($move_lr == true ? 'checked="checked"' : '') ?> /><br />
	<label>Display on: </label>
	<select name="display_on">
		<option value="0">Everywhere</option>
		<?php $pages = get_pages();
		foreach($pages as $page)
			echo '<option value="'.$page->ID.'" '.($display_on == $page->ID ? 'selected="selected"' : '').'>'.($page->post_parent != 0 ? '-- ' : '').$page->post_title.'</option>';
		?>
	</select><br />
	<input type="image" src="<?php echo plugins_url('images/save.png', dirname(__FILE__)) ?>" />

</form>

<a href="https://www.info-d-74.com/en/produit/falling-things-pro-plugin-wordpress-2/" target="_blank">
	<p>Need more options? Look at Falling things Pro:</p>
	<img src="<?php echo plugins_url('images/wordpress_falling_things_pro_settings.png', dirname(__FILE__)) ?>" style="opacity: 0.5;" />
</a>