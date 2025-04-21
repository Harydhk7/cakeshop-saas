@echo off
REM Cake Shop Theme Installation Script for Windows

echo === Cake Dream Theme Installation ===
echo.

REM Set variables
set PS_ROOT=%CD%
set THEME_DIR=%PS_ROOT%\themes\cakedream
set IMPORT_DIR=%PS_ROOT%\import

REM Check if PrestaShop is installed
if not exist "%PS_ROOT%\config\settings.inc.php" (
  echo Error: PrestaShop configuration file not found.
  echo Make sure you're running this script from the PrestaShop root directory.
  exit /b 1
)

echo PrestaShop installation detected.
echo.

REM Install theme
echo Installing Cake Dream theme...

REM Check if theme directory exists
if exist "%THEME_DIR%" (
  echo Theme directory already exists.
) else (
  echo Error: Theme directory not found at %THEME_DIR%
  echo Make sure the theme files are in the correct location.
  exit /b 1
)

echo Theme files prepared.
echo.

REM Create cake shop categories
echo Creating cake shop categories...
php -f "%IMPORT_DIR%\create_categories.php"
echo.

REM Import sample products
echo Importing sample cake products...
php -f "%IMPORT_DIR%\import_products.php"
echo.

echo === Installation Complete ===
echo.
echo Next steps:
echo 1. Go to PrestaShop back office ^> Design ^> Theme ^& Logo
echo 2. Select and activate the 'Cake Dream' theme
echo 3. Configure theme settings and customize as needed
echo 4. Verify that sample products were imported correctly
echo.
echo Enjoy your new cake shop theme!

pause
