<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Model {
	const ADMIN_ROW_LIMIT = 8;
	const ROW_LIMIT = 20;
	const ORDER = [
		"sold ASC",
		"sold DESC",
		"products.price ASC",
		"products.price DESC",
		"products.name ASC",
		"products.name DESC",
		"products.id ASC",
		"products.id DESC",
		"products.created_at ASC",
		"products.created_at DESC",
		"products.updated_at ASC",
		"products.updated_at DESC",
	];
	const RULES = [
		"name" => [
			"field" => "name",
			"label" => "Product Name",
			"rules" => "trim|required|alpha_numeric_spaces",
		],
		"description" => [
			"field" => "description",
			"label" => "Product Description",
			"rules" => "trim|required|min_length[10]",
		],
		"quantity" => [
			"field" => "quantity",
			"label" => "Product Quantity",
			"rules" => "required|integer|greater_than[0]",
		],
		"price" => [
			"field" => "price",
			"label" => "Price",
			"rules" => "required|decimal|greater_than[0]",
		],
		"category" => [
			"field" => "category",
			"label" => "Product Category",
			"rules" => "integer|callback_valid_category|callback_is_category_needed",
			"errors" => [
				"valid_category" => "{field} is an invalid category",
				"is_category_needed" => "Please choose a category for the product."
			]
		],
		"new_category" => [
			"field" => "new_category",
			"label" => "New Product Category",
			"rules" => "trim|callback_valid_new_category|alpha_numeric_spaces",
			"errors" => [
				"valid_new_category" => "{field} already exists."
			]
		],
		"main_image" => [
			"field" => "main_image",
			"label" => "Main Image",
			"rules" => "required|callback_valid_main_image",
			"errors" => [
				"valid_main_image" => "{field} is invalid."
			]
		],
		// "images" => [
		// 	"field" => "images",
		// 	"label" => "Product Images",
		// 	"rules" => "callback_valid_images",
		// ],
		"new_images" => [
			"field" => "new_images",
			"label" => "Uploaded Images",
			"rules" => "callback_valid_new_images",
			"error" => [
				"valid_new_images" => "{field} is invalid.",
			],
		],
	];

	public function get($filter = []) {
		$values = [];
		$conditions = [];
		if (!empty($filter["search"])) {
			$conditions[] = "products.name LIKE ?";
			$values[] = "%{$filter["search"]}%";
		}
		if (!empty($filter["category"])) {
			$conditions[] = "category_id IN ?";
			$values[] = $filter["category"];
		}
		if (!empty($filter["min_price"])) {
			$conditions[] = "price >= ?";
			$values[] = $filter["min_price"];
		}
		if (!empty($filter["max_price"])) {
			$conditions[] = "price <= ?";
			$values[] = $filter["max_price"];
		}
		if (!empty($filter["order"]) && $filter["order"] < count(self::ORDER) && $filter["order"] > 0) {
			$order = "ORDER BY " . self::ORDER[$filter["order"]];
		} else {
			$order = "";
		}
		$where =(!empty($conditions)) ? "WHERE " . implode(" AND ", $conditions) : "";
		$query = "SELECT products.*
					, SUM(JSON_EXTRACT(order_items, CONCAT('$.\"', products.id,'\".quantity'))) as sold
					FROM products LEFT JOIN orders
						ON JSON_SEARCH(JSON_KEYS(order_items), 'one', products.id) IS NOT NULL
						{$where} GROUP BY products.id {$order}";
		return $this->db->query($query, $values)->result_array();
	}
	
	public function get_total_pages() {
		$query = "SELECT * FROM products";
		$result = $this->db->query($query)->result_array();
		return ceil(count($result) / self::ADMIN_ROW_LIMIT);
	}

	public function exists($product_id) {
		$query = "SELECT * FROM products WHERE id = ?";
		return !empty($this->db->query($query, [$product_id])->row_array());
	}

	public function get_by_id($product_id) {
		$query = "SELECT products.*
					,categories.name as category_name
					,SUM(JSON_EXTRACT(order_items, CONCAT('$.\"', products.id,'\".quantity'))) as sold
					FROM products LEFT JOIN orders
						ON JSON_SEARCH(JSON_KEYS(order_items), 'one', products.id) IS NOT NULL
					LEFT JOIN categories
						ON categories.id = category_id
					WHERE products.id = ?
					GROUP BY products.id";
		return $this->db->query($query, [$product_id])->row_array();
	}

	public function get_featured() {
		$order = self::ORDER[random_int(0, count(self::ORDER) - 1)];
		$query = "SELECT products.*
					,images->>\"$.main\" as image
					,categories.name as category_name
					,SUM(JSON_EXTRACT(order_items, CONCAT('$.\"', products.id,'\".quantity'))) as sold
					FROM products LEFT JOIN orders
						ON JSON_SEARCH(JSON_KEYS(order_items), 'one', products.id) IS NOT NULL
					INNER JOIN categories
						ON categories.id = category_id
					GROUP BY products.id
					ORDER BY {$order} LIMIT 5";
		return $this->db->query($query)->result_array();
	}

	public function get_banner() {
		$order = self::ORDER[1];
		$query = "SELECT products.*
					,images->>\"$.main\" as image
					,categories.name as category_name
					,SUM(JSON_EXTRACT(order_items, CONCAT('$.\"', products.id,'\".quantity'))) as sold
					FROM products LEFT JOIN orders
						ON JSON_SEARCH(JSON_KEYS(order_items), 'one', products.id) IS NOT NULL
					INNER JOIN categories
						ON categories.id = category_id
					GROUP BY products.id
					ORDER BY {$order} LIMIT 9";
		return $this->db->query($query)->result_array();
	}

	public function get_similar($category_id, $product_id) {
		$order = self::ORDER[random_int(0, count(self::ORDER) - 1)];
		$query = "SELECT products.*
					,images->>\"$.main\" as image
					,categories.name as category_name
					,SUM(JSON_EXTRACT(order_items, CONCAT('$.\"', products.id,'\".quantity'))) as sold
					FROM products LEFT JOIN orders
						ON JSON_SEARCH(JSON_KEYS(order_items), 'one', products.id) IS NOT NULL
					INNER JOIN categories
						ON categories.id = category_id
					WHERE category_id = ? AND NOT products.id = ?
					GROUP BY products.id
					ORDER BY {$order} LIMIT 5";
		return $this->db->query($query, [$category_id, $product_id])->result_array();
	}

	public function create($product) {
		$query = "INSERT INTO products(name, description, price, stock, category_id) VALUES(?,?,?,?,?)";
		$result = $this->db->query($query, [
			$product["name"],
			$product["description"],
			$product["price"],
			$product["quantity"],
			$product["category_id"],
		]);
		return $this->db->insert_id();
	}

	public function delete($product_id) {
		$query = "DELETE FROM products WHERE id = ?";
		$folder = bin2hex("product{$product_id}");
		$files = glob("assets/img/products/{$folder}/{,.}*", GLOB_BRACE); // get all file names
		foreach($files as $file) { 
			if(is_file($file)) {
				unlink($file); // delete file
			}
		}
		return $this->db->query($query, [$product_id]);
	}

	public function update($product_id, $product) {
		$query = "UPDATE products SET
					name = ?,
					description = ?,
					price = ?,
					stock = ?,
					category_id = ?,
					updated_at = NOW()
						WHERE id = ?";
		$result = $this->db->query($query, [
			$product["name"],
			$product["description"],
			$product["price"],
			$product["quantity"],
			$product["category_id"],
			$product_id
		]);
		return $result;
	}

	public function validate() {
		$rules = [
			self::RULES["name"],
			self::RULES["description"],
			self::RULES["quantity"],
			self::RULES["price"],
			self::RULES["category"],
			self::RULES["new_category"],
			self::RULES["new_images"],
			self::RULES["main_image"],
		];
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run()) {
			return "valid";
		} else {
			return validation_errors();
		}
	}

	public function upload_images($product_id, $main_image, $existing_image = [], $image_sort = []) {
		$base_dir = "assets/img/products/". bin2hex("product{$product_id}");
		if (!file_exists($base_dir)) mkdir($base_dir);
		$UPLOAD_CONFIG = [
			"upload_path" => "{$base_dir}",
			"allowed_types" => 'jpg|jpeg|png|gif',
		];
		$this->load->library("upload", $UPLOAD_CONFIG);

		$upload_images = [];
		$new_images = [];
		$old_images = [];

		foreach ($existing_image as $image_url) {
			// NOTE: This is a workaround for checking if the string is an integer since is_int() does not seem to work
			if (!ctype_digit(strval($main_image)) && $image_url == $main_image) $uploaded_images["main"] = $image_url;
			else if(!empty($image_sort)) $old_images[] = $image_url;
			else $uploaded_images["sub"][] = $image_url;
		}

		if (!empty($_FILES["new_images"]["name"])) {
			for($i = 0; $i < count($_FILES["new_images"]["name"]); $i++) {
				$file_ext = $ext = get_extension($_FILES["new_images"]["name"][$i]);
				// NOTE: This is to create a unique filename instead of just 'image(index).[ext]'
				$filename = bin2hex("image1");
				$target_name = "{$filename}.{$file_ext}";
				for ($file_count = 1; file_exists("{$base_dir}/{$target_name}"); $file_count++) {
					$filename = bin2hex("image{$file_count}");
					$target_name = "{$filename}.{$file_ext}";
				}
				// NOTE: CodeIgniter `upload` library only reads from the global variable $_FILES when uploading file
				// CodeIgniter's `do_upload` method does not accept a custom variable
				// hence, manually inserting each value of $_FILES to another key inside $_FILES seems to be the only way
				$_FILES["new_image"] = [
					"name" => $target_name,
					"type" => $_FILES["new_images"]["type"][$i],
					"tmp_name" => $_FILES["new_images"]["tmp_name"][$i],
					"error" => $_FILES["new_images"]["error"][$i],
					"size" => $_FILES["new_images"]["size"][$i],
				];
				if ($this->upload->do_upload("new_image")) {
					// NOTE: The additional "/" symbol is there since the "src" tag from images
					// is based on the current route not the BASEPATH/root directory of CodeIgniter	  	   
					$target_dir =  "/{$base_dir}/{$target_name}";
					if (ctype_digit(strval($main_image)) && $main_image == $i) $uploaded_images["main"] = $target_dir;
					else if(!empty($image_sort)) $new_images[] = $target_dir;
					else $uploaded_images["sub"][] = $target_dir;
				}
			}
		}

		if (!empty($image_sort)) {
			foreach($image_sort as $image) {
				$type = array_keys($image)[0];
				$index = $image[$type];
				if ($type == "new") {
					$uploaded_images["sub"][] = $new_images[$index];
				} else {
					$uploaded_images["sub"][] = $old_images[$index];
				}
			}
		}

		$query = "UPDATE products SET images = ? WHERE id = ?";
		$result = $this->db->query($query, [json_encode($uploaded_images), $product_id]);
		return $result;
	}
}
