var HTMLWebpackPlugin = require('html-webpack-plugin');
var HTMLWebpackPluginConfig = new HTMLWebpackPlugin({
    template: __dirname + "/src/index.html",
    filename: 'index.html',
    inject: 'body',
    hash: true,
});

module.exports = {
  entry: __dirname + '/src/index.js',
  output: {
    path: __dirname + '/build',
    filename: 'bundle.js',
  },
  devServer: {
      port: 3000,
      historyApiFallback: true,
      stats: {
        chunks: false,
      },
  },
  resolve: {
      extensions: ['.js', '.json'],
  },
  module: {
    loaders: [
      { test: /\.js$/, loader: 'babel-loader', exclude: /node_modules/ },
      { test: /\.scss$/, loader: ['style-loader', 'css-loader', 'sass-loader'], exclude: /node_modules/ },
    ]
  },
  plugins: [HTMLWebpackPluginConfig],
}
