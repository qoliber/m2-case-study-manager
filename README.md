# Qoliber Case Study Manager for Magento 2

This module provides case study management functionality for Magento 2, allowing merchants to showcase their successful projects and implementations. The module is designed to work with both Mage-OS and Adobe Commerce platforms.

## Features

- ⚠️ **Hyva Compatible Only** ⚠️
- Case Study management system
- Advanced search functionality
- Vertical market categorization
- Business type classification (B2B/B2C)
- Regional focus tracking
- Extension vendor tracking
- RESTful API for seamless integration

## Installation

### Via Composer (Recommended)

1. Add the repository to your Magento 2 `composer.json`:

```bash
composer require qoliber/m2-case-study-manager
```

2. Enable the module:

```bash
bin/magento module:enable Qoliber_CaseStudyManager
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento setup:static-content:deploy -f
bin/magento cache:flush
```

## Configuration

1. Go to Stores > Configuration > Qoliber > Case Study Manager
2. Configure the following sections:
   - Magento Versions (Adobe Commerce, Mage-OS)
   - Frontend Types (Hyva, Luma, PWA)
   - Vertical Markets
   - Customer Focus Types
   - Regional Focus Options
   - Available Integrations
   - Extension Vendors
3. Configure OpenSearch settings
4. Click "Test Connection" to assure the index in OpenSearch is created

## REST API Documentation

The module exposes several REST API endpoints for integration purposes.

### 1. Search Case Studies

**Endpoint:** `POST /rest/V1/casestudy/search`

**Headers:**
- Content-Type: `application/json`

**Request Body Example:**
```json
{
    "filters": {
        "magentoVersion": "Mage-OS",
        "frontendType": "Hyva Based",
        "countryId": "PL",
        "verticalTypes": "Books",
        "customerFocus": "B2C",
        "regionalFocus": "Local",
        "integrations": ["DPL", "Microsoft SAP"],
        "extension_vendors": ["qoliber"]
    }
}
```

### 2. Get Single Case Study

**Endpoint:** `GET /rest/V1/casestudy/:url_key`

Example: `GET /rest/V1/casestudy/awesome-project`

### 3. Get Search Configuration

**Endpoint:** `GET /rest/V1/casestudy/config`

Returns available options for search filters including:
- Magento versions
- Frontend types
- Country list
- Vertical markets
- Customer focus types
- Regional focus options
- Available integrations
- Extension vendors

## Support

For support and questions, please contact:
- Email: extensions@qoliber.com
- Website: https://qoliber.com

## License

This module is licensed under the MIT License - see the LICENSE file for details.

## Version

Current version: 1.1.0

## Authors

- Jakub Winkler (jwinkler@qoliber.com)

# Release Notes

1.1.0
- added an open search configuration section in the module (for easlticsuite compatibility, if ES module was present, this module didn't work)
- removed data patches

1.0.0
- initial module release
