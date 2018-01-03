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
                    use: ['css-loader?sourceMap', 'postcss-loader?sourceMap', 'sass-loader?sourceMap'],
                })
            },

        ],
    },

    plugins: [
        new ExtractTextPlugin('styles.css'),
    ],
    
}
