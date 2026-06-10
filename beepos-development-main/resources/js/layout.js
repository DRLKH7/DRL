// Sidebar collapse/expand manager with persistence
(() => {
  const STORAGE_KEY = 'sidebar'; // values: 'shown' | 'hidden'

  const getStored = () => {
    try { return localStorage.getItem(STORAGE_KEY); } catch { return null; }
  };
  const setStored = (v) => {
    try { localStorage.setItem(STORAGE_KEY, v); } catch {}
  };

  const apply = (collapsed /* boolean */, { persist } = { persist: true }) => {
    const root = document.documentElement;
    if (collapsed) {
      root.classList.add('sidebar-collapsed');
    } else {
      root.classList.remove('sidebar-collapsed');
    }
    if (persist) setStored(collapsed ? 'hidden' : 'shown');
    updateButtons(collapsed);
  };

  const updateButtons = (collapsed) => {
    document.querySelectorAll('[data-sidebar-toggle]')
      .forEach(btn => btn.setAttribute('aria-pressed', collapsed ? 'true' : 'false'));
  };

  const toggle = () => {
    const collapsed = document.documentElement.classList.contains('sidebar-collapsed');
    apply(!collapsed, { persist: true });
  };

  // Initialize from storage on load
  const stored = getStored();
  if (stored === 'hidden') apply(true, { persist: false });
  else if (stored === 'shown') apply(false, { persist: false });

  // Click handler for toggle buttons
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-sidebar-toggle]');
    if (!btn) return;
    e.preventDefault();
    toggle();
  });

  // Optional: keyboard shortcut Ctrl+\
  document.addEventListener('keydown', (e) => {
    if (e.ctrlKey && e.key === '\\') {
      e.preventDefault();
      toggle();
    }
  });

  // Expose for debugging
  window.sidebar = {
    show: () => apply(false, { persist: true }),
    hide: () => apply(true, { persist: true }),
    toggle,
    status: () => (document.documentElement.classList.contains('sidebar-collapsed') ? 'hidden' : 'shown'),
  };
})();
