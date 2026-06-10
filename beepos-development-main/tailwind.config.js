/**
 * Tailwind CSS configuration migrated from inline @theme in app.css
 * Generated on 2025-11-16.
 * 
 * Custom extensions for BeePOS:
 * - Animations: slideIn, fadeIn, slideInRight, slideUp
 * - Scrollbar customization utilities
 * - Product card hover effects
 * - Button transitions
 */
import defaultTheme from 'tailwindcss/defaultTheme';
import plugin from 'tailwindcss/plugin';

export default {
  darkMode: 'class',
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './storage/framework/views/*.php',
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php'
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Instrument Sans', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        primary: {
          50: '#fff8e1',
          100: '#ffefb3',
          200: '#ffe580',
          300: '#ffd54d',
          400: '#ffc61a',
          500: '#f0b100',
          600: '#d99f00',
          700: '#b38100',
          800: '#8c6500',
          900: '#6b4e00',
          950: '#3d2c00'
        },
        secondary: {
          50: '#edfdfa',
          100: '#d1faee',
          200: '#a7f3da',
          300: '#6ee7bf',
          400: '#34d3a6',
          500: '#14b8a6',
          600: '#0d9488',
          700: '#0f766e',
          800: '#115e59',
          900: '#134e4a',
          950: '#062c2a'
        }
      },
      // Custom animations for modals, slides, and notifications
      animation: {
        'slide-in': 'slideIn 0.3s cubic-bezier(0.4, 0, 0.2, 1)',
        'fade-in': 'fadeIn 0.2s cubic-bezier(0.4, 0, 0.2, 1)',
        'slide-in-right': 'slideInRight 0.4s cubic-bezier(0.4, 0, 0.2, 1)',
        'slide-up': 'slideUp 0.3s cubic-bezier(0.4, 0, 0.2, 1)',
      },
      keyframes: {
        slideIn: {
          'from': { opacity: '0', transform: 'translateX(100%)' },
          'to': { opacity: '1', transform: 'translateX(0)' }
        },
        fadeIn: {
          'from': { opacity: '0', transform: 'translateY(4px)' },
          'to': { opacity: '1', transform: 'translateY(0)' }
        },
        slideInRight: {
          'from': { opacity: '0', transform: 'translateX(100%)' },
          'to': { opacity: '1', transform: 'translateX(0)' }
        },
        slideUp: {
          'from': { opacity: '0', transform: 'translateY(16px)' },
          'to': { opacity: '1', transform: 'translateY(0)' }
        }
      },
      // Extra small breakpoint for very small mobile devices
      screens: {
        'xs': '475px',
      }
    }
  },
  plugins: [
    // Custom scrollbar plugin
    plugin(function ({ addUtilities }) {
      const scrollbarUtilities = {
        '.scrollbar-custom': {
          '&::-webkit-scrollbar': {
            width: '6px',
            height: '6px',
          },
          '&::-webkit-scrollbar-track': {
            background: 'transparent',
          },
          '&::-webkit-scrollbar-thumb': {
            background: 'rgb(203 213 225)',
            borderRadius: '3px',
          },
          '&::-webkit-scrollbar-thumb:hover': {
            background: 'rgb(148 163 184)',
          },
        },
      };
      addUtilities(scrollbarUtilities);
    }),

    // Product card hover effects plugin
    plugin(function ({ addComponents }) {
      const components = {
        '.product-card': {
          transition: 'all 0.2s cubic-bezier(0.4, 0, 0.2, 1)',
          '&:hover': {
            transform: 'translateY(-2px)',
          },
          '&:active': {
            transform: 'scale(0.98)',
          },
        },
        '.cart-item': {
          animation: 'fadeIn 0.2s ease-out',
          transition: 'all 0.15s ease',
          '&:hover': {
            backgroundColor: 'rgb(248 250 252)',
          },
        },
        '.btn-hover': {
          transition: 'all 0.15s ease',
          '&:active': {
            transform: 'scale(0.97)',
          },
        },
      };
      addComponents(components);
    }),
  ]
};
