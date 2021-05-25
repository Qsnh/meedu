// const colors = require('tailwindcss/colors')

module.exports = {
    purge: {
        content: [
            './resources/**/*.blade.php',
            './resources/**/*.js',
        ]
    },
    darkMode: 'media', // or 'media' or 'class'
    theme: {
        // colors: colors,
        container: {
            center: true,
        },
        extend: {},
    },
    variants: {
        extend: {},
    },
    plugins: [],
}
