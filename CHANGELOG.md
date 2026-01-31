# Changelog

All notable changes to the Qoliber Case Study Manager module will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

## [1.1.6] - 2025-07-09

### Changed
- Module updates and dependency adjustments
- Compatibility improvements with latest Qoliber Core module

## [1.1.0] - 2025-05-11

### Added
- OpenSearch configuration section for improved search functionality and ElasticSuite compatibility
- Test connection functionality for OpenSearch index validation
- Resolved conflict when ElasticSuite module was present

### Removed
- Data patches to improve installation and upgrade process

## [1.0.0] - 2025-05-01

### Added
- Initial release of Case Study Manager module
- Comprehensive case study management system with admin UI grid and form
- Advanced search functionality powered by OpenSearch integration
- Customer association system linking case studies to Magento customers
- Image upload functionality for store logos and screenshots gallery
- Markdown editor support for case study summary and content fields
- SEO-friendly URL key generation with meta title, description, and keywords fields
- Multi-dimensional categorization system:
  - Magento version tracking (Adobe Commerce, Mage-OS)
  - Frontend type classification (Hyva, Luma, PWA)
  - Vertical market selection (Books, Fashion, Electronics, etc.)
  - Customer focus categorization (B2B, B2C)
  - Regional focus options (Local, Regional, Global)
  - Country selection using Magento's country directory
- Extension vendor tracking with multi-select capability
- Third-party integrations management (DPL, SAP, payment gateways, etc.)
- Hosting stack information tracking
- Position-based ordering system for case studies
- Active/inactive status toggle for publishing control
- UUID generation for unique case study identification
- RESTful API endpoints:
  - POST /rest/V1/casestudy/search - Advanced search with multiple filters
  - GET /rest/V1/casestudy/:url_key - Retrieve single case study by URL key
  - GET /rest/V1/casestudy/config - Get available filter options
- Database schema with foreign key constraints to customer entity
- Hyva theme compatibility (Luma not supported)
- Admin ACL permissions for case study management
- Timestamp tracking for creation and updates
