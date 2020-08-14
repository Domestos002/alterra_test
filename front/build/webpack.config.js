const path = require('path');
const webpackMerge = require('webpack-merge');
const webpackConfigBase = require('./webpack.config.base.js');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const portfinder = require('portfinder');
const autoprefixer = require('autoprefixer');
const env = process.env.NODE_ENV;
const cssnano = require('cssnano');

module.exports = webpackMerge(webpackConfigBase, {
    module: {
        rules: [
            {
                test: /\.sass$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader', options: {importLoaders: 1}
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            plugins: [
                                cssnano,
                                autoprefixer
                            ],
                            sourceMap: true
                        }
                    },
                    {
                        loader: 'sass-loader',
                        options: {sourceMap: true}
                    },
                ]
            },
        ],
    },
    devServer: {
        contentBase: path.resolve(__dirname, '../public/assets'),
        writeToDisk: true,
        port: 8081,
        publicPath: 'http://localhost:8090/'
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: 'css/[name].css',
        }),
    ],
});
