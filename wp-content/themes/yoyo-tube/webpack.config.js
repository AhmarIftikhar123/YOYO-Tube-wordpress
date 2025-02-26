const path = require("path"); // Core module for working with file paths
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const TerserPlugin = require("terser-webpack-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin"); // Optional for CSS minification
const { CleanWebpackPlugin } = require("clean-webpack-plugin");

const JS_DIR = "./assets/src/js/";

const entery = {
  main: JS_DIR + "main.js", // Entry point of your application
  upload_video: JS_DIR + "upload_video.js",
};
module.exports = {
  entry: entery,
  output: {
    path: path.resolve(__dirname, "dist"), // Output directory
    filename: "[name].js", // Output JavaScript file with default name
  },
  mode: "development", // Set mode to 'production' for optimized builds
  module: {
    rules: [
      {
        test: /\.js$/, // Apply this rule to JavaScript files
        exclude: /node_modules/, // Exclude node_modules directory
        use: {
          loader: "babel-loader", // Transpile JavaScript with Babel
        },
      },
      {
        test: /\.scss$/, // Apply this rule to CSS files
        use: [
          MiniCssExtractPlugin.loader, // Extract CSS into separate files
          "css-loader",
          "sass-loader", // Translates CSS into CommonJS modules
        ],
      },
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: "mini_css/[name].css", // Output CSS file
    }),
    new CleanWebpackPlugin(), // Add the CleanWebpackPlugin to the plugins array
  ],
  optimization: {
    minimize: true, // Enable optimization
    minimizer: [
      new TerserPlugin(), // Minify JavaScript
      new CssMinimizerPlugin(), // Minify CSS
    ],
  },
  externals: {
    jquery: "jQuery",
  },
};
