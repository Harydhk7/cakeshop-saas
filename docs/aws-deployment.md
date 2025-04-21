# AWS Deployment Guide for PrestaShop SaaS

This guide provides instructions for deploying the PrestaShop SaaS application to AWS.

## Architecture Overview

The recommended AWS architecture for a PrestaShop SaaS application includes:

- **Amazon EC2** for web servers
- **Amazon RDS** for MySQL database
- **Amazon ElastiCache** for session storage and caching
- **Amazon S3** for media storage
- **Amazon CloudFront** for content delivery
- **Amazon Route 53** for DNS management
- **Elastic Load Balancer** for load balancing
- **Auto Scaling Group** for scalability

## Deployment Steps

### 1. Set Up VPC and Network Infrastructure

1. Create a VPC with public and private subnets
2. Set up Internet Gateway and NAT Gateway
3. Configure security groups and network ACLs

### 2. Database Setup

1. Create an Amazon RDS MySQL instance
   ```
   aws rds create-db-instance \
     --db-instance-identifier prestashop-db \
     --db-instance-class db.t3.medium \
     --engine mysql \
     --allocated-storage 20 \
     --master-username admin \
     --master-user-password <password> \
     --vpc-security-group-ids <security-group-id> \
     --db-subnet-group-name <subnet-group>
   ```

2. Create a database for PrestaShop
   ```
   mysql -h <rds-endpoint> -u admin -p
   CREATE DATABASE prestashop;
   ```

### 3. ElastiCache Setup

1. Create an ElastiCache Redis cluster for session storage
   ```
   aws elasticache create-cache-cluster \
     --cache-cluster-id prestashop-cache \
     --engine redis \
     --cache-node-type cache.t3.small \
     --num-cache-nodes 1 \
     --security-group-ids <security-group-id> \
     --cache-subnet-group-name <subnet-group>
   ```

### 4. S3 Bucket Setup

1. Create an S3 bucket for media storage
   ```
   aws s3 mb s3://prestashop-media
   ```

2. Configure bucket policy for public read access
   ```
   aws s3api put-bucket-policy --bucket prestashop-media --policy file://aws-config/s3-policy.json
   ```

### 5. EC2 Instance Setup

1. Launch EC2 instances using the provided CloudFormation template
   ```
   aws cloudformation create-stack \
     --stack-name prestashop-web \
     --template-body file://aws-config/ec2-template.yaml \
     --parameters ParameterKey=KeyName,ParameterValue=<your-key-pair>
   ```

2. The template will:
   - Launch instances in an Auto Scaling Group
   - Install required software
   - Clone the PrestaShop repository
   - Configure the web server
   - Connect to RDS and ElastiCache

### 6. Load Balancer Setup

1. Create an Application Load Balancer
   ```
   aws elbv2 create-load-balancer \
     --name prestashop-lb \
     --subnets <subnet-id-1> <subnet-id-2> \
     --security-groups <security-group-id>
   ```

2. Create target group and register instances
   ```
   aws elbv2 create-target-group \
     --name prestashop-targets \
     --protocol HTTP \
     --port 80 \
     --vpc-id <vpc-id>
   ```

### 7. CloudFront Setup

1. Create a CloudFront distribution pointing to the load balancer
   ```
   aws cloudfront create-distribution \
     --origin-domain-name <load-balancer-dns> \
     --default-cache-behavior ForwardedValues={QueryString=true}
   ```

### 8. Route 53 Setup

1. Create a hosted zone for your domain
   ```
   aws route53 create-hosted-zone \
     --name yourdomain.com \
     --caller-reference $(date +%s)
   ```

2. Create DNS records pointing to CloudFront
   ```
   aws route53 change-resource-record-sets \
     --hosted-zone-id <hosted-zone-id> \
     --change-batch file://aws-config/dns-records.json
   ```

## Post-Deployment Configuration

After deployment, you'll need to:

1. Access the PrestaShop installer through the load balancer URL
2. Complete the installation process
3. Configure PrestaShop for multi-tenant operation
4. Set up monitoring and alerts using CloudWatch
5. Configure backups for RDS and EC2 instances

## Scaling Considerations

- Use Auto Scaling Groups to automatically adjust the number of EC2 instances based on load
- Consider using read replicas for RDS to handle increased database load
- Implement a caching strategy using ElastiCache
- Use CloudFront to cache static assets and reduce load on your servers

## Security Best Practices

- Keep all systems updated with security patches
- Use IAM roles with least privilege
- Enable encryption for data at rest and in transit
- Implement WAF rules to protect against common web attacks
- Regularly audit security groups and network ACLs
