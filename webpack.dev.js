const BrowserSyncPlugin = require("browser-sync-webpack-plugin");
const { merge } = require("webpack-merge");
const commonConfig = require("./webpack.common");
const outputFile = "[name]";
const assetFile = "[name]";

module.exports = merge(commonConfig({ outputFile, assetFile }), {
  mode: "development",
  devtool: "source-map",
  target: "web",
  watchOptions: {
    ignored: /node_modules/,
  },
  plugins: [
    new BrowserSyncPlugin({
      host: "localhost",
      port: 3000,
      files: ["./public/*.php", "./public/template-parts/*.php"],
      proxy: "http://cosmos.local/",
    }),
  ],
});