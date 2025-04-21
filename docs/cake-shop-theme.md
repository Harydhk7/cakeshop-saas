# Cake Shop Theme Customization Guide

This guide provides instructions for customizing the PrestaShop theme for a cake shop SaaS application.

## Finding and Installing a Cake Shop Theme

### Option 1: Use a Free Cake Shop Theme

1. Look for free cake shop themes on the following resources:
   - [PrestaShop Official Marketplace](https://addons.prestashop.com/en/3-templates-prestashop)
   - [ThemeForest](https://themeforest.net/category/ecommerce/prestashop)
   - [TemplateMonster](https://www.templatemonster.com/prestashop-themes/)

2. Download the theme ZIP file

3. Install the theme through the PrestaShop back office:
   - Go to Design > Theme & Logo
   - Click "Add new theme"
   - Upload the ZIP file
   - Click "Save"

### Option 2: Customize the Default Theme

If you prefer to customize the default theme, follow these steps:

1. Create a child theme based on the Classic theme:
   - Copy the `/themes/classic` directory to `/themes/cakeshop`
   - Edit the `theme.yml` file in the new directory to update the theme name and other details

2. Customize the theme files:
   - Edit the CSS files in `/themes/cakeshop/assets/css`
   - Modify the template files in `/themes/cakeshop/templates`
   - Update images in `/themes/cakeshop/assets/img`

## Cake Shop Theme Customization

### 1. Color Scheme

For a cake shop, consider using a warm and inviting color palette:

- Primary color: Soft pink (#F8BBD0) or pastel blue (#BBDEFB)
- Secondary color: Cream (#FFF8E1) or light mint (#E0F2F1)
- Accent color: Chocolate brown (#795548) or berry red (#C2185B)

Update the colors in the theme's CSS files:

```css
:root {
  --primary-color: #F8BBD0;
  --secondary-color: #FFF8E1;
  --accent-color: #795548;
}
```

### 2. Logo and Branding

1. Create a cake shop logo using a tool like Canva or Adobe Illustrator
2. Upload the logo through the PrestaShop back office:
   - Go to Design > Theme & Logo
   - Upload your logo in the "Header logo" section
   - Optionally, upload different versions for email, invoice, and mobile

### 3. Homepage Customization

1. Create a compelling banner showcasing your best cakes
2. Add featured categories like:
   - Birthday Cakes
   - Wedding Cakes
   - Cupcakes
   - Pastries
   - Custom Cakes

3. Configure the homepage modules through the PrestaShop back office:
   - Go to Modules > Module Manager
   - Find and configure modules like "Featured Products", "Image slider", etc.

### 4. Product Images and Descriptions

1. Use high-quality images of cakes and pastries
2. Write detailed product descriptions that include:
   - Ingredients
   - Flavors
   - Serving size
   - Storage instructions
   - Allergen information

### 5. Custom CMS Pages

Create the following custom pages for your cake shop:

1. **About Us**: Share your cake shop's story and values
2. **Custom Orders**: Provide information about custom cake orders
3. **Delivery Information**: Explain delivery zones, times, and fees
4. **FAQ**: Answer common questions about ordering, delivery, etc.

To create these pages:
- Go to Design > Pages
- Click "Add new page"
- Fill in the content and save

## Multi-Tenant Theme Customization

For a SaaS application with multiple cake shop tenants, you can allow each tenant to customize their theme:

1. Enable theme customization per shop:
   - Go to Advanced Parameters > Multistore
   - Select a shop
   - Go to Design > Theme & Logo
   - Allow theme customization for this specific shop

2. Create tenant-specific theme variations:
   - Create a copy of the base theme for each tenant
   - Customize colors, logos, and layouts based on tenant preferences
   - Apply the theme to the tenant's shop

## Sample Cake Products

Create the following sample product categories and products for your cake shop:

1. **Birthday Cakes**
   - Chocolate Fudge Cake
   - Vanilla Buttercream Cake
   - Red Velvet Cake
   - Rainbow Layer Cake

2. **Wedding Cakes**
   - Classic Tiered Wedding Cake
   - Rustic Naked Cake
   - Elegant Fondant Cake
   - Modern Geometric Cake

3. **Cupcakes**
   - Chocolate Cupcakes
   - Vanilla Cupcakes
   - Red Velvet Cupcakes
   - Specialty Cupcakes

4. **Pastries**
   - Croissants
   - Danish Pastries
   - Eclairs
   - Macarons

To add these products:
- Go to Catalog > Products
- Click "Add new product"
- Fill in the product details and save
