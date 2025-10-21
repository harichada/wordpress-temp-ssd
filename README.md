# StudySync Digital - WordPress Theme

A modern, responsive WordPress theme designed for tech product reviews and affiliate marketing, specifically focused on study and digital learning technology.

## Theme Overview

StudySync Digital is a premium WordPress theme built for studysyncdigital.com. It features a clean, modern design optimized for showcasing tech products with affiliate links, product reviews, and engaging content for students and digital learners.

## Features

- **Modern Design**: Clean, professional layout with gradient accents
- **Responsive**: Fully responsive design that works on all devices
- **Product Reviews**: Custom post type for tech products with ratings and pricing
- **Affiliate Ready**: Built-in support for affiliate links with proper disclosures
- **Category Pages**: Organized product categories (Laptops, Tablets, Headphones, etc.)
- **SEO Optimized**: Clean code and semantic HTML for better search engine ranking
- **Fast Loading**: Optimized assets and minimal dependencies
- **Customizable**: Easy to customize colors, layouts, and content

## Product Categories

The theme comes with pre-designed category pages for:

- 💻 **Laptops** - Best laptops for students and professionals
- 📱 **Tablets** - Portable devices for note-taking and reading
- 🎧 **Headphones** - Quality audio equipment for focus and learning
- ⌚ **Smart Devices** - Smartwatches and productivity gadgets
- ⚙️ **Software** - Essential apps and tools for learning
- 🖱️ **Accessories** - Keyboards, mice, and desk essentials

## Installation

1. **Upload the theme:**
   - Upload the `studysyncdigital` folder to `/wp-content/themes/`
   - Or upload the theme ZIP file through WordPress admin (Appearance > Themes > Add New)

2. **Activate the theme:**
   - Go to Appearance > Themes in your WordPress admin
   - Click "Activate" on the StudySync Digital theme

3. **Configure settings:**
   - Go to Settings > Permalinks and click "Save Changes" to refresh permalinks
   - This ensures the custom post types work correctly

## Theme Setup

### 1. Create Navigation Menu

1. Go to Appearance > Menus
2. Create a new menu named "Primary Menu"
3. Add pages: Home, Products, Blog, About, Contact
4. Assign to "Primary Menu" location

### 2. Configure Widgets

The theme has 4 widget areas:
- **Sidebar** - Appears on blog posts and pages
- **Footer Widget 1, 2, 3** - Three footer columns

To add widgets:
1. Go to Appearance > Widgets
2. Drag widgets to desired areas

### 3. Create Product Posts

The theme includes a custom "Product" post type:

1. Go to Products > Add New Product
2. Fill in the product details:
   - **Title**: Product name
   - **Content**: Detailed review
   - **Excerpt**: Short description
   - **Featured Image**: Product image (or use placeholder images from `/assets/images/`)
   - **Product Details** (meta box):
     - Price: Product price in USD
     - Rating: 1-5 stars (supports decimals like 4.5)
     - Affiliate Link: Your affiliate URL
     - Key Features: One feature per line

3. Assign to a Product Category
4. Publish

### 4. Using Placeholder Images

The theme includes professional SVG placeholder images in `/assets/images/`:

- `placeholder-laptop.svg` - For laptop products
- `placeholder-tablet.svg` - For tablet products
- `placeholder-headphones.svg` - For headphone products
- `placeholder-smartwatch.svg` - For smartwatch products
- `placeholder-software.svg` - For software/app products
- `placeholder-accessories.svg` - For accessory products

These can be used as featured images until you have actual product photos.

## Customization

### Colors

The theme uses CSS custom properties (variables) defined in `style.css`:

```css
:root {
    --primary-color: #2563eb;     /* Blue */
    --secondary-color: #7c3aed;   /* Purple */
    --accent-color: #f59e0b;      /* Orange */
    --text-dark: #1f2937;         /* Dark gray */
    --text-light: #6b7280;        /* Light gray */
}
```

To change colors, edit these variables in the `style.css` file.

### Homepage

The theme includes a custom homepage template (`front-page.php`) with:
- Hero section with call-to-action
- Category grid
- Featured products
- Latest articles

To use it, simply create a page titled "Home" and set it as the homepage in Settings > Reading.

### Creating Pages

Create these essential pages:

1. **Home** - Will use the front-page.php template automatically
2. **About** - About your site and team
3. **Contact** - Contact information
4. **Privacy Policy** - Required for affiliate sites
5. **Terms of Service** - Terms and conditions

## Best Practices for Affiliate Marketing

1. **Transparency**: Always disclose affiliate relationships (built into product pages)
2. **Honest Reviews**: Provide genuine, helpful reviews
3. **Update Regularly**: Keep prices and availability current
4. **Add Value**: Write detailed, informative content
5. **Mobile Optimization**: The theme is mobile-friendly by default

## File Structure

```
studysyncdigital/
├── style.css              # Main stylesheet with theme info
├── functions.php          # Theme functions and features
├── header.php            # Header template
├── footer.php            # Footer template
├── index.php             # Blog/archive template
├── front-page.php        # Homepage template
├── single.php            # Single post/product template
├── page.php              # Page template
├── archive.php           # Category/archive template
├── assets/
│   ├── css/             # Additional stylesheets
│   ├── js/
│   │   └── scripts.js   # JavaScript file
│   └── images/          # Theme images and placeholders
└── template-parts/      # Reusable template parts
```

## Support & Documentation

- **Theme Documentation**: This README file
- **WordPress Codex**: https://codex.wordpress.org/
- **Theme Support**: Contact your developer

## Development

Built with:
- WordPress 5.0+
- PHP 7.4+
- Modern CSS (Flexbox, Grid)
- Vanilla JavaScript with jQuery

## License

This theme is licensed under the GNU General Public License v2 or later.

## Credits

- Designed and developed for studysyncdigital.com
- Icons: Unicode emoji characters
- Gradients: Custom CSS gradients
- Images: Custom SVG illustrations

## Changelog

### Version 1.0
- Initial release
- Custom product post type
- Responsive design
- Category pages
- Product review templates
- Affiliate link support
- SVG placeholder images

---

**Ready to start?** Activate the theme, create your first product review, and start helping students find the perfect tech for their learning journey!
