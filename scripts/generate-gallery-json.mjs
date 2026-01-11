import { promises as fs } from "fs";
import path from "path";

const IMAGE_EXT_RE = /\.(jpe?g|png|webp|gif)$/i;

function isImageFile(name) {
  return IMAGE_EXT_RE.test(name) && !name.startsWith(".");
}

function slugify(input) {
  return (input || "")
    .toString()
    .trim()
    .toLowerCase()
    .normalize("NFKD")
    .replace(/[\u0300-\u036f]/g, "")
    .replace(/[^a-z0-9]+/g, "-")
    .replace(/^-+|-+$/g, "")
    .slice(0, 80);
}

function parseDateFromEventFolderName(eventFolderName, fallbackYear) {
  // Supports e.g. "22.08.2025", "24.12.24", "Wein- & Weißbierfest 26.07.2024"
  const m = /(^|\D)(\d{1,2})\.(\d{1,2})\.(\d{2,4})(\D|$)/.exec(eventFolderName);
  if (m) {
    const day = String(m[2]).padStart(2, "0");
    const month = String(m[3]).padStart(2, "0");
    let year = m[4];
    if (year.length === 2) year = String(2000 + Number(year));
    return `${year}-${month}-${day}`;
  }

  if (typeof fallbackYear === "number" && Number.isFinite(fallbackYear)) {
    return `${fallbackYear}-01-01`;
  }

  return "";
}

function pickThumbnail(images) {
  const byName = (a, b) => a.localeCompare(b, "en");
  const candidates = images.filter((n) => /thumbnail/i.test(n)).sort(byName);
  if (candidates.length === 0) return undefined;
  const preferred = candidates.find((n) => /^thumbnail/i.test(n));
  return preferred || candidates[0];
}

async function listDirs(dirPath) {
  const entries = await fs.readdir(dirPath, { withFileTypes: true });
  return entries.filter((e) => e.isDirectory()).map((e) => e.name);
}

async function listFiles(dirPath) {
  const entries = await fs.readdir(dirPath, { withFileTypes: true });
  return entries.filter((e) => e.isFile()).map((e) => e.name);
}

async function main() {
  const repoRoot = process.cwd();
  const galleryRoot = path.join(repoRoot, "gallery");
  const outFile = path.join(galleryRoot, "gallery.json");

  const yearNames = await listDirs(galleryRoot);
  const years = [];

  for (const yearName of yearNames) {
    if (!/^\d{4}$/.test(yearName)) continue;
    const year = Number(yearName);
    const yearDir = path.join(galleryRoot, yearName);

    const eventNames = await listDirs(yearDir);
    const events = [];

    for (const eventName of eventNames) {
      const eventDir = path.join(yearDir, eventName);
      const allFiles = await listFiles(eventDir);

      const images = allFiles.filter(isImageFile).sort((a, b) => a.localeCompare(b, "en"));
      const thumbnail = pickThumbnail(images);

      const date = parseDateFromEventFolderName(eventName, year);
      const idBase = `${yearName}-${eventName}`;
      const id = slugify(idBase) || `${yearName}-${events.length + 1}`;

      events.push({
        id,
        title: eventName,
        date,
        path: `gallery/${yearName}/${eventName}`,
        ...(thumbnail ? { thumbnail } : {}),
        images,
      });
    }

    events.sort((a, b) => (b.date || "").localeCompare(a.date || "", "en"));
    years.push({ year, events });
  }

  years.sort((a, b) => b.year - a.year);

  const data = {
    generatedAt: new Date().toISOString(),
    years,
  };

  await fs.mkdir(path.dirname(outFile), { recursive: true });
  await fs.writeFile(outFile, JSON.stringify(data, null, 2) + "\n", "utf8");

  // eslint-disable-next-line no-console
  console.log(`Generated ${path.relative(repoRoot, outFile)} with ${years.reduce((sum, y) => sum + y.events.length, 0)} events.`);
}

main().catch((err) => {
  console.error(err);
  process.exit(1);
});
