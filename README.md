# Migration Analytics Toolkit Assistive Tool

*I know it's a stupid name, give me a break, operating at my level of genius is tiring at times...*

MATAT is a tool to ease the level of effort needed in formulating estimates with the **Red Hat Migration Analytics Toolkit** platform.

## Why?

The Red Hat Migration Analytics Toolkit is an incredibly valuable function built into Red Hat CloudForms - it is also incredibly difficult to get results out of.  This is the current process:

1) Deploy Red Hat CloudForms
2) Integrate with your hypervisor platforms
3) Run the Migration Analysis from within CloudForms
4) Download the provided JSON file
5) Upload to the Red Hat Cloud
6) Finally get analysis

That is way too much work.  Instead, why not just ask:

- How many hypervisor hosts? 
- What level of support?
- VM Count/Distribution

Which will provide a pretty close estimate of the value the Migration Analytics Toolkit can provide.

## Deployment

I don't know why this is a Laravel application outside of it being my comfort zone - so, suck it.

```bash
cd app-src
composer install
npm install
npm run dev
cp .env.example .env
php artisan key:generate
```

Run with `php artisan serve` and access at `http://localhost:8000` or deploy with Nginx/PHP and target the `app-src/public` as the document root.