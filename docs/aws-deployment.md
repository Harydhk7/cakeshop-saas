# AWS Free Tier Deployment Guide for Cake Shop SaaS

This guide provides instructions for deploying the Cake Shop SaaS application to AWS using only free tier eligible resources.

## Architecture Overview

The AWS Free Tier architecture for our Cake Shop SaaS application includes:

- **Amazon EC2 t2.micro** instance (free tier eligible) for web server
- **Amazon RDS MySQL db.t2.micro** (free tier eligible) for database
- **Amazon S3** for media storage (free tier includes 5GB storage)
- **Amazon Route 53** for DNS management

## Deployment Steps

### 1. Set Up VPC and Network Infrastructure

1. Create a VPC with public and private subnets
2. Set up Internet Gateway and NAT Gateway
3. Configure security groups and network ACLs

### 2. Database Setup

1. Create an Amazon RDS MySQL instance (free tier eligible)
   ```
   aws rds create-db-instance \
     --db-instance-identifier cakeshop-db \
     --db-instance-class db.t2.micro \
     --engine mysql \
     --allocated-storage 20 \
     --master-username admin \
     --master-user-password <password> \
     --vpc-security-group-ids <security-group-id> \
     --db-subnet-group-name <subnet-group>
   ```

2. Create a database for Cake Shop
   ```
   mysql -h <rds-endpoint> -u admin -p
   CREATE DATABASE cakeshop;
   ```

### 3. S3 Bucket Setup (Free Tier Eligible)

1. Create an S3 bucket for media storage
   ```
   aws s3 mb s3://cakeshop-media
   ```

2. Configure bucket policy for public read access
   ```
   aws s3api put-bucket-policy --bucket cakeshop-media --policy file://aws-config/s3-policy.json
   ```

### 4. EC2 Instance Setup (Free Tier Eligible)

1. Launch a single t2.micro EC2 instance using the provided CloudFormation template
   ```
   aws cloudformation create-stack \
     --stack-name cakeshop-web \
     --template-body file://aws-config/ec2-template.yaml \
     --parameters ParameterKey=KeyName,ParameterValue=<your-key-pair>
   ```

2. The template will:
   - Launch a t2.micro instance (free tier eligible)
   - Install required software
   - Clone the Cake Shop repository
   - Configure the web server
   - Connect to RDS

### 5. Domain Setup (Optional)

1. If you have a domain name, you can create a hosted zone in Route 53
   ```
   aws route53 create-hosted-zone \
     --name yourcakeshop.com \
     --caller-reference $(date +%s)
   ```

2. Create DNS records pointing to your EC2 instance
   ```
   aws route53 change-resource-record-sets \
     --hosted-zone-id <hosted-zone-id> \
     --change-batch file://aws-config/dns-records.json
   ```

## Post-Deployment Configuration

After deployment, you'll need to:

1. Access the Cake Shop PrestaShop installer through the EC2 instance's public IP or domain
2. Complete the installation process
3. Configure PrestaShop for multi-tenant operation
4. Install and configure the cake shop theme
5. Set up sample cake products and categories
6. Configure automated backups for your RDS database

## Free Tier Optimization Tips

- Monitor your usage to stay within free tier limits
- Set up billing alerts to avoid unexpected charges
- Use S3 lifecycle policies to manage storage costs
- Optimize images and assets to reduce storage requirements

## Security Best Practices

- Keep all systems updated with security patches
- Use IAM roles with least privilege
- Enable encryption for data at rest and in transit
- Configure security groups to allow only necessary traffic
- Implement strong passwords and enable MFA for AWS accounts
