# Renew Group of Companies — WordPress Theme

This package converts the supplied Renew Group static HTML website into a classic WordPress theme while keeping the original visual design, animations, local fonts, Bootstrap, AOS, Swiper, images, and theme-color toggle.

## Installation

1. Extract `renew-group-wp-theme.zip`.
2. In WordPress admin, go to **Appearance → Themes → Add New → Upload Theme**.
3. Upload the ZIP file and activate **Renew Group of Companies**.
4. Set your site's title/tagline under **Settings → General**.
5. Set a static front page if you are using other pages; this theme automatically uses `front-page.php` for the homepage.
6. Visit the homepage and verify the local images, fonts, animations, and theme toggle.

## Included

- `front-page.php` — complete one-page Renew Group website.
- `header.php` / `footer.php` — WordPress head/footer integration.
- `functions.php` — WordPress setup, local asset loading, favicon, AJAX enquiry handling.
- `assets/css/` — Bootstrap, Bootstrap Icons, AOS, Swiper, fonts and original design CSS.
- `assets/js/` — jQuery, Bootstrap, AOS, Swiper and converted website JavaScript.
- `assets/images/` — supplied Renew Group logos and favicon.
- `assets/fonts/` — local DM Sans and Playfair Display font files.
- `page.php` and `index.php` — basic WordPress fallbacks.

## Contact forms

The Contact and Partner forms were converted from the original demo behavior to WordPress AJAX.

Submissions are sent using `wp_mail()` to the WordPress **Administration Email Address** configured under:

**Settings → General → Administration Email Address**

For reliable production email delivery, configure SMTP through your hosting/provider or an SMTP plugin.

## Important

The homepage content is intentionally preserved from the supplied HTML and lives in `front-page.php`. It is not converted into WordPress block/editor fields, so the visual design remains stable.

You can later convert sections such as Businesses, Team, FAQ and Contact details into editable WordPress Customizer fields, blocks, ACF fields, or custom post types if required.

## Local assets

No Google Fonts CDN is required by the theme. DM Sans and Playfair Display are loaded from the included local font files.

The theme also keeps the supplied Bootstrap, AOS, Swiper, Bootstrap Icons, JavaScript and image assets locally.


## Editable Homepage

This version keeps the original visual design but makes the homepage content editable from:

**WordPress Admin → Appearance → Customize → Renew Homepage Content**

Editable areas include:
- Hero heading, description, buttons, notes and established year
- Statistics and labels
- All four business cards and tags
- About section and four standards
- Why Us / Values
- Leadership names, roles, bios and photos
- Partnership cards, tags and buttons
- All six FAQ questions and answers
- Contact text, phone, location and email addresses
- Orbit logos

The Customizer provides a live preview. No code editing is required for normal content changes.
