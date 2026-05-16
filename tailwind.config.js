/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                primary: '#16a34a',
            }
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
};