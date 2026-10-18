# Abraqyah International – WordPress theme

Custom corporate theme built from the six supplied HTML pages (home, about, services, pipeline services,
cleaning & preparation, contact). Requires WordPress 6.3+ and PHP 7.4+. No plugins required.

## Install
1. Appearance → Themes → Add New → Upload Theme → choose `abraqyah.zip` → Activate.
2. On first activation the theme creates the page tree, sets **Home** as the front page and builds the
   **Primary** menu (never overwrites existing pages or menus; disable with
   `add_filter( 'abq_seed_content', '__return_false' );`).
3. Appearance → Customize → **Abraqyah Settings**: company/contact details, home copy, images,
   and a switch to hide the "to be provided" placeholder sections until real content is ready.
4. Upload real photography (Customize → Site images, or each service page's Featured Image).
   Until then a blueprint placeholder is shown.

## Page structure (all editable in Pages)
```
Home (front page)
About Us            template: About Us
Services            template: Services Overview
 ├ Pipeline Services        template: Service Listing   (intro text + cards)
 │   ├ Cleaning & preparation   template: Service Listing   (card grid)
 │   │   └ Mechanical Cleaning & Gauging, Chemical Cleaning, De-watering, Drying & Swabbing
 │   ├ Testing & inspection     └ Hydro Testing, ILI Inspection, Baseline Survey, Nitrogen Leak Testing
 │   └ Shutdown & preservation  └ Nitrogen Drying/Purging/Lay-up, De-cruding, Mothballing, De-gassing, Bolt Torquing
 ├ Rotating Equipment Services  └ Compressors, Turbines, Motors, Pumps, Gear Boxes, Valves, Balancing, Machining, OEM Spares
 └ NGU Services                 └ Drying & Purging, Leak Testing, Lay-up & Mothballing
Career
Contact Us          template: Contact
```
Add a service = add a child page. Its title, **excerpt** (card text / hero sub-heading) and **featured image**
drive the cards, hero, menus and the "Enquire" links (`/contact-us/?service=slug` pre-selects it in the form).
Each page also has a **Page header options** box (hero kicker, intro headline).

## Animations (all disabled automatically for `prefers-reduced-motion`)
- Hero: Ken Burns zoom, word-by-word headline rise, staggered fade-in, scroll parallax
- Scroll reveals (fade/slide/clip-path image wipes), staggered grids
- Count-up numbers (home highlight, About KPIs)
- Pipeline service list with a scroll-driven progress rail that lights each step
- Rotating-equipment picker with caption cross-fade, auto-cycle and a slowly turning rotor graphic
- Header: solid on scroll, hides on scroll-down / returns on scroll-up, red reading-progress bar
- Cards lift and zoom, buttons sweep, nav underline and numbered dropdown, spinning logo ring

## Enquiry form
Posts to `admin-post.php`, protected by nonce, honeypot, minimum-fill time and a per-IP rate limit, then
`wp_mail()` to the enquiry email set in the Customizer. Install an SMTP plugin (e.g. WP Mail SMTP) so
delivery is reliable.

## Files
`functions.php`, `inc/` (helpers, customizer, form handler, starter content), `front-page.php`, `page.php`,
`page-templates/`, `template-parts/`, `assets/css/main.css`, `assets/css/contact.css` (contact page, loaded only there), `assets/js/main.js`, `assets/images/`.
Every hero banner uses `assets/images/hero.jpg` when present. Optional: drop `hero.jpg`, `about.jpg`, `pipeline.jpg`, `rotating.jpg`, `ngu.jpg`, `cta.jpg` into `assets/images/`.
