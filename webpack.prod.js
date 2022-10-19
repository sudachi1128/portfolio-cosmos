const TerserPlugin = require("terser-webpack-plugin");
const OptimizeCssPlugin = require("optimize-css-assets-webpack-plugin");
const { merge } = require("webpack-merge");
const commonConfig = require("./webpack.common");
const outputFile = "[name].[chunkhash]";
const assetFile = "[name].[contenthash]";

module.exports = merge(commonConfig({ outputFile, assetFile }), {
  mode: "production",
  plugins: [],
  optimization: {
    minimizer: [new TerserPlugin(), new OptimizeCssPlugin()],
  },
});
