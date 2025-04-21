# Cake Dream Theme Customization Guide

This guide provides detailed instructions for customizing the Cake Dream theme for different cake shop tenants in your SaaS application.

## Basic Customization Options

### Logo Customization

Each cake shop tenant can have their own unique logo:

1. Go to Design > Theme & Logo
2. Select the shop from the multistore dropdown
3. Upload a new logo in the "Header logo" section
4. Optionally, upload different versions for email, invoice, and mobile

### Color Scheme Customization

The Cake Dream theme uses a default color palette optimized for cake shops:

- Primary color: Soft pink (#F8BBD0)
- Secondary color: Cream (#FFF8E1)
- Accent color: Chocolate brown (#795548)

To customize these colors for a specific tenant:

1. Create a custom CSS file for the tenant (e.g., `tenant1-custom.css`)
2. Add the following CSS variables:

```css
:root {
  --primary-color: #YOUR_PRIMARY_COLOR;
  --secondary-color: #YOUR_SECONDARY_COLOR;
  --accent-color: #YOUR_ACCENT_COLOR;
}
```

3. Upload this file to `themes/cakedream/assets/css/`
4. Add the CSS file to the theme.yml file under the tenant's specific theme configuration

### Font Customization

To change the fonts for a specific tenant:

1. Add custom font imports to the tenant's custom CSS file:

```css
@import url('https://fonts.googleapis.com/css2?family=YOUR_HEADING_FONT:wght@400;700&family=YOUR_BODY_FONT:wght@400;500;700&display=swap');

:root {
  --font-family: 'YOUR_BODY_FONT', sans-serif;
  --heading-font: 'YOUR_HEADING_FONT', serif;
}
```

2. Upload and configure as described in the color scheme section

## Advanced Customization

### Creating Tenant-Specific Theme Variations

For more extensive customization, you can create tenant-specific theme variations:

1. Duplicate the `cakedream` theme folder for each tenant (e.g., `cakedream-tenant1`)
2. Modify the `theme.yml` file to update the theme name and other details
3. Customize the CSS, JavaScript, and template files as needed
4. Assign the specific theme variation to each tenant's shop

### Custom Homepage Layouts

Each cake shop tenant can have a unique homepage layout:

1. Go to Design > Pages in the tenant's back office
2. Edit the homepage configuration
3. Arrange modules in the desired order
4. Add tenant-specific content blocks

### Custom Product Categories

Create specialized categories for each cake shop tenant:

1. Go to Catalog > Categories
2. Create categories specific to the tenant's offerings (e.g., "Gluten-Free Cakes", "Vegan Pastries")
3. Add custom descriptions and images
4. Assign products to these categories

## Tenant-Specific Customization Examples

### Example 1: Wedding Cake Specialist

For a tenant specializing in wedding cakes:

```css
:root {
  --primary-color: #E8F5E9; /* Soft mint */
  --secondary-color: #FFFFFF; /* White */
  --accent-color: #558B2F; /* Green */
  --font-family: 'Cormorant Garamond', serif;
  --heading-font: 'Cormorant Garamond', serif;
}
```

Homepage customization:
- Feature a wedding cake gallery
- Add a wedding cake consultation form
- Showcase wedding testimonials

### Example 2: Cupcake Shop

For a tenant specializing in cupcakes:

```css
:root {
  --primary-color: #E1F5FE; /* Light blue */
  --secondary-color: #FFECB3; /* Light yellow */
  --accent-color: #FF6F00; /* Orange */
  --font-family: 'Nunito', sans-serif;
  --heading-font: 'Pacifico', cursive;
}
```

Homepage customization:
- Feature a cupcake variety pack builder
- Add a cupcake of the month section
- Showcase colorful cupcake galleries

### Example 3: Traditional Bakery

For a tenant with a traditional bakery focus:

```css
:root {
  --primary-color: #EFEBE9; /* Beige */
  --secondary-color: #D7CCC8; /* Light brown */
  --accent-color: #4E342E; /* Dark brown */
  --font-family: 'Roboto Slab', serif;
  --heading-font: 'Playfair Display', serif;
}
```

Homepage customization:
- Feature artisan bread products
- Add a "baked fresh daily" section
- Showcase traditional baking techniques

## Customizing Product Displays

### Product Card Customization

Customize how products appear in category listings:

1. Create a tenant-specific CSS file
2. Add custom styles for product cards:

```css
.product-miniature {
  /* Custom styles for product cards */
}

.product-miniature .product-thumbnail img {
  /* Custom styles for product images */
}

.product-miniature .product-title {
  /* Custom styles for product titles */
}

.product-miniature .product-price-and-shipping {
  /* Custom styles for product prices */
}
```

### Product Page Customization

Customize the product detail pages:

1. Create tenant-specific template overrides in `themes/cakedream-tenant/templates/catalog/product.tpl`
2. Add custom sections such as:
   - Ingredient lists
   - Allergen information
   - Serving suggestions
   - Custom order options

## Mobile Optimization

Ensure your tenant customizations look great on mobile devices:

1. Add responsive styles to your tenant's custom CSS:

```css
@media (max-width: 767px) {
  /* Mobile-specific styles */
}

@media (min-width: 768px) and (max-width: 991px) {
  /* Tablet-specific styles */
}
```

2. Test all customizations on various device sizes
3. Optimize images for mobile loading speed

## Performance Optimization

Keep your customized themes performing well:

1. Minimize CSS and JavaScript files
2. Optimize custom images
3. Use browser caching
4. Enable PrestaShop's CCC (Combine, Compress, Cache) feature

## Applying Theme Updates

When updating the base Cake Dream theme:

1. Back up all tenant-specific customizations
2. Apply the theme update
3. Re-apply tenant customizations
4. Test thoroughly before deploying to production

## Support and Resources

For additional customization support:

- Email: support@cakeshopsaas.com
- Custom theme development services: https://cakeshopsaas.com/services
- Theme documentation: See the theme README.md file
