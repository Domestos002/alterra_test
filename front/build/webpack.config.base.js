const path = require('path');
const {getEntries} = require('./utils.js');

const entries = getEntries('./src/pages/', 'js');

const config = {
    entry: entries,
    output: {
        pathinfo: false,
        path: path.resolve(__dirname, '../../public/assets'),
        filename: 'js/[name].js',
    },
    resolve: {
        alias: {
            '~': path.resolve(__dirname, './node_modules'),
            '@src': path.resolve(__dirname, '../src'),
            '@components': path.resolve(__dirname, '../src/sass/components'),
            '@sass': path.resolve(__dirname, '../src/sass'), // in sass ~@sass,
            '@images': path.resolve(__dirname, '../src/assets/images'),
            '@js': path.resolve(__dirname, '../src/js'),
        },
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: ['babel-loader'],
            },
            {
                test: /\.(png|jpg|gif|svg)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
                use: [
                    {
                        loader: 'url-loader',
                        options: {
                            limit: 10000,
                            name: 'images/[name].[ext]',
                        },
                    },
                ],
            },
            {
                test: /\.(woff|woff2|otf|ttf|eot)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
                use: [
                    {
                        loader: 'url-loader',
                        options: {
                            limit: 10000,
                            name: 'fonts/[name].[ext]',
                        },
                    },
                ],
            },
            {
                test: /\.(mp4|ogg)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: 'assets/[name].[ext]',
                        },
                    },
                ],
            },
        ],
    },
    parallelism: 8,
    optimization: {
        splitChunks: {
            chunks: 'all',
            cacheGroups: {
                commons: {
                    name: 'commons',
                    chunks: 'initial',
                    minChunks: 2,
                },
                vendors: {
                    chunks: 'initial',
                    name: 'vendors',
                    test: /node_modules\//,
                    minChunks: 5,
                    priority: 10,
                },
                default: {
                    minChunks: 2,
                    priority: -20,
                    reuseExistingChunk: true,
                },
            },
        },
    },
    plugins: [],
};

module.exports = config;
