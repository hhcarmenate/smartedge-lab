# SmartEdge Lab — Frontend Redesign Prompt for Claude Code

## Role & Context

You are a senior Frontend UI/UX Engineer specializing in Vue 3, Vite, and Tailwind CSS. You are tasked with a complete visual and architectural redesign of **SmartEdge Lab**, an options trading intelligence platform. The design system is **cyber dark** — a terminal-inspired aesthetic used by professional trading tools like Bloomberg Terminal and TradingView.

The reference canvas (HTML file provided separately) is the **source of truth** for every visual decision. Your goal is pixel-faithful implementation of that design in a production-grade Vue 3 codebase.

---

## Design System — Implement First, Use Everywhere

### 1. Tailwind Config (`tailwind.config.js`)

Extend the default theme with these custom tokens. Every component must use these tokens — never hardcode hex values in components.

```js
theme: {
  extend: {
    colors: {
      'bg-base':      '#04070F',
      'bg-surface':   '#0C1220',
      'bg-elevated':  '#111929',
      'bg-hover':     '#162035',
      'border':       '#1A2640',
      'border-strong':'#243352',
      'cyan':         '#00D4FF',
      'cyan-dim':     '#00A8CC',
      'violet':       '#7B5CF5',
      'violet-dim':   '#5B3FD4',
      'profit':       '#00E676',
      'profit-dim':   '#00B85A',
      'loss':         '#FF3366',
      'loss-dim':     '#CC2250',
      'warn':         '#FFB300',
      'text-primary': '#E2E8F4',
      'text-muted':   '#8B9DC3',
      'text-ghost':   '#4A5A7A',
    },
    fontFamily: {
      sans:  ['"Space Grotesk"', 'sans-serif'],
      mono:  ['"JetBrains Mono"', 'monospace'],
    },
    borderRadius: {
      card: '10px',
      chip: '6px',
      pill: '20px',
    },
  }
}
```

### 2. Google Fonts (`index.html`)

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=JetBrains+Mono:wght@300;400;500;600&display=swap" rel="stylesheet">
```

### 3. Global CSS (`src/styles/tokens.css`)

```css
body {
  background-color: #04070F;
  color: #E2E8F4;
  font-family: 'Space Grotesk', sans-serif;
}

::-webkit-scrollbar { width: 4px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: #243352; border-radius: 2px; }
```

---

## Typography Rules — Apply Consistently

| Use case | Classes |
|---|---|
| Page / section title | `font-sans text-2xl font-bold tracking-tight` |
| Card / panel title | `font-sans text-sm font-semibold tracking-wide` |
| Body / description | `font-sans text-sm font-normal text-text-muted` |
| Field label | `font-mono text-[10px] font-medium uppercase tracking-widest text-text-ghost` |
| Prices / tickers / values | `font-mono text-sm font-semibold` |
| Metadata / timestamps | `font-mono text-[10px] text-text-ghost` |

---

## File Structure to Create/Refactor

```
src/
├── assets/
├── components/
│   ├── ui/
│   │   ├── AppBadge.vue        # semantic color badges
│   │   ├── AppButton.vue       # primary + ghost variants
│   │   ├── MetricCard.vue      # KPI stat card with accent top bar
│   │   ├── PanelCard.vue       # surface panel with header slot
│   │   └── ScoreBar.vue        # progress bar for signal score
│   ├── layout/
│   │   ├── AppShell.vue        # root shell: sidebar + topbar + <slot>
│   │   ├── AppSidebar.vue      # icon-only sidebar (52px wide)
│   │   └── AppTopbar.vue       # topbar with clock, badges, avatar
│   ├── home/
│   │   ├── HeroSection.vue
│   │   ├── TickerTape.vue
│   │   ├── TerminalPreview.vue
│   │   ├── FeatureGrid.vue
│   │   └── CtaSection.vue
│   ├── dashboard/
│   │   ├── MetricsRow.vue
│   │   ├── SignalsTable.vue
│   │   ├── PnLChart.vue
│   │   ├── MarketHeatMap.vue
│   │   ├── PortfolioMini.vue
│   │   ├── ScannerHighlights.vue
│   │   └── AlertsFeed.vue
│   ├── scanner/
│   ├── signals/
│   ├── portfolio/
│   ├── charts/
│   └── strategy/
├── composables/
│   ├── useClock.js             # real-time HH:MM:SS clock
│   ├── useMarketData.js
│   └── useSignals.js
├── stores/
│   ├── signals.js
│   ├── scanner.js
│   └── portfolio.js
├── views/
│   ├── HomeView.vue
│   ├── DashboardView.vue
│   ├── ScannerView.vue
│   ├── SignalsView.vue
│   ├── PortfolioView.vue
│   ├── ChartsView.vue
│   └── SettingsView.vue
├── router/index.js
├── styles/
│   ├── tailwind.css
│   └── tokens.css
└── App.vue
```

---

## Component Specifications

### `AppShell.vue`
- Fixed sidebar (52px) on the left + flex main column
- Main column = topbar (48px) + scrollable content area
- `<slot name="content" />` for page content
- Background: `bg-bg-base`
- No padding on shell itself — pages handle their own padding

### `AppSidebar.vue`
- Width: `w-[52px]`, `bg-bg-surface`, `border-r border-border`
- Logo mark at top: 32×32px, `bg-cyan/10 border border-cyan/20 rounded-chip`, monospace "S"
- Icon items: 36×36px rounded-chip, `text-text-ghost hover:bg-bg-hover hover:text-cyan`
- Active state: `bg-bg-hover text-cyan` + left accent bar (2px wide, 20px tall, `bg-cyan`, absolute left-0)
- Icons via emoji or a minimal SVG icon set — no external icon library unless already in project
- Spacer pushes settings/profile icons to bottom

### `AppTopbar.vue`
- Height: `h-12`, `bg-bg-surface border-b border-border`
- Left: page title (`text-sm font-semibold`) + market status pill (`text-profit font-mono text-[11px]` with animated green dot)
- Right: live clock (composable `useClock`), LIVE badge, PRO badge, avatar circle
- Clock: `font-mono text-[11px] text-text-ghost`, updates every second via `setInterval`
- Badges: `font-mono text-[10px] font-semibold px-2 py-0.5 rounded`
    - LIVE: `bg-profit/10 text-profit border border-profit/20`
    - PRO: `bg-violet/10 text-violet border border-violet/20`
- Avatar: 28×28px circle, `bg-gradient-to-br from-violet to-cyan text-bg-base text-[10px] font-bold`

### `MetricCard.vue`
Props: `label`, `value`, `change`, `changeType` (up/neutral/down), `accent` (cyan/green/violet/warn)

```
- bg-bg-surface border border-border rounded-card p-4
- Top accent bar: absolute top-0 left-0 right-0 h-0.5, color matches accent prop
- Label: font-mono text-[10px] uppercase tracking-widest text-text-ghost mb-1.5
- Value: font-mono text-[22px] font-semibold leading-none mb-1, color matches accent
- Change: font-mono text-[10px] flex items-center gap-1
  - up: text-profit-dim
  - down: text-loss
  - neutral: text-text-ghost
```

### `PanelCard.vue`
Slots: `header`, `actions`, `default`

```
- bg-bg-surface border border-border rounded-card overflow-hidden
- Header: px-4 py-3 border-b border-border flex items-center justify-between
  - Title slot: text-sm font-semibold tracking-wide
  - Actions slot: flex gap-1.5 items-center
- Default slot: the panel body content
```

### `ScoreBar.vue`
Props: `score` (0–100)

```
- flex items-center gap-1.5
- Bar: flex-1 h-1 bg-bg-hover rounded-full overflow-hidden
  - Fill: h-full rounded-full, width = score%
  - Color: score >= 75 → bg-profit | score >= 50 → bg-warn | else → bg-loss
- Number: font-mono text-[10px] text-text-muted min-w-[22px]
```

### `AppBadge.vue`
Props: `variant` (cyan/green/amber/red/violet), `label`

```
font-mono text-[10px] font-semibold px-1.5 py-0.5 rounded
cyan:   bg-cyan/10   text-cyan   border border-cyan/20
green:  bg-profit/10 text-profit border border-profit/20
amber:  bg-warn/10   text-warn   border border-warn/20
red:    bg-loss/10   text-loss   border border-loss/20
violet: bg-violet/10 text-violet border border-violet/20
```

---

## Page: `HomeView.vue`

### `TickerTape.vue`
- `bg-bg-surface border-y border-border py-2.5 overflow-hidden whitespace-nowrap`
- Inner div: `inline-flex`, CSS animation `translateX(0) → translateX(-50%)` over 20s linear infinite
- Duplicate the ticker array so loop is seamless
- Each item: `inline-flex items-center gap-1.5 px-6 border-r border-border font-mono text-[11px]`
    - Symbol: `text-text-primary font-semibold`
    - Price: `text-text-muted`
    - Change: positive → `text-profit`, negative → `text-loss`

### `HeroSection.vue`
- `relative px-10 py-20 min-h-[460px] flex items-center overflow-hidden`
- Grid background: CSS `background-image` with two linear-gradients forming a grid, opacity-30
- Radial glow: absolute pseudo-element, `bg-[radial-gradient(ellipse,rgba(0,212,255,0.07),transparent_70%)]`
- Content max-width: 600px, z-index above bg effects
- Tag pill: `inline-flex items-center gap-1.5 bg-cyan/8 border border-cyan/20 text-cyan font-mono text-[11px] px-3 py-1 rounded-pill mb-6` with animated dot
- H1: `text-[42px] font-bold leading-[1.1] tracking-tight mb-4`
    - "before" → `text-cyan`, "market" → `text-violet`
- Subtext: `text-text-muted text-[15px] leading-relaxed max-w-[480px] mb-8`
- CTA buttons: primary (`bg-cyan text-bg-base font-bold`) + ghost (`border border-border-strong text-text-primary`)
- Stats row: `flex gap-6 mt-10 pt-8 border-t border-border`
    - Value: `font-mono text-[20px] font-semibold`
    - Label: `text-[11px] text-text-ghost mt-0.5 tracking-wide`

### `TerminalPreview.vue`
- Absolute positioned right-10, vertically centered, width 340px
- `bg-bg-surface border border-border-strong rounded-xl overflow-hidden z-10`
- Title bar: `bg-bg-elevated px-3.5 py-2.5 flex items-center gap-1.5 border-b border-border`
    - Three traffic-light dots (8px circles): `#FF6058`, `#FFBD2E`, `#28C840`
    - Title: `font-mono text-[10px] text-text-ghost ml-1.5 tracking-wider`
- Body: `p-3.5 font-mono text-[11px] leading-[1.9]`
    - Prompt: `text-text-ghost`
    - Command text: `text-cyan`
    - Output lines: `text-text-muted pl-4`
    - Score fill chars: `text-profit`
    - Alert: `text-warn`
    - Blinking cursor: CSS `animation: blink 1s step-start infinite`

### `FeatureGrid.vue`
- 3-column CSS grid, gap-4
- Each card: `bg-bg-surface border border-border rounded-xl p-5 transition-all duration-250 hover:border-border-strong hover:bg-bg-elevated hover:-translate-y-0.5`
- Icon container: 36×36px `rounded-chip flex items-center justify-center text-base mb-3.5`
    - Use rgba background + border matching the accent color per feature
- Title: `text-[13px] font-semibold mb-1.5`
- Desc: `text-text-muted text-[12px] leading-relaxed`

---

## Page: `DashboardView.vue`

Layout: `flex flex-col gap-3.5 p-4 bg-bg-base`

### `MetricsRow.vue`
- `grid grid-cols-4 gap-2.5`
- Four `MetricCard` instances:
    1. Active Signals — accent: cyan
    2. Portfolio P&L — accent: green
    3. IV Rank (SPY) — accent: violet
    4. Contracts Scanned — accent: warn

### Row 1: `grid grid-cols-[3fr_2fr] gap-3.5`

**`SignalsTable.vue` (left — 3fr)**
- `PanelCard` wrapper
- Header: title "Top Signals" + badge "24 live" (cyan) + filter buttons (All / Bullish / Bearish)
- Filter buttons: `font-mono text-[10px] px-2.5 py-0.5 rounded border border-border-strong bg-transparent text-text-ghost hover:bg-bg-hover hover:text-text-primary`
- Table: `w-full border-collapse text-[11px]`
    - TH: `text-left px-2.5 py-2 text-text-ghost font-mono text-[10px] tracking-wider border-b border-border`
    - TD: `px-2.5 py-2.5 border-b border-border/60 align-middle`
    - TR hover: `hover:bg-bg-elevated`
- Columns: Ticker | Strategy | Score | IV Rank | P&L | Expires
- Ticker: `font-mono font-bold text-[12px] text-text-primary`
- Strategy badge: use `AppBadge` — bull=green, bear=red, neutral=amber
- Score: `ScoreBar` component
- IV Rank: cyan if >80, warn if 60–80, text-muted if <60
- P&L: `font-mono font-semibold` — positive=`text-profit`, negative=`text-loss`
- Expires: `font-mono text-[10px] text-text-ghost`

**Right column (2fr): stacked flex column, gap-3.5**

**`PnLChart.vue`**
- `PanelCard` wrapper, header "SPY — P&L Curve" + badge "+6.3% today" (green)
- Chart area: 140px tall, SVG with viewBox="0 0 340 120" preserveAspectRatio="none"
- Grid lines: `stroke: border color`, `stroke-width: 0.5`, `stroke-dasharray: 2 4`
- P&L line: `stroke: cyan`, `stroke-width: 1`
- Fill area under line: linearGradient from `profit/25` to `profit/0`
- Axis labels: `fill: text-ghost color`, `font-size: 9px`, `font-family: monospace`

**`MarketHeatMap.vue`**
- `PanelCard` wrapper, header "Market Heat"
- Inner: `grid grid-cols-4 gap-1`
- Each cell: `rounded-chip p-2 text-center cursor-pointer transition-[filter] hover:brightness-125`
- Cell classes by change magnitude:
    - >+2%: `bg-profit/18 text-profit`
    - +1–2%: `bg-profit/10 text-profit-dim`
    - 0–1%: `bg-profit/5 text-profit-dim`
    - neutral: `bg-text-muted/6 text-text-ghost`
    - -0.5–0%: `bg-loss/5 text-loss-dim`
    - <-0.5%: `bg-loss/10 text-loss`
- Ticker: `font-mono text-[10px] font-bold mb-0.5`
- Change: `font-mono text-[10px]`

### Row 2: `grid grid-cols-3 gap-3.5`

**`PortfolioMini.vue`**
- `PanelCard` with header "Open Positions" + total P&L badge (green)
- Each row: `flex items-center justify-between py-2.5 border-b border-border/60 last:border-0`
- Left: icon + name stack
    - Icon: 28×28px `rounded-chip flex items-center justify-center font-mono text-[10px] font-bold`
        - Use appropriate color variant per position type
    - Name: `text-[12px] font-semibold`
    - Type: `font-mono text-[10px] text-text-ghost`
- Right: value (`font-mono text-[12px] font-semibold`) + pct change (`font-mono text-[10px]`)

**`ScannerHighlights.vue`**
- `PanelCard` with header "Scanner Highlights" + badge "IV >70" (cyan)
- Each row: `flex items-center justify-between py-2 px-1 rounded border-b border-border/60 last:border-0 hover:bg-bg-elevated cursor-pointer transition-colors`
- Left: ticker (`font-mono text-[12px] font-bold`) + contract info (`font-mono text-[10px] text-text-ghost`)
- Right: IV rank (`font-mono text-[11px] text-cyan font-semibold`) + score badge

**`AlertsFeed.vue`**
- `PanelCard` with header "Live Alerts" + badge "3 new" (amber)
- Each row: `flex gap-2.5 items-start py-2.5 border-b border-border/60 last:border-0`
- Colored dot: 6×6px circle, `mt-1 flex-shrink-0`
    - cyan dot = scanner signal, green = trigger fired, amber = market alert, red = risk/stop
- Body: title (`text-[11px] font-medium`) + timestamp (`font-mono text-[10px] text-text-ghost`)

---

## Animation Specs

### Ticker tape
```css
@keyframes ticker {
  0%   { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
.ticker-inner {
  animation: ticker 20s linear infinite;
}
```

### Pulse dot (market open indicator, logo dot)
```css
@keyframes pulse {
  0%, 100% { opacity: 1; }
  50%       { opacity: 0.4; }
}
```

### Blinking cursor
```css
@keyframes blink {
  0%, 100% { opacity: 1; }
  50%       { opacity: 0; }
}
```

---

## Composable: `useClock.js`

```js
import { ref, onMounted, onUnmounted } from 'vue'

export function useClock() {
  const time = ref('')

  function update() {
    const n = new Date()
    const h = String(n.getHours()).padStart(2, '0')
    const m = String(n.getMinutes()).padStart(2, '0')
    const s = String(n.getSeconds()).padStart(2, '0')
    time.value = `${h}:${m}:${s} EST`
  }

  let interval
  onMounted(() => { update(); interval = setInterval(update, 1000) })
  onUnmounted(() => clearInterval(interval))

  return { time }
}
```

---

## Router (`router/index.js`)

```js
import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  { path: '/',          component: () => import('../views/HomeView.vue') },
  { path: '/dashboard', component: () => import('../views/DashboardView.vue') },
  { path: '/scanner',   component: () => import('../views/ScannerView.vue') },
  { path: '/signals',   component: () => import('../views/SignalsView.vue') },
  { path: '/portfolio', component: () => import('../views/PortfolioView.vue') },
  { path: '/charts',    component: () => import('../views/ChartsView.vue') },
  { path: '/settings',  component: () => import('../views/SettingsView.vue') },
]

export default createRouter({ history: createWebHistory(), routes })
```

---

## Implementation Rules (Non-Negotiable)

1. **No hardcoded hex values** anywhere in `.vue` files — use Tailwind tokens only.
2. **All data is prop-driven or store-driven** — no hardcoded strings inside table rows or cards. Use `v-for` with mock data arrays defined in `<script setup>`.
3. **Composition API only** — `<script setup>` syntax throughout. No Options API.
4. **No external UI libraries** (no PrimeVue, Naive UI, etc.) — design system is fully custom.
5. **Every monetary value** uses `Intl.NumberFormat` or `.toFixed(2)` — never raw JS floats.
6. **Responsive consideration**: layout should not break below 1200px but full optimization is secondary to desktop fidelity.
7. **Transitions**: use `transition-colors duration-150` and `transition-all duration-200` for hover states. No heavy animations except ticker and pulse.
8. **SVG charts inline** — no charting library for the mini P&L curve. Raw `<svg>` with `viewBox` and `preserveAspectRatio="none"` as shown in spec.
9. **Home page is standalone** — it does NOT use `AppShell`. It has its own nav. Only dashboard+ views use `AppShell`.
10. **`App.vue`** is just `<router-view />` with no wrapper styles.

---

## Mock Data to Use

Define in composables or directly in components:

```js
// Signals
const signals = [
  { ticker: 'TSLA', strategy: 'Call Debit', type: 'bull', score: 87, ivRank: 92.4, pnl: 840,   expires: 'Mar 21' },
  { ticker: 'SPY',  strategy: 'Put Spread', type: 'bear', score: 79, ivRank: 78.1, pnl: 320,   expires: 'Mar 19' },
  { ticker: 'NVDA', strategy: 'Iron Condor',type: 'bull', score: 72, ivRank: 65.8, pnl: 1240,  expires: 'Mar 28' },
  { ticker: 'AAPL', strategy: 'Straddle',   type: 'neu',  score: 68, ivRank: 61.2, pnl: -180,  expires: 'Apr 4'  },
  { ticker: 'META', strategy: 'Bear Call',  type: 'bear', score: 55, ivRank: 44.7, pnl: -90,   expires: 'Apr 11' },
]

// Portfolio positions
const positions = [
  { id: 'C',  name: 'TSLA $250C', type: 'Call Debit · Mar 21',  pnl: 840,  pct: 18.4, color: 'green'  },
  { id: 'IC', name: 'NVDA Condor',type: 'Iron Condor · Mar 28', pnl: 1240, pct: 24.1, color: 'green'  },
  { id: 'S',  name: 'AAPL Straddle',type:'Straddle · Apr 4',    pnl: -180, pct: -3.6, color: 'amber'  },
  { id: 'P',  name: 'SPY $540P',  type: 'Put Spread · Mar 19',  pnl: 320,  pct: 8.2,  color: 'red'    },
]

// Market heat
const heatmap = [
  { sym: 'TSLA', chg: 3.4 }, { sym: 'NVDA', chg: 2.2 },
  { sym: 'QQQ',  chg: 1.1 }, { sym: 'SPY',  chg: 0.8 },
  { sym: 'AMZN', chg: 0.7 }, { sym: 'MSFT', chg: 0.0 },
  { sym: 'AAPL', chg: -0.2}, { sym: 'META', chg: -0.9},
]

// Ticker tape
const tickers = [
  { sym: 'SPY',  price: 541.20, chg: 0.84  },
  { sym: 'QQQ',  price: 462.75, chg: 1.12  },
  { sym: 'AAPL', price: 189.40, chg: -0.23 },
  { sym: 'TSLA', price: 248.10, chg: 3.41  },
  { sym: 'NVDA', price: 876.30, chg: 2.18  },
  { sym: 'VIX',  price: 18.42,  chg: -4.20 },
  { sym: 'AMZN', price: 182.60, chg: 0.67  },
  { sym: 'META', price: 520.15, chg: -0.88 },
]

// Alerts
const alerts = [
  { dot: 'cyan',  title: 'TSLA: Unusual call volume 3.8x avg',   time: '09:47:12' },
  { dot: 'green', title: 'Signal triggered: GME $22C Apr 4',      time: '09:43:05' },
  { dot: 'amber', title: 'VIX spike detected — +4.2% in 15m',    time: '09:38:44' },
  { dot: 'red',   title: 'AAPL Straddle: stop threshold hit',     time: '09:31:20' },
  { dot: 'green', title: 'NVDA Condor: +24% — consider exit',     time: '09:22:08' },
]

// Scanner highlights
const scannerHighlights = [
  { ticker: 'GME',  contract: '$22C · Apr 4 · Δ 0.42',   iv: 96.2, score: 94 },
  { ticker: 'MSTR', contract: '$180P · Mar 21 · Δ -0.35', iv: 88.4, score: 88 },
  { ticker: 'PLTR', contract: '$26C · Apr 11 · Δ 0.39',   iv: 81.7, score: 82 },
  { ticker: 'AMD',  contract: '$175C · Mar 28 · Δ 0.30',  iv: 74.3, score: 76 },
]
```

---

## Visual Reference

The canonical reference is the file `smartedge_lab_canvas.html`. When in doubt about any color, spacing, font size, border, or layout decision — open that file in a browser and match it exactly. The canvas is the contract.
