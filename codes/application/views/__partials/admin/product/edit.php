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
			<div name="category" class="btn btn-md btn-outline-primary-dark mt product-select-category dropdown">
				<input type="hidden" disabled name="updated_category_list" id="updatedCategories" />
				<input type="hidden" name="category" id="selectedCategory" value="<?= $product["category_id"] ?>" />
				<span class="category-main-name" id="mainCategoryText" data-id="<?= $product["category_id"] ?>"><?= $product["category_name"] ?></span>
				<div class="dropdown-toggle">
					<svg class="dropdown-toggle-btn dropdown-toggle-closed" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M7.5 1.5l-7 12h14l-7-12z" stroke-linejoin="round"></path>
					</svg>
				</div>
				<div class="dropdown-list transparent category-option-list">
					<div class="category-option" data-id="<?= $product["category_id"] ?>">
						<input type="text" readonly class="category-option-input" value="<?= $product["category_name"] ?>" data-id="<?= $product["category_id"] ?>" /><!--
						--><svg viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg" class="admin-edit-category">
							<path d="M.5 10.5l-.354-.354-.146.147v.207h.5zm10-10l.354-.354a.5.5 0 00-.708 0L10.5.5zm4 4l.354.354a.5.5 0 000-.708L14.5 4.5zm-10 10v.5h.207l.147-.146L4.5 14.5zm-4 0H0a.5.5 0 00.5.5v-.5zm.354-3.646l10-10-.708-.708-10 10 .708.708zm9.292-10l4 4 .708-.708-4-4-.708.708zm4 3.292l-10 10 .708.708 10-10-.708-.708zM4.5 14h-4v1h4v-1zm-3.5.5v-4H0v4h1z"></path>
						</svg><!--
						--><svg viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg" class="admin-delete-category">
							<path d="M4.5 3V1.5a1 1 0 011-1h4a1 1 0 011 1V3M0 3.5h15m-13.5 0v10a1 1 0 001 1h10a1 1 0 001-1v-10M7.5 7v5m-3-3v3m6-3v3"></path>
						</svg>
					</div>
<?php			foreach ($categories as $category) {
					if ($category["id"] != $product["category_id"]) { ?>
					<div class="category-option" id="<?= $category["id"] ?>">
						<input type="text" readonly class="category-option-input" value="<?= $category["name"] ?>" data-id="<?= $category["id"] ?>" /><!--
						--><svg viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg" class="admin-edit-category">
							<path d="M.5 10.5l-.354-.354-.146.147v.207h.5zm10-10l.354-.354a.5.5 0 00-.708 0L10.5.5zm4 4l.354.354a.5.5 0 000-.708L14.5 4.5zm-10 10v.5h.207l.147-.146L4.5 14.5zm-4 0H0a.5.5 0 00.5.5v-.5zm.354-3.646l10-10-.708-.708-10 10 .708.708zm9.292-10l4 4 .708-.708-4-4-.708.708zm4 3.292l-10 10 .708.708 10-10-.708-.708zM4.5 14h-4v1h4v-1zm-3.5.5v-4H0v4h1z"></path>
						</svg><!--
						--><svg viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg" class="admin-delete-category">
							<path d="M4.5 3V1.5a1 1 0 011-1h4a1 1 0 011 1V3M0 3.5h15m-13.5 0v10a1 1 0 001 1h10a1 1 0 001-1v-10M7.5 7v5m-3-3v3m6-3v3"></path>
						</svg>
					</div>
<?php			}
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
			<input type="button" class="btn btn-md btn-outline-secondary-dark mt-md submit-product-btn" data-field="products" data-url="/products/edit/<?= $product["id"] ?>" value="Update"/>
			<input type="submit" class="btn btn-md btn-outline-primary-dark mt-md" value="Preview" id="previewEditBtn"/>
			<input type="button" class="btn btn-md btn-outline-error mt-md modal-close" value="Cancel"/>
		</div>
	</form>
</div>
