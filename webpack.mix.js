const mix = require('laravel-mix');
const path = require('path');
const MonacoWebpackPlugin = require('monaco-editor-webpack-plugin');

mix.webpackConfig({
    resolve: {
        alias: {
            "@shop": path.resolve(__dirname, "resources/js"),
            "@shopCss": path.resolve(__dirname, "resources/css")
        },
    },
    stats: {
        children: false,
    },
    plugins: [
        new MonacoWebpackPlugin({
            languages: ['json', 'css', 'html', 'typescript'],
        }),
    ],
})

mix.js('resources/js/app.js', 'js/app.js')
    .js('resources/js/ecommerce.js', 'js/ecommerce.js')
    .version()
    .vue({ version: 3 })
    .postCss('resources/css/app.css', 'css/app.css', [
        require('@tailwindcss/postcss'),
        require("autoprefixer"),
    ])
    .postCss('resources/css/ecommerce.css', 'css/ecommerce.css', [
        require('@tailwindcss/postcss'),
        require("autoprefixer"),
    ]);