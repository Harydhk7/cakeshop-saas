<?php
/**
 * Cake Shop Categories Creation Script
 * 
 * This script creates the necessary categories for a cake shop.
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

echo "=== Creating Cake Shop Categories ===\n\n";

// Define cake shop categories
$categories = [
    [
        'name' => 'Birthday Cakes',
        'description' => 'Celebrate your special day with our delicious birthday cakes! Each cake is handcrafted with premium ingredients and can be customized with your favorite flavors and decorations.',
        'position' => 1,
        'image' => 'birthday_cakes.jpg'
    ],
    [
        'name' => 'Wedding Cakes',
        'description' => 'Make your wedding day even more memorable with our elegant wedding cakes. Our expert bakers create stunning multi-tiered cakes that taste as amazing as they look.',
        'position' => 2,
        'image' => 'wedding_cakes.jpg'
    ],
    [
        'name' => 'Cupcakes',
        'description' => 'Our gourmet cupcakes are perfect for any occasion! Available in a variety of flavors and decorations, these bite-sized treats are sure to delight everyone.',
        'position' => 3,
        'image' => 'cupcakes.jpg'
    ],
    [
        'name' => 'Pastries',
        'description' => 'Indulge in our selection of freshly baked pastries. From flaky croissants to delicate Danish pastries, our pastry selection offers something for every taste.',
        'position' => 4,
        'image' => 'pastries.jpg'
    ]
];

// Get the root category
$rootCategory = Category::getRootCategory();

// Create each category
foreach ($categories as $categoryData) {
    // Check if category already exists
    $categoryId = Category::searchByName(Context::getContext()->language->id, $categoryData['name'], true);
    
    if (!$categoryId) {
        echo "Creating category: {$categoryData['name']}\n";
        
        $category = new Category();
        $category->name = array((int)Configuration::get('PS_LANG_DEFAULT') => $categoryData['name']);
        $category->description = array((int)Configuration::get('PS_LANG_DEFAULT') => $categoryData['description']);
        $category->link_rewrite = array((int)Configuration::get('PS_LANG_DEFAULT') => Tools::link_rewrite($categoryData['name']));
        $category->id_parent = $rootCategory->id;
        $category->position = $categoryData['position'];
        $category->active = 1;
        
        if ($category->add()) {
            echo "  - Category created successfully\n";
            
            // Create placeholder image for category
            $imagePath = dirname(__FILE__) . '/category_images/' . $categoryData['image'];
            if (!file_exists(dirname($imagePath))) {
                mkdir(dirname($imagePath), 0755, true);
            }
            
            // Generate a placeholder image
            $backgroundColor = '#F8BBD0';
            $textColor = '#795548';
            $imageUrl = "https://via.placeholder.com/850x170/{$backgroundColor}/{$textColor}?text=" . urlencode($categoryData['name']);
            
            if (copy($imageUrl, $imagePath)) {
                $category->addImage($imagePath);
                echo "  - Category image added\n";
            } else {
                echo "  - Could not create category image\n";
            }
        } else {
            echo "  - Error: Could not create category\n";
        }
    } else {
        echo "Category already exists: {$categoryData['name']}\n";
    }
}

echo "\nCategories created successfully!\n";
