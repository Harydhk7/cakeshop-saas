# Cake Shop SaaS Setup Guide

This document provides instructions for setting up the Cake Shop SaaS application based on PrestaShop.

## Prerequisites

- PHP 8.1 or higher
- MySQL 5.6 or higher
- Apache or Nginx web server
- Composer (for dependency management)
- AWS account with appropriate permissions

## Local Development Setup

1. Clone the repository:
   ```
   git clone https://github.com/yourusername/cakeshop-saas.git
   cd cakeshop-saas
   ```

2. Install dependencies:
   ```
   cd src
   composer install
   ```

3. Configure your web server to point to the `src` directory

4. Create a database for PrestaShop

5. Access the installation wizard through your web browser:
   ```
   http://localhost/install
   ```

6. Follow the installation wizard instructions

7. After installation, remove the `install` directory for security

## Cake Shop Multi-tenant Configuration

To configure PrestaShop for a cake shop multi-tenant SaaS operation:

1. Set up a domain routing system that directs different cake shop domains to the same PrestaShop installation

2. Modify the PrestaShop configuration to support multiple cake shops:
   - Go to Advanced Parameters > Multistore
   - Enable the multistore feature
   - Create a shop group for each cake shop tenant (e.g., "Sweet Delights Bakery", "Chocolate Haven")
   - Create shops within each shop group

3. Configure separate databases for each cake shop tenant (recommended for larger installations)

4. Install and customize the cake shop theme for each tenant (see [Cake Shop Theme Guide](cake-shop-theme.md))

## AWS Free Tier Deployment

See the [AWS Free Tier Deployment Guide](aws-deployment.md) for detailed instructions on deploying to AWS using only free tier eligible resources.
