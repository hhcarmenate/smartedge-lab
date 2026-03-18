/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './index.html',
    './src/**/*.{vue,js,jsx}'
  ],
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
  },
  plugins: []
}
