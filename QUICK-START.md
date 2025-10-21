# StudySync Digital - Quick Start Guide

Get your tech review site up and running in 15 minutes!

## Step 1: Install WordPress (if not already installed)

If WordPress isn't installed yet:

```bash
# Download WordPress
wget https://wordpress.org/latest.tar.gz
tar -xzf latest.tar.gz
mv wordpress/* .
rm -rf wordpress latest.tar.gz

# Create wp-config.php and configure database
cp wp-config-sample.php wp-config.php
# Edit wp-config.php with your database details
```

## Step 2: Activate the Theme

1. Copy the theme folder:
   ```bash
   # Theme is already in: wp-content/themes/studysyncdigital/
   ```

2. In WordPress admin:
   - Go to **Appearance > Themes**
   - Click **Activate** on "StudySync Digital"

3. Refresh permalinks:
   - Go to **Settings > Permalinks**
   - Click **Save Changes** (no need to change anything)

## Step 3: Create Essential Pages

Create these pages (Pages > Add New):

1. **Home**
   - Title: "Home"
   - Leave content blank (uses custom template)
   - Publish

2. **About**
   - Title: "About"
   - Add your content about the site
   - Publish

3. **Contact**
   - Title: "Contact"
   - Add contact information or form
   - Publish

4. Set Homepage:
   - Go to **Settings > Reading**
   - Select "A static page"
   - Homepage: "Home"
   - Posts page: Leave as "Select"
   - Save

## Step 4: Create Navigation Menu

1. Go to **Appearance > Menus**
2. Create new menu: "Primary Menu"
3. Add pages:
   - Home
   - Products (Custom Link: `/products/`)
   - Blog (Custom Link: `/blog/`)
   - About
   - Contact
4. Assign to "Primary Menu" location
5. Save

## Step 5: Create Product Categories

1. Go to **Products > Product Categories**
2. Create these categories:
   - Laptops
   - Tablets
   - Headphones
   - Smart Devices
   - Software
   - Accessories

## Step 6: Add Your First Product

1. Go to **Products > Add New Product**
2. Use sample data from `sample-products.md`
3. Example - MacBook Pro:
   - **Title**: MacBook Pro 16" M3 Pro
   - **Content**: Copy from sample-products.md
   - **Excerpt**: Copy the excerpt
   - **Category**: Laptops
   - **Product Details**:
     - Price: 2499
     - Rating: 4.8
     - Affiliate Link: (your Amazon affiliate link)
     - Features: Copy from sample data
   - **Featured Image**:
     - Upload or use: `wp-content/themes/studysyncdigital/assets/images/placeholder-laptop.svg`
4. Click **Publish**

Repeat for 5-6 products to populate your homepage!

## Step 7: Customize Site Info

1. Go to **Settings > General**
2. Set:
   - Site Title: "StudySync Digital"
   - Tagline: "Your Guide to the Best Tech for Learning"
   - Save

## Step 8: Optional Widgets

1. Go to **Appearance > Widgets**
2. Add to **Sidebar**:
   - Search
   - Recent Posts
   - Categories

3. Add to **Footer Widget 1, 2, 3**:
   - Custom HTML or Text widgets
   - Navigation menus
   - Social links

## Quick Reference

### Placeholder Images Location
```
wp-content/themes/studysyncdigital/assets/images/
├── placeholder-laptop.svg
├── placeholder-tablet.svg
├── placeholder-headphones.svg
├── placeholder-smartwatch.svg
├── placeholder-software.svg
└── placeholder-accessories.svg
```

### Recommended Plugins

While the theme works standalone, these plugins enhance functionality:

1. **Yoast SEO** - Search engine optimization
2. **Contact Form 7** - Contact forms
3. **Pretty Links** - Manage affiliate links
4. **WP Super Cache** - Speed optimization
5. **Akismet** - Spam protection

Install via: **Plugins > Add New**

### Getting Your Affiliate Links

1. **Amazon Associates**:
   - Sign up: https://affiliate-program.amazon.com
   - Get product links
   - Add to Product Details > Affiliate Link field

2. **Add Disclosure**:
   - Already built into single product template
   - Appears automatically below "Buy" button

### Color Customization

To change theme colors, edit `style.css` lines 20-28:

```css
:root {
    --primary-color: #2563eb;     /* Change this */
    --secondary-color: #7c3aed;   /* And this */
    --accent-color: #f59e0b;      /* And this */
}
```

### Support & Help

- **Full Documentation**: See README.md
- **Sample Content**: See sample-products.md
- **WordPress Help**: https://wordpress.org/support/

## You're Ready! 🚀

Your StudySync Digital site is now set up and ready to help students find the perfect tech for their learning journey.

### Next Steps:

1. Add more products using sample data
2. Write blog posts about tech trends
3. Customize colors and branding
4. Set up Google Analytics
5. Apply for affiliate programs
6. Share on social media!

**Need help?** Refer to README.md for detailed documentation.
