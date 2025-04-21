# PrestaShop SaaS Setup Guide

This document provides instructions for setting up the PrestaShop SaaS application.

## Prerequisites

- PHP 8.1 or higher
- MySQL 5.6 or higher
- Apache or Nginx web server
- Composer (for dependency management)
- AWS account with appropriate permissions

## Local Development Setup

1. Clone the repository:
   ```
   git clone https://github.com/yourusername/prestashop-saas.git
   cd prestashop-saas
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

## Multi-tenant Configuration

To configure PrestaShop for multi-tenant SaaS operation:

1. Set up a domain routing system that directs different domains to the same PrestaShop installation

2. Modify the PrestaShop configuration to support multiple shops:
   - Go to Advanced Parameters > Multistore
   - Enable the multistore feature
   - Create a shop group for each tenant
   - Create shops within each shop group

3. Configure separate databases for each tenant (recommended for larger installations)

## AWS Deployment

See the [AWS Deployment Guide](aws-deployment.md) for detailed instructions on deploying to AWS.
