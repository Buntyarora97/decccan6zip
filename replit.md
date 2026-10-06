# Replit project notes

## Run the website

The `Start application` workflow serves the PHP site on port 5000 with:

```sh
php -S 0.0.0.0:5000 preview-router.php
```

Keep `preview-router.php` as the router so clean URLs, the sitemap and robots file resolve in the Replit preview.

## Content and publishing

- Do not invent hospital services, facilities, medical credentials, patient stories or image attributions. Confirm claims against hospital-approved source material.
- Do not publish identifiable patient photos without documented consent.
- Confirm the identity of each doctor portrait and the affiliation of third-party pharmacy signage before production use.
- Health articles and department information are educational; add medical-review attribution only after a qualified reviewer has approved the exact content.
- Set and verify the public HTTPS host before submitting the sitemap or reporting production search and speed results.

## Project structure

- `index.php` resolves public clean routes and page metadata.
- `data/` holds the site's public structured content.
- `sitemap.php` and `robots.php` generate the sitemap and robots policy from the configured host.
- Keep production credentials out of version control; use Replit Secrets for sensitive settings.