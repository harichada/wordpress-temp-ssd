# StudySync Deals Manager

A powerful WordPress plugin for managing and displaying tech deals with discounts, expiration dates, and affiliate links. Built specifically for StudySync Digital.

## Features

### Deal Management
- **Custom Post Type** for deals with full WordPress integration
- **Price Management** - Original price, sale price, automatic discount calculation
- **Expiration Dates** - Set when deals expire with automatic badges
- **Coupon Codes** - Display promo codes with click-to-copy functionality
- **Affiliate Links** - Manage affiliate URLs with proper disclosures
- **Deal Types** - Categorize as discount, coupon, freebie, bundle, or student deal
- **Featured Deals** - Mark hot deals for prominent display

### Visual Elements
- **Deal Badges** - Automatic badges for hot, expiring, expired, student, and free deals
- **Animated Cards** - Smooth hover effects and scroll animations
- **Responsive Design** - Works perfectly on all devices
- **Price Display** - Strike-through original price with highlighted sale price
- **Savings Calculator** - Shows how much users save
- **Professional Grid** - Beautiful card-based layout

### Display Options
- **Shortcodes** - Easy embedding anywhere on your site
- **Widgets** - Sidebar widget for featured deals
- **Categories** - Organize deals by product category
- **Tags** - Additional organization with deal tags
- **Filtering** - Show deals by category, featured status, or custom criteria

### Admin Features
- **Easy Interface** - Intuitive meta boxes for deal details
- **Auto-Calculation** - Discount percentage calculated automatically
- **Quick Stats** - Dashboard showing active, expired, and featured deals
- **Bulk Management** - Edit multiple deals at once
- **Preview Mode** - See how deals look before publishing

## Installation

### Method 1: Upload via WordPress Admin

1. Download the plugin folder
2. Compress it to a ZIP file
3. Go to **Plugins > Add New** in WordPress
4. Click **Upload Plugin**
5. Choose the ZIP file and click **Install Now**
6. Click **Activate**

### Method 2: Manual Installation

1. Upload the `studysync-deals` folder to `/wp-content/plugins/`
2. Go to **Plugins** in WordPress admin
3. Find "StudySync Deals Manager" and click **Activate**

### Post-Activation

1. Go to **Settings > Permalinks**
2. Click **Save Changes** (to refresh permalinks for the deal post type)
3. You're ready to add deals!

## Quick Start Guide

### Creating Your First Deal

1. **Navigate to Deals**
   - Go to **Deals > Add New Deal** in WordPress admin

2. **Fill in Basic Information**
   - **Title**: Product name (e.g., "MacBook Pro 16" M3 - Student Discount")
   - **Description**: Write compelling deal details
   - **Featured Image**: Upload product image

3. **Set Deal Details**
   - **Original Price**: Regular price before discount
   - **Sale Price**: Discounted price
   - **Discount %**: Auto-calculated
   - **Affiliate Link**: Your affiliate URL
   - **Store Name**: Where to buy (Amazon, Best Buy, etc.)
   - **Coupon Code**: Optional promo code
   - **Expiration Date**: When deal ends
   - **Deal Type**: Choose category
   - **Featured**: Check for hot deals

4. **Categorize**
   - Assign to **Deal Category** (Laptops, Software, etc.)
   - Add **Deal Tags** if desired

5. **Publish**
   - Click **Publish** to make it live!

### Creating Deal Categories

1. Go to **Deals > Deal Categories**
2. Create categories matching your products:
   - Laptops
   - Tablets
   - Headphones
   - Software
   - Accessories
   - Smart Devices
3. Assign deals to appropriate categories

## Using Shortcodes

### Display All Active Deals

```
[studysync_deals]
```

Shows all active (non-expired) deals in a grid.

### Limit Number of Deals

```
[studysync_deals limit="6"]
```

Shows only 6 deals.

### Filter by Category

```
[studysync_deals category="laptops"]
```

Shows only deals from the "laptops" category.

### Show Only Featured Deals

```
[studysync_deals featured="true"]
```

Displays only deals marked as featured/hot.

### Combine Parameters

```
[studysync_deals category="software" limit="3" featured="true"]
```

Shows 3 featured software deals.

### Display a Single Deal

```
[studysync_deal id="123"]
```

Replace 123 with the deal's post ID. Shows a detailed single deal display.

### Custom Ordering

```
[studysync_deals orderby="meta_value_num" order="DESC"]
```

Order by different criteria (date, title, etc.).

## Using the Widget

1. Go to **Appearance > Widgets**
2. Find "Featured Deals" widget
3. Drag to your sidebar or footer
4. Configure:
   - **Title**: Widget heading
   - **Number of deals**: How many to show
5. Save

The widget displays compact featured deals in your sidebar.

## Deal Badges Explained

The plugin automatically adds badges based on deal status:

- **🔥 HOT** - Featured/hot deals you've marked
- **⏰ ENDS IN X DAYS** - Deal expiring soon (within 3 days)
- **⏰ ENDS TODAY** - Deal expires today
- **EXPIRED** - Deal has passed expiration date
- **🎓 STUDENT** - Student-specific discount
- **🎁 FREE** - Free items or trials

## Best Practices

### Finding Deals

1. **Affiliate Programs**
   - Join Amazon Associates
   - Sign up for retailer affiliate programs
   - Use ShareASale, CJ Affiliate, etc.

2. **Deal Sources**
   - Manufacturer education stores
   - Retailer student discounts
   - Seasonal sales (back to school, Black Friday)
   - Newsletter exclusive offers
   - Student verification platforms (UNiDAYS, Student Beans)

3. **Verification**
   - Always verify deals are active before posting
   - Check that affiliate links work
   - Confirm prices are accurate
   - Test coupon codes yourself

### Writing Effective Deals

1. **Compelling Titles**
   - Include product name and discount amount
   - Example: "Sony WH-1000XM5 - Save $100 Today"

2. **Clear Descriptions**
   - Explain why it's a good deal
   - Highlight student benefits
   - Include key features
   - Mention what's included

3. **Urgency**
   - Set expiration dates to create urgency
   - Use "Limited Time" for short deals
   - Mark best deals as featured

4. **Honesty**
   - Only promote products you'd recommend
   - Disclose affiliate relationships (automatic in plugin)
   - Be transparent about limitations

### Maintenance

1. **Weekly Tasks**
   - Check for expired deals and update/remove them
   - Add new seasonal deals
   - Verify affiliate links still work
   - Update prices if changed

2. **Monthly Tasks**
   - Review top-performing deals
   - Refresh deal categories
   - Add trending products
   - Clean up expired deals

3. **Seasonal Tasks**
   - Back to school (July-September)
   - Black Friday/Cyber Monday (November)
   - Holiday season (December)
   - New Year sales (January)
   - Prime Day and other events

## Customization

### Changing Colors

Edit `/assets/css/deals.css` to customize colors:

```css
/* Hot badge color */
.deal-badge-hot {
    background: linear-gradient(135deg, #f59e0b, #ea8e0b);
}

/* Deal button color */
.deal-button-active {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
}

/* Expiring badge */
.deal-badge-expiring {
    background: #e74c3c;
}
```

### Modifying Templates

Templates are in `/templates/` folder:
- `deals-grid.php` - Grid display for multiple deals
- `single-deal.php` - Single deal display

Copy templates to your theme to override:
`your-theme/studysync-deals/deals-grid.php`

### Custom Query Arguments

Developers can filter deals query:

```php
add_filter('ssd_deals_query_args', function($args) {
    // Modify query args
    $args['posts_per_page'] = 20;
    return $args;
});
```

## Troubleshooting

### Deals Not Showing

1. Check if deals are published (not draft)
2. Verify expiration dates aren't in the past
3. Refresh permalinks (Settings > Permalinks > Save)
4. Check shortcode syntax is correct

### Images Not Displaying

1. Verify featured image is set
2. Check image file size (should be under 2MB)
3. Regenerate thumbnails if needed
4. Ensure proper permissions on uploads folder

### Affiliate Links Not Working

1. Verify URL is complete (includes https://)
2. Check for extra spaces in URL field
3. Test link in private/incognito browser
4. Ensure affiliate program account is active

### Discount Not Calculating

1. Make sure both original and sale prices are set
2. Sale price must be less than original price
3. Prices should be numbers only (no $ symbol)
4. JavaScript must be enabled (auto-calculation)

## File Structure

```
studysync-deals/
├── studysync-deals.php       # Main plugin file
├── README.md                  # This file
├── SAMPLE-DEALS.md           # Example deals to get started
├── includes/
│   ├── deal-functions.php    # Helper functions
│   └── deal-widgets.php      # Widget class
├── templates/
│   ├── deals-grid.php        # Grid display template
│   └── single-deal.php       # Single deal template
└── assets/
    ├── css/
    │   ├── deals.css         # Frontend styles
    │   └── admin.css         # Admin styles
    └── js/
        └── deals.js          # Frontend JavaScript
```

## Hooks & Filters

### Actions

```php
// After deal saved
do_action('ssd_deal_saved', $post_id);

// Before deals grid rendered
do_action('ssd_before_deals_grid', $query);

// After deals grid rendered
do_action('ssd_after_deals_grid', $query);
```

### Filters

```php
// Modify deal query args
apply_filters('ssd_deals_query_args', $args);

// Change deal button text
apply_filters('ssd_deal_button_text', $text, $post_id);

// Customize price display
apply_filters('ssd_price_html', $html, $post_id);
```

## Integration with StudySync Digital Theme

This plugin is designed to work perfectly with the StudySync Digital theme:

1. **Matching Design** - Uses same color scheme and styles
2. **Responsive** - Works with theme's mobile-first approach
3. **Compatible** - No conflicts with theme features
4. **Complementary** - Adds deals alongside product reviews

### Adding Deals to Homepage

Edit your homepage and add:

```
[studysync_deals limit="6" featured="true"]
```

This shows 6 hot deals on your front page.

### Creating a Deals Page

1. Create new page: "Deals" or "Student Discounts"
2. Add shortcode: `[studysync_deals limit="12"]`
3. Publish
4. Add to navigation menu

## Support & Resources

- **Documentation**: This README file
- **Sample Deals**: See SAMPLE-DEALS.md for examples
- **WordPress Codex**: https://codex.wordpress.org/
- **Affiliate Marketing Guide**: Research FTC disclosure requirements

## Legal & Compliance

### Affiliate Disclosures

The plugin automatically adds affiliate disclosures to:
- Single deal pages
- Deal buttons
- Shortcode displays

Required by FTC guidelines. Do not remove these disclosures.

### Privacy

If you track deal clicks:
- Update your privacy policy
- Mention affiliate link tracking
- Comply with GDPR if applicable

### Terms of Service

Ensure you comply with:
- Affiliate program terms
- Retailer policies
- Coupon usage rules
- Price advertising regulations

## Changelog

### Version 1.0.0
- Initial release
- Deal custom post type
- Price and discount management
- Expiration date tracking
- Coupon code support
- Featured deal badges
- Shortcode support
- Widget for sidebar
- Responsive grid layout
- Admin statistics dashboard
- Auto-discount calculation
- Click-to-copy coupon codes

## Credits

Built for StudySync Digital
Designed to help students find the best tech deals for learning

## License

GPL v2 or later

---

## Quick Reference

### Most Common Tasks

**Add a Deal:**
Deals > Add New Deal

**View All Deals:**
Deals > All Deals

**Edit Categories:**
Deals > Deal Categories

**Check Stats:**
Deals > Settings

**Add to Page:**
`[studysync_deals]`

**Add to Sidebar:**
Appearance > Widgets > Featured Deals

---

Ready to start helping students save money? Add your first deal now! 🎉
