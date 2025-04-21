# Cake Shop SaaS Application

This repository contains a PrestaShop setup configured for a Cake Shop SaaS (Software as a Service) deployment on Amazon Web Services Free Tier.

## Overview

This project provides a multi-tenant PrestaShop installation that can be deployed as a SaaS solution for cake shops, bakeries, and pastry businesses, allowing you to host multiple shops from a single installation.

## Features

- Cake shop themed PrestaShop installation
- Multi-tenant architecture
- AWS Free Tier optimized configuration
- Automated deployment via GitHub Actions
- Tenant management system
- Custom cake shop product catalog

## Directory Structure

- `src/` - Contains the PrestaShop core files and cake shop theme
- `aws-config/` - Configuration files for AWS Free Tier deployment
- `docs/` - Documentation for setup and usage

## Local Development

### Prerequisites

- Docker and Docker Compose
- Git
- GitHub account

### Setup Instructions

1. Clone this repository:
   ```
   git clone https://github.com/yourusername/cakeshop-saas.git
   cd cakeshop-saas
   ```

2. Start the Docker containers:
   ```
   docker-compose up -d
   ```

3. Access PrestaShop:
   - Frontend: http://localhost:8080
   - Admin: http://localhost:8080/admin123 (credentials in docker-compose.yml)

## AWS Deployment

This PrestaShop installation is configured to be deployed on AWS Free Tier. See the deployment documentation in the `docs/aws-deployment.md` file for detailed instructions.

## Multi-Tenant Configuration

See the `docs/multi-tenant.md` file for detailed instructions on setting up and managing multiple cake shop tenants.

## License

PrestaShop is released under the [OSL-3.0 License](https://opensource.org/licenses/OSL-3.0).