#!/bin/bash
# Cake Shop Theme Installation Script

echo "=== Cake Dream Theme Installation ==="
echo ""

# Check if running as www-data or appropriate web server user
if [ "$(whoami)" != "www-data" ]; then
  echo "Warning: This script should ideally be run as the web server user (www-data)"
  echo "You may encounter permission issues."
  echo ""
fi

# Set variables
PS_ROOT=$(pwd)
THEME_DIR="$PS_ROOT/themes/cakedream"
IMPORT_DIR="$PS_ROOT/import"

# Check if PrestaShop is installed
if [ ! -f "$PS_ROOT/config/settings.inc.php" ]; then
  echo "Error: PrestaShop configuration file not found."
  echo "Make sure you're running this script from the PrestaShop root directory."
  exit 1
fi

echo "PrestaShop installation detected."
echo ""

# Install theme
echo "Installing Cake Dream theme..."

# Check if theme directory exists
if [ -d "$THEME_DIR" ]; then
  echo "Theme directory already exists."
else
  echo "Error: Theme directory not found at $THEME_DIR"
  echo "Make sure the theme files are in the correct location."
  exit 1
fi

# Set proper permissions
echo "Setting proper permissions..."
chmod -R 755 "$THEME_DIR"
chown -R www-data:www-data "$THEME_DIR" 2>/dev/null || echo "Could not change ownership (not running as root)"

echo "Theme files prepared."
echo ""

# Create cake shop categories
echo "Creating cake shop categories..."
php -f "$IMPORT_DIR/create_categories.php"
echo ""

# Import sample products
echo "Importing sample cake products..."
php -f "$IMPORT_DIR/import_products.php"
echo ""

echo "=== Installation Complete ==="
echo ""
echo "Next steps:"
echo "1. Go to PrestaShop back office > Design > Theme & Logo"
echo "2. Select and activate the 'Cake Dream' theme"
echo "3. Configure theme settings and customize as needed"
echo "4. Verify that sample products were imported correctly"
echo ""
echo "Enjoy your new cake shop theme!"
