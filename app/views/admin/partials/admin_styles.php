<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --green:   #008751;
    --green2:  #005c38;
    --yellow:  #FFD600;
    --red:     #E8112D;
    --dark:    #0e1117;
    --dark2:   #161b25;
    --sidebar: #111827;
    --card:    #1f2937;
    --border:  rgba(255,255,255,.07);
    --text:    #f9fafb;
    --muted:   #6b7280;
    --muted2:  #9ca3af;
}

body {
    font-family: 'Poppins', sans-serif;
    background: var(--dark);
    color: var(--text);
    display: flex;
    min-height: 100vh;
}

/* ══ SIDEBAR ═══════════════════════════ */
.sidebar {
    width: 260px;
    flex-shrink: 0;
    background: var(--sidebar);
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    padding: 28px 0;
    position: fixed;
    top: 0; left: 0; bottom: 0;
    overflow-y: auto;
    z-index: 100;
}

.sidebar__brand {
    padding: 0 24px 28px;
    border-bottom: 1px solid var(--border);
    margin-bottom: 20px;
}
.sidebar__brand-name {
    font-size: 1.3rem;
    font-weight: 800;
    color: #fff;
}
.sidebar__brand-name em { font-style: normal; color: var(--yellow); }
.sidebar__brand-tag {
    font-size: .62rem;
    font-weight: 500;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--muted);
    margin-top: 3px;
}

.sidebar__section { padding: 0 12px; margin-bottom: 8px; }
.sidebar__section-label {
    font-size: .6rem;
    font-weight: 700;
    letter-spacing: .16em;
    text-transform: uppercase;
    color: var(--muted);
    padding: 0 12px;
    margin-bottom: 6px;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    border-radius: 10px;
    text-decoration: none;
    color: var(--muted2);
    font-size: .83rem;
    font-weight: 500;
    transition: all .2s;
    margin-bottom: 2px;
}
.nav-item:hover { background: rgba(255,255,255,.05); color: #fff; }
.nav-item.active { background: rgba(0,135,81,.15); color: var(--green); }

.nav-icon { width: 18px; text-align: center; font-size: 1rem; flex-shrink: 0; }

.nav-badge {
    margin-left: auto;
    background: var(--red);
    color: white;
    font-size: .6rem;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 20px;
    min-width: 20px;
    text-align: center;
}

.sidebar__footer {
    margin-top: auto;
    padding: 20px 12px 0;
    border-top: 1px solid var(--border);
}

/* ══ MAIN ══════════════════════════════ */
.main {
    margin-left: 260px;
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* ══ TOPBAR ════════════════════════════ */
.topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 32px;
    border-bottom: 1px solid var(--border);
    background: var(--dark);
    position: sticky;
    top: 0;
    z-index: 50;
}
.topbar__title { font-size: 1rem; font-weight: 700; color: #fff; }
.topbar__sub   { font-size: .72rem; color: var(--muted); margin-top: 2px; }
.topbar__right { display: flex; align-items: center; gap: 16px; }
.topbar__user {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(255,255,255,.05);
    border: 1px solid var(--border);
    padding: 7px 14px;
    border-radius: 30px;
    font-size: .8rem;
    color: var(--muted2);
}
.topbar__avatar {
    width: 26px; height: 26px;
    border-radius: 50%;
    background: var(--green);
    display: flex; align-items: center; justify-content: center;
    font-size: .7rem; font-weight: 700; color: #fff;
}

/* ══ CONTENT ═══════════════════════════ */
.content { padding: 32px; flex: 1; }

/* ══ PAGE HEAD ═════════════════════════ */
.page-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 28px;
    flex-wrap: wrap;
    gap: 16px;
}
.label-tag {
    font-size: .65rem;
    letter-spacing: .18em;
    text-transform: uppercase;
    font-weight: 700;
    color: var(--green);
    margin-bottom: 6px;
}
.page-title { font-size: 1.6rem; font-weight: 800; color: #fff; line-height: 1.1; }
.page-sub   { font-size: .8rem; color: var(--muted); margin-top: 4px; }

/* ══ BOUTONS ═══════════════════════════ */
.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: var(--green);
    color: #fff;
    text-decoration: none;
    font-family: 'Poppins', sans-serif;
    font-size: .85rem;
    font-weight: 600;
    padding: 11px 22px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    transition: background .2s, transform .2s;
}
.btn-primary:hover { background: var(--green2); transform: translateY(-1px); }

.btn-ghost {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(255,255,255,.06);
    border: 1px solid var(--border);
    color: var(--muted2);
    text-decoration: none;
    font-family: 'Poppins', sans-serif;
    font-size: .85rem;
    font-weight: 500;
    padding: 10px 20px;
    border-radius: 10px;
    cursor: pointer;
    transition: all .2s;
}
.btn-ghost:hover { background: rgba(255,255,255,.1); color: #fff; }

/* ══ ALERTES ═══════════════════════════ */
.alert {
    padding: 13px 18px;
    border-radius: 10px;
    font-size: .85rem;
    font-weight: 500;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.alert--success { background: rgba(0,135,81,.12); border: 1px solid rgba(0,135,81,.3); color: #4ade80; }
.alert--error   { background: rgba(232,17,45,.1);  border: 1px solid rgba(232,17,45,.3); color: #f87171; }

/* ══ FILTRES ═══════════════════════════ */
.filters-bar {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 24px;
    align-items: center;
}
.filter-input, .filter-select {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 9px;
    padding: 9px 14px;
    font-family: 'Poppins', sans-serif;
    font-size: .83rem;
    color: #fff;
    outline: none;
    transition: border-color .2s;
}
.filter-input  { min-width: 220px; }
.filter-select { min-width: 160px; }
.filter-input:focus, .filter-select:focus { border-color: var(--green); }
.filter-input::placeholder { color: var(--muted); }
.filter-select option { background: #1f2937; }

.btn-filter {
    background: var(--green);
    color: #fff;
    border: none;
    border-radius: 9px;
    padding: 9px 20px;
    font-family: 'Poppins', sans-serif;
    font-size: .83rem;
    font-weight: 600;
    cursor: pointer;
    transition: background .2s;
}
.btn-filter:hover { background: var(--green2); }

.btn-reset {
    color: var(--muted);
    text-decoration: none;
    font-size: .8rem;
    font-weight: 500;
    transition: color .2s;
}
.btn-reset:hover { color: #fff; }

/* ══ TABLE ═════════════════════════════ */
.table-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
}

.data-table { width: 100%; border-collapse: collapse; }
.data-table th {
    font-size: .65rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--muted);
    padding: 14px 20px;
    text-align: left;
    border-bottom: 1px solid var(--border);
    white-space: nowrap;
}
.data-table td {
    padding: 14px 20px;
    font-size: .83rem;
    border-bottom: 1px solid rgba(255,255,255,.03);
    color: var(--muted2);
    vertical-align: middle;
}
.data-table tr:last-child td { border-bottom: none; }
.data-table tr:hover td { background: rgba(255,255,255,.02); }
.td-bold { color: #fff !important; font-weight: 600; }

/* ══ BADGES ════════════════════════════ */
.badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: .65rem;
    font-weight: 700;
    letter-spacing: .04em;
    white-space: nowrap;
}
.badge--green   { background: rgba(0,135,81,.15);   color: #4ade80; }
.badge--grey    { background: rgba(107,114,128,.15); color: #9ca3af; }
.badge--attente { background: rgba(255,214,0,.12);   color: var(--yellow); }
.badge--red     { background: rgba(232,17,45,.12);   color: #f87171; }
.badge--blue    { background: rgba(59,130,246,.12);  color: #60a5fa; }
.badge--cat     { background: rgba(139,92,246,.12);  color: #a78bfa; }

/* ══ BOUTONS D'ACTION ══════════════════ */
.action-btns { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }

.btn-icon {
    width: 30px; height: 30px;
    border-radius: 7px;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: .85rem;
    text-decoration: none;
    background: rgba(255,255,255,.06);
    color: var(--muted2);
    transition: all .2s;
}
.btn-icon:hover         { background: rgba(255,255,255,.12); color: #fff; }
.btn-icon--blue:hover   { background: rgba(59,130,246,.2);   color: #60a5fa; }
.btn-icon--green:hover  { background: rgba(0,135,81,.2);     color: #4ade80; }
.btn-icon--yellow:hover { background: rgba(255,214,0,.15);   color: var(--yellow); }
.btn-icon--red:hover    { background: rgba(232,17,45,.2);    color: #f87171; }

/* ══ PAGINATION ════════════════════════ */
.pagination {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 16px 20px;
    border-top: 1px solid var(--border);
    flex-wrap: wrap;
}
.page-btn {
    min-width: 32px; height: 32px;
    border-radius: 7px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: .8rem;
    font-weight: 600;
    text-decoration: none;
    color: var(--muted2);
    background: rgba(255,255,255,.05);
    border: 1px solid var(--border);
    transition: all .2s;
    padding: 0 10px;
}
.page-btn:hover  { background: rgba(255,255,255,.1); color: #fff; }
.page-btn.active { background: var(--green); color: #fff; border-color: var(--green); }

/* ══ EMPTY STATE ═══════════════════════ */
.empty-state {
    text-align: center;
    padding: 70px 40px;
    color: var(--muted);
}
.empty-state span { font-size: 3rem; display: block; margin-bottom: 16px; opacity: .5; }
.empty-state h3   { font-size: 1.1rem; font-weight: 700; color: #fff; margin-bottom: 8px; }
.empty-state p    { font-size: .85rem; margin-bottom: 20px; }

/* ══ RESPONSIVE ════════════════════════ */
@media (max-width: 768px) {
    .sidebar  { display: none; }
    .main     { margin-left: 0; }
    .content  { padding: 20px; }
    .topbar   { padding: 16px 20px; }
    .page-head { flex-direction: column; align-items: flex-start; }
}
</style>