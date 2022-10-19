const path = require("path");
const webpack = require("webpack");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = ({ outputFile, assetFile }) => ({
  entry: path.resolve(__dirname, "src", "js", "index.js"),
  output: {
    path: path.resolve(__dirname, "public"),
    filename: `${outputFile}.js`,
    // file-loaderの役割   以下でバンドル後の画像ディレクトリ・画像ファイル名の設定ができる
    assetModuleFilename: `images/${assetFile}[ext]`,
  },
  module: {
    rules: [
      {
        test: /\.scss$/,
        use: [
          MiniCssExtractPlugin.loader,
          "css-loader",
          "postcss-loader",
          "sass-loader",
        ],
      },
      {
        test: /\.(png|jpe?g|gif|svg|eot|ttf|woff2?)$/i,
        // file-loaderの役割   asset/resourceをmoduleのrulesで指定すると、ビルド時に指定した拡張子の画像がbundleされたjsファイルとは別で出力される。
        type: "asset/resource",
      },
      {
        test: /\.js$/,
        exclude: /node_modules/,
        loader: "babel-loader",
      },
      {
        test: /\.html$/,
        loader: "html-loader",
      },
      {
        enforce: "pre",
        test: /\.js$/,
        exclude: /node_modules/,
        loader: "eslint-loader",
        options: {
          fix: true,
        },
      },
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: "style.css",
    }),
    new webpack.ProvidePlugin({
      THREE: "three/build/three",
    }),
  ],
});
