<?php defined('BASEPATH') OR exit('No direct script access allowed');
	?>
<div class="edit-product">
	<svg id="closeEditBtn" class="modal-close edit-product-close" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">
		<path d="M1.5 1.5l12 12m-12 0l12-12"></path>
	</svg>
	<h3 class="text-dark">Add new Product</h3>
	<form action="/products/preview_add" method="post" enctype="multipart/form-data" class="product-form" target="_blank">
		<input type="hidden" name="uploaded_images" id="uploadedImages"/>
		<input type="hidden" name="image_sort" id="imageSort"/>
		<input type="hidden" value="<?= $this->security->get_csrf_hash() ?>" name="<?= $this->security->get_csrf_token_name() ?>" />
		<label class="input-default input-dark" style="--label: 'Product Name'">
			<input type="text" name="name" />
		</label>
		<label for="" class="input-default input-dark" style="--label: 'Product Description'">
			<textarea name="description" class="input-textarea btn-sharp btn-outline-primary-dark edit-product-description"></textarea>
		</label>

		<div class="input-group">
			<label class="input-default input-dark" style="--label: 'Product Remaining Stocks'">
				<input type="number" name="quantity" min="0" />
			</label><!--
			--><label class="input-default input-dark" style="--label: 'Product Price'">
				<input type="number" step="0.01" name="price" min="0.01" />
			</label>
		</div>

		<div class="select-category">
			<strong class="text-dark">Product Category: </strong>
			<select name="category" class="btn btn-md btn-outline-primary-dark mt">
<?php		foreach ($categories as $category) { ?>
				<option value="<?= $category["id"] ?>"><?= $category["name"] ?></option>
<?php		} ?>
			</select>
		</div><!--
		--><label class="input-default input-dark mt-md new-category" style="--label: 'or Add a new Category'">
			<input type="text" name="new_category" />
		</label>
		<div class="mt-md">
			<h3 class="text-dark edit-image-header">Images:</h3>
			<label for="uploadImage" class="btn btn-md btn-outline-primary-dark upload-image-btn">
				<input type="file"  accept="image/*" class="hidden" id="uploadImage" multiple /> Upload
			</label>
			<ul class="edit-image-list ui-sortable" id="editImageList"></ul>
		</div>
		<input type="button" class="btn btn-md btn-outline-primary-dark mt-md submit-product-btn" data-field="products" data-url="/products/add" value="Add Product"/>
		<input type="submit" class="btn btn-md btn-outline-primary-dark mt-md" value="Preview"/>
		<input type="button" class="btn btn-md btn-outline-error mt-md modal-close" value="Cancel"/>
	</form>
</div>
