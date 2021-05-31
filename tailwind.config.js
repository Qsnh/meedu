const colors = require('tailwindcss/colors')

module.exports = {
    purge: {
        content: [
            './resources/**/*.blade.php',
            './resources/**/*.js',
        ]
    },
    darkMode: 'media', // or 'media' or 'class'
    theme: {
        container: {
            center: true,
        },
        extend: {
            colors: {
                rose: colors.rose,
            },
        },
    },
    variants: {
        extend: {},
    },
    plugins: [
        // require('@tailwindcss/forms'),
    ],
}
