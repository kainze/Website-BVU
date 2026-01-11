// Gallery (bilder modal) ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

type GalleryJson = {
    generatedAt?: string;
    basePath?: string;
    years: Array<{
        year: number;
        events: Array<{
            id: string;
            title: string;
            date: string; // YYYY-MM-DD
            path: string;
            thumbnail?: string;
            images: string[];
        }>;
    }>;
};

let galleryCache: GalleryJson | null = null;
let galleryRenderDone = false;
let currentEvent: GalleryJson["years"][number]["events"][number] | null = null;
let currentCarousel: any | null = null;

function byDateDesc(a: { date: string }, b: { date: string }) {
    const da = Date.parse(a.date);
    const db = Date.parse(b.date);
    if (Number.isNaN(da) && Number.isNaN(db)) return 0;
    if (Number.isNaN(da)) return 1;
    if (Number.isNaN(db)) return -1;
    return db - da;
}

function setGalleryStatus(message: string) {
    const el = document.getElementById("bvu-gallery-status");
    if (el) el.textContent = message;
}

function showGalleryView(view: "overview" | "event") {
    const overview = document.getElementById("bvu-gallery-overview");
    const event = document.getElementById("bvu-gallery-event");
    const slideshow = document.getElementById("bvu-gallery-slideshow");

    if (overview) overview.classList.toggle("d-none", view !== "overview");
    if (event) event.classList.toggle("d-none", view !== "event");

    // Always hide slideshow overlay when switching views.
    if (slideshow) slideshow.classList.add("d-none");
    try {
        currentCarousel?.pause?.();
    } catch {
        // ignore
    }
}

function setSlideshowOpen(open: boolean) {
    const slideshow = document.getElementById("bvu-gallery-slideshow");
    if (!slideshow) return;

    slideshow.classList.toggle("d-none", !open);
    if (!open) {
        try {
            currentCarousel?.pause?.();
        } catch {
            // ignore
        }
    }
}

function normalizeImageList(images: string[]) {
    return (images || [])
        .filter(Boolean)
        .filter((name) => !/\.(json|txt|md)$/i.test(name))
        .filter((name) => name !== ".DS_Store");
}

function isThumbnailFileName(name: string) {
    // Supports: thumbnail.jpg, thumbnail_SNY00170.jpg, SNY00170thumbnail.jpg, etc.
    return /thumbnail/i.test(name);
}

function formatDateDE(isoDate: string) {
    // Expected input: YYYY-MM-DD
    const m = /^\s*(\d{4})-(\d{2})-(\d{2})\s*$/.exec(isoDate || "");
    if (!m) return isoDate;
    const [, y, mo, d] = m;
    return `${d}.${mo}.${y}`;
}

function getEventThumbnailUrl(event: GalleryJson["years"][number]["events"][number]) {
    const images = normalizeImageList(event.images);

    if (event.thumbnail) {
        return `${event.path}/${event.thumbnail}`;
    }

    const candidate = images.find(isThumbnailFileName);
    if (candidate) return `${event.path}/${candidate}`;

    const first = images[0];
    return first ? `${event.path}/${first}` : "";
}

function renderGalleryOverview(gallery: GalleryJson) {
    const container = document.getElementById("bvu-gallery-overview");
    if (!container) return;

    const years = [...gallery.years].sort((a, b) => b.year - a.year);
    container.innerHTML = "";

    const totalEvents = years.reduce((sum, y) => sum + (y.events?.length || 0), 0);
    if (totalEvents === 0) {
        container.innerHTML = "<div class=\"text-light-grey\">Keine Bilder vorhanden.</div>";
        return;
    }

    years.forEach((y) => {
        const yearHeader = document.createElement("div");
        yearHeader.className = "h1 mb-3";
        yearHeader.textContent = y.year.toString();
        container.appendChild(yearHeader);

        const grid = document.createElement("div");
        grid.className = "row g-3 mb-5";

        const eventsSorted = [...(y.events || [])].sort(byDateDesc);
        eventsSorted.forEach((ev) => {
            const col = document.createElement("div");
            // Responsive grid: phone 1, then more columns on larger screens
            col.className = "col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2";

            const thumbUrl = getEventThumbnailUrl(ev);
            const safeTitle = ev.title || ev.id;

            const button = document.createElement("button");
            button.type = "button";
            button.className = "btn p-0 border-0 bg-transparent text-start w-100";
            button.setAttribute("aria-label", safeTitle);

            button.innerHTML = `
                <div class="card bg-dark text-dark border-0">
                    <div class="ratio ratio-1x1">
                        ${thumbUrl ? `<img src="${thumbUrl}" alt="${safeTitle}" loading="lazy" class="w-100 h-100" style="object-fit:cover;" />` : ""}
                    </div>
                    <div class="card-img-overlay d-flex align-items-end p-0">
                        <div class="w-100 p-2 bg-light-grey bg-opacity-75">
                            <div class="fw-semibold small">${safeTitle}</div>
                        </div>
                    </div>
                </div>
            `;

            button.addEventListener("click", () => {
                openGalleryEvent(ev);
            });

            col.appendChild(button);
            grid.appendChild(col);
        });

        container.appendChild(grid);
    });
}

function openGalleryEvent(event: GalleryJson["years"][number]["events"][number]) {
    currentEvent = event;

    const titleEl = document.getElementById("bvu-gallery-event-title");
    const dateEl = document.getElementById("bvu-gallery-event-date");
    if (titleEl) titleEl.textContent = event.title || "";
    if (dateEl) dateEl.textContent = event.date ? formatDateDE(event.date) : "";

    const slideshowTitleEl = document.getElementById("bvu-gallery-slideshow-title");
    const slideshowDateEl = document.getElementById("bvu-gallery-slideshow-date");
    if (slideshowTitleEl) slideshowTitleEl.textContent = event.title || "";
    if (slideshowDateEl) slideshowDateEl.textContent = event.date ? formatDateDE(event.date) : "";

    const container = document.getElementById("bvu-gallery-event-images");
    if (!container) return;

    const images = normalizeImageList(event.images);
    container.innerHTML = "";

    if (images.length === 0) {
        container.innerHTML = "<div class=\"text-light-grey\">Keine Bilder in dieser Veranstaltung.</div>";
        showGalleryView("event");
        return;
    }

    images.forEach((img, index) => {
        const col = document.createElement("div");
        col.className = "col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2";

        const url = `${event.path}/${img}`;
        const safeAlt = event.title || "Bild";

        const btn = document.createElement("button");
        btn.type = "button";
        btn.className = "btn p-0 border-0 bg-transparent w-100";
        btn.innerHTML = `
            <div class="ratio ratio-1x1">
                <img src="${url}" alt="${safeAlt}" loading="lazy" class="w-100 h-100 rounded" style="object-fit:cover;" />
            </div>
        `;
        btn.addEventListener("click", () => {
            openGallerySlideshow(index);
        });

        col.appendChild(btn);
        container.appendChild(col);
    });

    showGalleryView("event");
}

function openGallerySlideshow(startIndex: number) {
    if (!currentEvent) return;
    const images = normalizeImageList(currentEvent.images);

    const inner = document.getElementById("bvu-gallery-carousel-inner");
    const carouselEl = document.getElementById("bvu-gallery-carousel");
    if (!inner || !carouselEl) return;

    inner.innerHTML = "";
    images.forEach((img, index) => {
        const url = `${currentEvent!.path}/${img}`;
        const item = document.createElement("div");
        item.className = `carousel-item h-100${index === 0 ? " active" : ""}`;
        item.innerHTML = `
            <div class="d-flex align-items-center justify-content-center h-100">
                <img src="${url}" class="d-block img-fluid mw-100 mh-100" alt="${currentEvent!.title || "Bild"}" style="object-fit:contain;" />
            </div>
        `;
        inner.appendChild(item);
    });

    // (Re)initialize Bootstrap carousel
    try {
        currentCarousel?.dispose?.();
    } catch {
        // ignore
    }

    const bootstrapAny = (window as any).bootstrap;
    const CarouselCtor = bootstrapAny?.Carousel;
    if (CarouselCtor) {
        currentCarousel = new CarouselCtor(carouselEl, {
            interval: 5000,
            ride: true,
            pause: false,
            wrap: true,
        });

        try {
            currentCarousel.to(Math.max(0, Math.min(startIndex, images.length - 1)));
            currentCarousel.cycle();
        } catch {
            // ignore
        }
    }

    setSlideshowOpen(true);
}

async function loadGalleryJsonOnce(jsonUrl: string): Promise<GalleryJson> {
    if (galleryCache) return galleryCache;
    const res = await fetch(jsonUrl, { cache: "no-cache" });
    if (!res.ok) throw new Error(`gallery.json konnte nicht geladen werden (${res.status})`);
    const data = (await res.json()) as GalleryJson;
    galleryCache = data;
    return data;
}

async function initGalleryInModal() {
    const root = document.getElementById("bvu-gallery");
    if (!root) return;

    const jsonUrl = root.getAttribute("data-gallery-json") || "gallery/gallery.json";
    setGalleryStatus("Lade...");

    try {
        const gallery = await loadGalleryJsonOnce(jsonUrl);
        renderGalleryOverview(gallery);
        showGalleryView("overview");

        const backOverview = document.getElementById("bvu-gallery-back-overview");
        if (backOverview) {
            backOverview.addEventListener("click", () => {
                showGalleryView("overview");
            });
        }

        const closeSlideshow = document.getElementById("bvu-gallery-close-slideshow");
        if (closeSlideshow) {
            closeSlideshow.addEventListener("click", () => {
                setSlideshowOpen(false);
            });
        }

        const slideshowOverlay = document.getElementById("bvu-gallery-slideshow");
        if (slideshowOverlay) {
            slideshowOverlay.addEventListener("click", (ev) => {
                // Close when clicking on the dark overlay background.
                if (ev.target === slideshowOverlay) setSlideshowOpen(false);
            });
        }
        setGalleryStatus("");
        galleryRenderDone = true;
    } catch (err) {
        console.error(err);
        setGalleryStatus("Fehler");
        const overview = document.getElementById("bvu-gallery-overview");
        if (overview) {
            overview.innerHTML = `<div class="text-warning">Galerie konnte nicht geladen werden. Prüfe <code>${jsonUrl}</code>.</div>`;
        }
    }
}

document.addEventListener("shown.bs.modal", (e: any) => {
    if (e?.target?.id !== "bilderModal") return;
    // Render once; if you want always-refresh later, remove this guard.
    if (!galleryRenderDone) {
        initGalleryInModal();
    } else {
        showGalleryView("overview");
    }
});
