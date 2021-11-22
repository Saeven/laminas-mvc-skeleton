module.exports = [{
    entry: './fetchUtilities.ts',
    output: {
        filename: '../../js/fetch.utilities.js',
        libraryTarget: "this",
    },
    resolve: {
        extensions: ['.webpack.js', '.web.js', '.ts', '.js']
    },
    externals: {},
    module: {
        rules: [
            {test: /\.ts$/, loader: 'ts-loader'}
        ]
    }
}];