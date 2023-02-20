<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Model {
	const ERRORS = [

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
				"valid_category" => "{field} is an invalid category"
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
			"rules" => "required",
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

	public function get_all($page = 0) {
		$query = "SELECT products.*
					, SUM(JSON_EXTRACT(bought_products, CONCAT('$.\"', products.id,'\".quantity'))) as sold
					FROM products LEFT JOIN orders
						ON JSON_SEARCH(JSON_KEYS(bought_products), 'one', products.id) IS NOT NULL
						GROUP BY products.id";
		return $this->db->query($query, [$page])->result_array();
	}

	public function get_by_id($product_id) {
		$query = "SELECT * FROM users WHERE id = ?";
		return $this->db->query($query, [$product_id])->row_array();
	}

	public function create($product) {
		$query = "INSERT INTO products(name, description, price, quantity, category_id) VALUES(?,?,?,?,?)";
		$result = $this->db->query($query, [
			$product["name"],
			$product["description"],
			$product["price"],
			$product["quantity"],
			$product["category"],
		]);
		return $this->db->insert_id();
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

	public function upload_images($product_id, $main_image, $existing_image = []) {
		$base_dir = "/assets/img/products/". bin2hex("product{$product_id}");
		if (!file_exists($base_dir)) mkdir($base_dir);

		$uploaded_images = [];
		for($i = 0; $i < count($_FILES["new_images"]["name"]); $i++) {
			$file_ext = $ext = get_extension($_FILES["new_images"]["name"][$i]);
			// NOTE: This is to create a unique filename instead of just 'image(index).[ext]'
			$filename = bin2hex("image1");
			$target_name = "{$filename}.{$file_ext}";
			for ($file_count = 1; file_exists("{$base_dir}/{$target_name}"); $file_count++) {
				$filename = bin2hex("image{$file_count}");
				$target_name = "{$filename}.{$file_ext}";
			}

			// NOTE: CodeIgniter only reads from the global variable $_FILES when uploading file
			// CodeIgniter's `do_upload` method does not accept a custom variable
			// hence, manually insert each value of $_FILES to another key inside $_FILES
			$_FILES["new_image"] = [
				"name" => $target_name,
				"type" => $_FILES["new_images"]["type"][$i],
				"tmp_name" => $_FILES["new_images"]["tmp_name"][$i],
				"error" => $_FILES["new_images"]["error"][$i],
				"size" => $_FILES["new_images"]["size"][$i],
			];
			$UPLOAD_CONFIG = [
				// NOTE: The additional dot is there since codeigniter's upload_path already reads from the
				// root workspace folder while the path for the images loaded in HTML is based on the current route
				"upload_path" => ".{$base_dir}",
				"allowed_types" => 'jpg|jpeg|png|gif',
			];
			$this->load->library("upload", $UPLOAD_CONFIG);
			if ($this->upload->do_upload("new_image")) {
				if (ctype_digit(strval($main_image)) && $main_image == $i) $uploaded_images["main"] = "{$base_dir}/{$target_name}";
				else $uploaded_images["sub"][] = "{$base_dir}/{$target_name}";
			}
		}

		foreach ($existing_image as $image_url) {
			if (!ctype_digit(strval($main_image)) && $image_url == $main_image) $uploaded_images["main"] = $image_url;
		}
		$query = "UPDATE products SET images = ? WHERE id = ?";
		$result = $this->db->query($query, [json_encode($uploaded_images), $product_id]);
		return $result;
	}
}
