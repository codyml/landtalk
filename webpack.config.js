const path = require('path')
const ExtractTextPlugin = require('extract-text-webpack-plugin')

module.exports = {
    
    entry: './static-src/main.js',
    output: {
        filename: 'script.js',
        path: path.resolve(__dirname, 'landtalk-custom-theme/static'),
    },

    module: {
        rules: [

            {
                test: /\.jsx?$/,
                exclude: /node_modules/,
                loader: 'babel-loader',
                options: {
                    presets: ['env', 'react'],
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

        ],
    },

    plugins: [
        new ExtractTextPlugin('styles.css'),
    ],
    
}
