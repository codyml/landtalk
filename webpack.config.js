const path = require('path')
const ExtractTextPlugin = require('extract-text-webpack-plugin')

module.exports = {

    entry: [
        './static-src/lib/markerclusterer.js',
        'babel-polyfill',
        'whatwg-fetch',
        './static-src/index.js'
    ],

    output: {
        filename: 'script.js',
        path: path.resolve(__dirname, 'landtalk-custom-theme/static'),
        publicPath: '/wp-content/themes/landtalk-custom-theme/static/',
    },

    module: {
        rules: [

            {
                test: /\.jsx?$/,
                exclude: /node_modules/,
                loader: 'babel-loader',
                options: {
                    presets: [ 'env', 'react' ],
                    plugins: [ 'transform-object-rest-spread' ],
                },
            },

            {
                test: /\.s(c|a)ss$/,
                use: ExtractTextPlugin.extract({
                    use: ['css-loader', 'postcss-loader', 'sass-loader'],
                })
            },

            { test: /\.svg$/, loader: 'file-loader?mimetype=image/svg+xml' },
            { test: /\.woff$/, loader: 'file-loader?mimetype=application/font-woff' },
            { test: /\.woff2$/, loader: 'file-loader?mimetype=application/font-woff' },
            { test: /\.ttf$/, loader: 'file-loader?mimetype=application/octet-stream' },
            { test: /\.eot$/, loader: 'file-loader' },
            { test: /\.png$/, loader: 'file-loader', options: {} },

        ],
    },

    plugins: [
        new ExtractTextPlugin('styles.css'),
    ],

}
