module.exports = {
    purge:  [
        __dirname+'/../../templates/admin/**/*.html.twig',
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {},
    },
    variants: {},
    plugins: [
        require('@tailwindcss/forms'),
    ],
}
