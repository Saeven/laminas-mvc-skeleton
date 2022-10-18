const defaultTheme = require('tailwindcss/defaultTheme')
const colors = require('tailwindcss/colors');

const {PWD} = process.env.INIT_CWD; // This will not have a trailing slash

module.exports = {
    content: [
        `${PWD}/../../../../../module/**/**.{twig,php}`,
        `${PWD}/../../../../../vendor/saeven/circlical-laminas-tailwind-forms/config/module.config.php`
    ],
    darkMode: 'media', // or 'media' or 'class'
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                orange: colors.orange,
            },
            animation: {
                fadeIn: "fadeIn 1s ease-in"
            },
            keyframes: {
                fadeIn: {
                    "0%": {opacity: 0},
                    "100%": {opacity: 1}
                }
            }
        },
    },
    variants: {
        backgroundColor: ['responsive', 'hover', 'focus', 'active', 'disabled'],
        textColor: ['responsive', 'hover', 'focus', 'active', 'disabled'],
        extend: {},
        animation: ['motion-safe']
    },
    plugins: [
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
