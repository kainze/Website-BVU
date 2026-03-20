# Website-BVU (BV Unterneukirchen)

Statische Website (HTML + Bootstrap) mit ein bisschen TypeScript und SCSS.

Aktueller Stand (öffentliches Repo): https://github.com/kainze/Website-BVU

## Schnellstart (lokal)

- `npm install`
- parallel zum Entwickeln: `npm run watch`
- Website öffnen:
	- am einfachsten via VS Code **Live Server** auf `index.html`
	- oder direkt im Browser (ohne Live-Reload)

## Build

- TypeScript → JavaScript: `src/` → `dest/js/` (`npm run build:ts`)
- SCSS → CSS: `custom_scss/custom.scss` → `dest/css/custom_bootstrap.css` (`npm run build:scss`)
- alles zusammen: `npm run build`

Die Website bindet die erzeugten Dateien aus `dest/` direkt ein.

## Deployment

GitHub Action: [.github/workflows/deploy.yml](.github/workflows/deploy.yml)

- Trigger: Push auf Branch `master`
- Build-Umgebung: Node 18
- Deploy 1: GitHub Pages (lädt das Repo als Artifact hoch)
- Deploy 2: Produktiv-Hosting via FTP (muss erst approved werden)

## Grobe Struktur

- `index.html`: Hauptseite
- `fest2024.html`: Rückblick/Seite fürs Fest 2024
- `src/script.ts`: Logik (Countdown, Consent-Schalter für Instagram/Maps/Kalender, E-Mail-Link, etc.)
- `custom_scss/`: SCSS/Bootstrap-Anpassungen
- `dest/`: Build-Output (JS/CSS) – wird im Deployment verwendet
- `modals/`: HTML-Fragmente (Impressum, Datenschutz, Satzung, …) werden in `index.html` per `fetch()` nachgeladen
- `Stiftung/`: eigene Unterseite (mit separaten Assets)
- `alteWebsite/`: Legacy/Archiv (alte Seite inkl. PHP/Galerie)
