# Cake Dream Theme Installation Guide

This guide provides step-by-step instructions for installing and configuring the Cake Dream theme for your PrestaShop SaaS application.

## Prerequisites

Before installing the theme, make sure you have:

1. A working PrestaShop installation (version 1.7 or higher)
2. Admin access to the PrestaShop back office
3. FTP access or direct file system access to your PrestaShop installation

## Installation Methods

### Method 1: Using the Installation Scripts

The easiest way to install the Cake Dream theme is to use the provided installation scripts:

#### For Linux/Unix Systems:

1. Navigate to your PrestaShop root directory:
   ```
   cd /path/to/prestashop
   ```

2. Run the installation script:
   ```
   bash src/install_cake_theme.sh
   ```

3. Follow the on-screen instructions to complete the installation.

#### For Windows Systems:

1. Navigate to your PrestaShop root directory in File Explorer.

2. Double-click on `src/install_cake_theme.bat` to run the installation script.

3. Follow the on-screen instructions to complete the installation.

### Method 2: Manual Installation

If you prefer to install the theme manually, follow these steps:

1. Copy the `cakedream` folder to your PrestaShop's `themes` directory.

2. Go to the PrestaShop back office.

3. Navigate to Design > Theme & Logo.

4. Click "Add new theme".

5. The Cake Dream theme should appear in the list. Click "Use this theme".

6. Import sample products:
   - Go to Advanced Parameters > Import
   - Select "Products" from the dropdown
   - Upload the `src/import/cake_products.csv` file
   - Follow the import wizard to map the fields
   - Import the products

## Post-Installation Configuration

After installing the theme, follow these steps to configure it:

### 1. Configure Theme Settings

1. Go to Design > Theme & Logo > Theme Customization

2. Customize the following settings:
   - Logo
   - Colors
   - Fonts
   - Layout

### 2. Set Up Homepage Modules

1. Go to Modules > Module Manager

2. Configure the following modules for the homepage:
   - Image slider: Add cake-themed banners
   - Featured products: Display your best cake products
   - Custom text blocks: Add welcome messages and special offers

### 3. Configure Categories

1. Go to Catalog > Categories

2. Edit each cake category to add:
   - Category image
   - Description
   - SEO information

### 4. Add Sample Products

If you didn't use the automatic import, you can manually add cake products:

1. Go to Catalog > Products

2. Click "Add new product"

3. Fill in the product details using the information from `docs/sample-products.md`

## Troubleshooting

### Theme Not Appearing in the List

If the theme doesn't appear in the theme list:

1. Check that the theme folder is in the correct location (`themes/cakedream`)
2. Verify that the theme.yml file is properly formatted
3. Clear the PrestaShop cache:
   - Go to Advanced Parameters > Performance
   - Click "Clear cache"

### Images Not Displaying Correctly

If product or category images are not displaying correctly:

1. Check the image permissions (should be 644 or 755)
2. Regenerate thumbnails:
   - Go to Design > Image Settings
   - Click "Regenerate thumbnails"

### Import Errors

If you encounter errors during product import:

1. Check the CSV file format and encoding (should be UTF-8)
2. Try importing fewer products at a time
3. Check the PrestaShop error logs for specific error messages

## Support

For additional support with the Cake Dream theme:

- Email: support@cakeshopsaas.com
- Documentation: See the theme README.md file
