const colors = require('tailwindcss/colors')

module.exports = {
    purge: {
        content: [
            './resources/views/frontend/**/*.blade.php',
            './resources/assets/frontend/**/*.js',
        ]
    },
    darkMode: 'media', // or 'media' or 'class'
    theme: {
        container: {
            center: true,
        },
        extend: {
            colors: {
                blue: {
                    50: '#E2F2FF',
                    100: '#d8eefe',
                    200: '#C5E5FE',
                    300: '#A8D8FD',
                    400: '#8ACBFC',
                    500: '#63B9FB',
                    600: '#3CA7FA',
                    700: '#1692F3',
                    800: '#0B7BD6',
                    900: '#0A68B2',
                }
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
