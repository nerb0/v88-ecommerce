<?php defined('BASEPATH') OR exit('No direct script access allowed');
	?>
<div class="edit-product">
	<svg id="closeEditBtn" class="modal-close edit-product-close" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">
		<path d="M1.5 1.5l12 12m-12 0l12-12"></path>
	</svg>
	<h3 class="text-dark">Add new Product</h3>
	<form action="/products/add" method="post" enctype="multipart/form-data">
		<input type="hidden" value="<?= $this->security->get_csrf_hash() ?>" name="<?= $this->security->get_csrf_token_name() ?>" />
		<label class="input-default input-dark" style="--label: 'Product Name'">
			<input type="text" name="name"  value="Test Product 1"/>
		</label>
		<label for="" class="input-default input-dark" style="--label: 'Product Description'">
			<textarea name="description" class="input-textarea btn-sharp btn-outline-primary-dark edit-product-description">Test Product 1 Description</textarea>
		</label>

		<div class="input-group">
			<label class="input-default input-dark" style="--label: 'Product Remaining Stocks'">
				<input type="number" name="quantity" min="0" value="24" />
			</label>
			<label class="input-default input-dark" style="--label: 'Product Price'">
				<input type="number" step="0.001" name="price" min="0.1" value="42.4"/>
			</label>
		</div>

		<div class="edit-product-category-group">
			<div class="select-category">
				<strong class="text-dark">Product Category: </strong>
				<select name="category" class="btn btn-md btn-outline-primary-dark mt">
<?php			foreach ($categories as $category) { ?>
					<option value="<?= $category["id"] ?>"><?= $category["name"] ?></option>
<?php			} ?>
				</select>
			</div><!--
			--><label class="input-default input-dark mt-md new-category" style="--label: 'or Add a new Category'">
				<input type="text" name="new_category" />
			</label>
		</div>
		<div class="mt-md">
			<h3 class="text-dark edit-image-header">Images:</h3>
			<label for="uploadImage" class="btn btn-md btn-outline-primary-dark upload-image-btn">
				<input type="file"  accept="image/*" class="hidden" id="uploadImage" multiple /> Upload
			</label>
			<ul class="edit-image-list ui-sortable" id="editImageList"></ul>
		</div>
		<input type="submit" class="btn btn-md btn-outline-primary-dark mt-md" value="Add Product"/>
		<input type="button" class="btn btn-md btn-outline-error mt-md modal-close" value="Cancel"/>
	</form>
</div>
