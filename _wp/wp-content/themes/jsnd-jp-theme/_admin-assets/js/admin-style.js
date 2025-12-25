const PAGE_CONTENT_SELECTOR = ".p-page-content";
const FILE_TYPE_CLASS_MAP = {
  pdf: "is-pdf",
  xls: "is-xls",
  xlsx: "is-xls",
};
const FILE_EXTENSION_PATTERN = /\.([a-z0-9]+)(?:[#?].*)?$/i;

const getFileExtension = (href) => {
  if (!href || href.startsWith("#") || href.startsWith("javascript:")) {
    return null;
  }

  let url = href;

  try {
    url = new URL(href, window.location.href).pathname;
  } catch (error) {
    // Ignore invalid URLs and fall back to raw href value.
    url = href;
  }

  const match = url.match(FILE_EXTENSION_PATTERN);
  if (!match) return null;

  return match[1].toLowerCase();
};

const enhanceAnchor = (anchor) => {
  if (!(anchor instanceof HTMLAnchorElement)) return;
  if (anchor.classList.length > 0) return;

  const extension = getFileExtension(anchor.getAttribute("href"));
  if (!extension) return;

  const className = FILE_TYPE_CLASS_MAP[extension];
  if (!className) return;

  anchor.classList.add(className);
};

const initPageContent = () => {
  const containers = document.querySelectorAll(PAGE_CONTENT_SELECTOR);
  if (!containers.length) return;

  containers.forEach((container) => {
    container.querySelectorAll("a[href]").forEach(enhanceAnchor);
  });
};

if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", initPageContent, { once: true });
} else {
  initPageContent();
}
