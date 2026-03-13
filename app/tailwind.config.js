/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './index.html',
    './src/**/*.{vue,js,jsx}'
  ],
  theme: {
    extend: {
      colors: {
        background: {
          DEFAULT: '#050505',
          soft: '#0a0a0a',
          rich: '#020202',
        },
        surface: {
          DEFAULT: '#0f0f10',
          elevated: '#151516',
          top: '#1b1b1d',
        },
        panel: '#0d0d0e',
        card: '#111113',

        border: {
          DEFAULT: 'rgba(255, 255, 255, 0.06)',
          strong: 'rgba(255, 255, 255, 0.12)',
          warm: 'rgba(255, 122, 0, 0.22)',
        },

        text: {
          primary: '#ffffff',
          secondary: '#b3b3b8',
          muted: '#6b6b72',
        },

        accent: {
          DEFAULT: '#ff8a00',
          hover: '#ff9f2f',
          soft: 'rgba(255, 138, 0, 0.10)',
          glow: 'rgba(255, 138, 0, 0.30)',
        },

        success: {
          DEFAULT: '#10b981',
          soft: 'rgba(16, 185, 129, 0.14)',
        },
        danger: {
          DEFAULT: '#ef4444',
          soft: 'rgba(239, 68, 68, 0.14)',
        },
        warning: {
          DEFAULT: '#ff8a00',
          soft: 'rgba(255, 138, 0, 0.14)',
        }
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
        mono: ['JetBrains Mono', 'monospace']
      },
      boxShadow: {
        soft: '0 8px 30px rgba(0, 0, 0, 0.45)',
        elevated: '0 18px 60px rgba(0, 0, 0, 0.55)',
        glow: '0 0 22px rgba(255, 138, 0, 0.18)',
      },
      borderRadius: {
        lg: '0.5rem',
        xl: '0.85rem',
        '2xl': '1.1rem'
      }
    }
  },
  plugins: []
}
