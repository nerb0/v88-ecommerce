<?php defined('BASEPATH') OR exit('No direct script access allowed');
	?>
<div class="edit-product">
	<svg id="closeEditBtn" class="modal-close edit-product-close" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">
		<path d="M1.5 1.5l12 12m-12 0l12-12"></path>
	</svg>
	<h3 class="text-dark">Edit <?= $product["name"] ?>:</h3>
	<form action="/products/preview/" method="post" enctype="multipart/form-data" target="_blank" class="product-form">
		<input type="hidden" name="image_sort" id="imageSort" />
		<input type="hidden" value="<?= $this->security->get_csrf_hash() ?>" name="<?= $this->security->get_csrf_token_name() ?>" />
		<label class="input-default input-dark has-value" style="--label: 'Product Name'">
			<input type="text" name="name" value="<?= $product["name"] ?>" />
		</label>
		<label for="" class="input-default input-dark has-value" style="--label: 'Product Description'">
			<textarea name="description" class="input-textarea btn-sharp btn-outline-primary-dark edit-product-description"><?= $product["description"] ?></textarea>
		</label>

		<div class="input-group">
			<label class="input-default input-dark has-value" style="--label: 'Product Remaining Stocks'">
				<input type="number" name="quantity" min="0" value="<?= $product["stock"] ?>" />
			</label><!--
			--><label class="input-default input-dark has-value" style="--label: 'Product Price'">
				<input type="number" step="0.01" name="price" min="0.01" value="<?= $product["price"] ?>"/>
			</label>
		</div>

		<div class="select-category">
			<strong class="text-dark">Product Category: </strong>
			<div name="category" class="btn btn-md btn-outline-primary-dark mt product-select-category">
				<input type="hidden" name="selected_category_id" value="<?= $product["category_id"] ?>"/>
				<input type="hidden" name="selected_category_name" value="<?= $product["category_name"] ?>"/>
				<div class="category-value"><?= $product["category_name"] ?></div>
				<div class="category-dropdown">
<?php			foreach ($categories as $category) {
					if ($category["id"] != $product["category_id"]) { ?>
					<div class="category-option" id="<?= $category["id"] ?>">
						<input type="hidden" name="category_id[]" value="<?= $category["id"] ?>"/>
						<input type="hidden" name="category_name[]" value="<?= $category["name"] ?>"/>
						<?= $category["name"] ?>
					</div>
<?php				}
				} ?>
				</div>
			</div>
		</div><!--
		--><label class="input-default input-dark mt-md new-category" style="--label: 'or Add a new Category'">
			<input type="text" name="new_category" />
		</label>
		<div class="mt-md">
			<h3 class="text-dark edit-image-header">Images:</h3>
			<label for="uploadImage" class="btn btn-md btn-outline-primary-dark upload-image-btn">
				<input type="file"  accept="image/*" class="hidden" id="uploadImage" multiple /> Upload
			</label>
			<ul class="edit-image-list ui-sortable" id="editImageList">
				<li class="edit-image-row">
					<input type="hidden" name="images[]" value="<?= $product["images"]["main"] ?>"/>
					<svg class="edit-image-drag" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">
						<path d="M9.5 3a.5.5 0 110-1 .5.5 0 010 1zm0 5a.5.5 0 110-1 .5.5 0 010 1zm0 5a.5.5 0 110-1 .5.5 0 010 1zm-4-10a.5.5 0 110-1 .5.5 0 010 1zm0 5a.5.5 0 110-1 .5.5 0 010 1zm0 5a.5.5 0 110-1 .5.5 0 010 1z"></path>
					</svg><!--
					--><img src="<?= $product["images"]["main"] ?>" alt="" class="edit-image-preview" /><!--
					--><p class="edit-image-name"><?= get_basename($product["images"]["main"]) ?></p><!--
					--><svg class="edit-image-remove" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">
						<path d="M4 .5H1.5a1 1 0 00-1 1V4M6 .5h3m2 0h2.5a1 1 0 011 1V4M.5 6v3m14-3v3m-14 2v2.5a1 1 0 001 1H4M14.5 11v2.5a1 1 0 01-1 1H11m-7-7h7m-5 7h3"></path>
					</svg><!--
					--><label for="0">
						<input type="radio" checked name="main_image" class="edit-image-set-main" value="<?= $product["images"]["main"] ?>" id="0"/> main
					</label>
				</li>
<?php		if(!empty($product["images"]["sub"])) {
				foreach($product["images"]["sub"] as $index => $url) { ?>
				<li class="edit-image-row">
					<input type="hidden" name="images[]" value="<?= $url ?>"/>
					<svg class="edit-image-drag" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">
						<path d="M9.5 3a.5.5 0 110-1 .5.5 0 010 1zm0 5a.5.5 0 110-1 .5.5 0 010 1zm0 5a.5.5 0 110-1 .5.5 0 010 1zm-4-10a.5.5 0 110-1 .5.5 0 010 1zm0 5a.5.5 0 110-1 .5.5 0 010 1zm0 5a.5.5 0 110-1 .5.5 0 010 1z"></path>
					</svg><!--
					--><img src="<?= $url ?>" alt="" class="edit-image-preview" /><!--
					--><p class="edit-image-name"><?= get_basename($url) ?></p><!--
					--><svg class="edit-image-remove" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">
						<path d="M4 .5H1.5a1 1 0 00-1 1V4M6 .5h3m2 0h2.5a1 1 0 011 1V4M.5 6v3m14-3v3m-14 2v2.5a1 1 0 001 1H4M14.5 11v2.5a1 1 0 01-1 1H11m-7-7h7m-5 7h3"></path>
					</svg><!--
					--><label for="<?= $index + 1 ?>">
						<input type="radio" name="main_image" class="edit-image-set-main" value="<?= $url ?>" id="<?= $index + 1 ?>"/> main
					</label>
				</li>
<?php			}
			} ?>
			</ul>
		</div>
		<div class="text-right">
			<input type="button" class="btn btn-md btn-outline-secondary-dark mt-md submit-product-btn" data-url="/products/edit/<?= $product["id"] ?>" value="Update"/>
			<input type="submit" class="btn btn-md btn-outline-primary-dark mt-md" value="Preview" id="previewEditBtn"/>
			<input type="button" class="btn btn-md btn-outline-error mt-md modal-close" value="Cancel"/>
		</div>
	</form>
</div>
