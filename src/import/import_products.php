<?php
/**
 * Cake Shop Product Import Script
 * 
 * This script helps automate the import of sample cake shop products
 * into PrestaShop.
 */

// Set up the environment
define('_PS_ADMIN_DIR_', dirname(__FILE__) . '/../admin');
require_once(dirname(__FILE__) . '/../config/config.inc.php');
require_once(dirname(__FILE__) . '/../init.php');
require_once(_PS_ADMIN_DIR_ . '/functions.php');

// Check if user is authenticated as admin
if (!Context::getContext()->employee->isLoggedBack()) {
    echo "Error: You must be logged in as an admin to run this script.\n";
    exit(1);
}

echo "=== Cake Shop Product Import ===\n\n";

// Create cake shop categories if they don't exist
createCakeCategories();

// Import products from CSV
importCakeProducts();

// Update product images
updateProductImages();

echo "\nImport completed successfully!\n";

/**
 * Create cake shop categories
 */
function createCakeCategories() {
    echo "Creating cake shop categories...\n";
    
    $categories = [
        'Birthday Cakes' => 'Delicious cakes perfect for birthday celebrations',
        'Wedding Cakes' => 'Elegant cakes for your special day',
        'Cupcakes' => 'Individual treats for any occasion',
        'Pastries' => 'Flaky and delicious pastries for breakfast or dessert'
    ];
    
    $rootCategory = Category::getRootCategory();
    
    foreach ($categories as $name => $description) {
        // Check if category already exists
        $categoryId = Category::searchByName(Context::getContext()->language->id, $name, true);
        
        if (!$categoryId) {
            echo "  - Creating category: $name\n";
            
            $category = new Category();
            $category->name = array((int)Configuration::get('PS_LANG_DEFAULT') => $name);
            $category->description = array((int)Configuration::get('PS_LANG_DEFAULT') => $description);
            $category->link_rewrite = array((int)Configuration::get('PS_LANG_DEFAULT') => Tools::link_rewrite($name));
            $category->id_parent = $rootCategory->id;
            $category->active = 1;
            
            if (!$category->add()) {
                echo "    Error: Could not create category $name\n";
            }
        } else {
            echo "  - Category already exists: $name\n";
        }
    }
    
    echo "Categories created successfully.\n\n";
}

/**
 * Import cake products from CSV
 */
function importCakeProducts() {
    echo "Importing cake products from CSV...\n";
    
    $csvFile = dirname(__FILE__) . '/cake_products.csv';
    
    if (!file_exists($csvFile)) {
        echo "Error: CSV file not found at $csvFile\n";
        return;
    }
    
    // Set up the import parameters
    $importConfig = [
        'entity' => 'Product',
        'csv' => $csvFile,
        'separator' => ';',
        'multiple_value_separator' => ',',
        'skip' => 1, // Skip header row
    ];
    
    // Initialize the import
    $importHandler = new AdminImportController();
    $importHandler->initializeImport($importConfig);
    
    // Run the import
    $importHandler->importData();
    
    echo "Products imported successfully.\n\n";
}

/**
 * Update product images with placeholder images
 */
function updateProductImages() {
    echo "Updating product images...\n";
    
    // Get all products
    $products = Product::getProducts(Context::getContext()->language->id, 0, 0, 'id_product', 'ASC');
    
    foreach ($products as $product) {
        echo "  - Updating images for product: {$product['name']}\n";
        
        // Generate a placeholder image based on product name
        $productName = urlencode($product['name']);
        $backgroundColor = '#F8BBD0';
        $textColor = '#795548';
        
        if (strpos(strtolower($product['name']), 'chocolate') !== false) {
            $backgroundColor = '#795548';
            $textColor = '#FFFFFF';
        } elseif (strpos(strtolower($product['name']), 'vanilla') !== false) {
            $backgroundColor = '#FFF8E1';
        } elseif (strpos(strtolower($product['name']), 'red velvet') !== false) {
            $backgroundColor = '#FFCDD2';
        } elseif (strpos(strtolower($product['name']), 'rainbow') !== false) {
            $backgroundColor = '#E1F5FE';
        }
        
        $imageUrl = "https://via.placeholder.com/800x800/{$backgroundColor}/{$textColor}?text={$productName}";
        
        // Download and add the image to the product
        $tempFile = tempnam(sys_get_temp_dir(), 'cake_img_');
        if (copy($imageUrl, $tempFile)) {
            $productObj = new Product($product['id_product']);
            $productObj->addImage($tempFile);
            unlink($tempFile);
        } else {
            echo "    Error: Could not download image for {$product['name']}\n";
        }
    }
    
    echo "Product images updated successfully.\n";
}
