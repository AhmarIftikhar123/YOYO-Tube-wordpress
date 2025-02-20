const path = require("path"); // Core module for working with file paths
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const TerserPlugin = require("terser-webpack-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin"); // Optional for CSS minification
const { CleanWebpackPlugin } = require("clean-webpack-plugin"); // Import the plugin
const CopyPlugin = require("copy-webpack-plugin"); // Import the plugin
const DependencyExtractionWebpackPlugin = require("@wordpress/dependency-extraction-webpack-plugin");
// Define directories
const LIB_DIR = path.resolve(__dirname, "assets/src/library/css/slick"); // Source library folder
const BUILD_DIR = path.resolve(__dirname, "dist"); // Output build folder

const JS_DIR = "./assets/src/js/";
const entry = {
  main: JS_DIR + "main.js",
  editor: JS_DIR + "editor.js",
  block: JS_DIR + "block.js",
  single: JS_DIR + "single.js",
  author: JS_DIR + "author.js",
  search: JS_DIR + "search.js",
};

module.exports = {
  entry: entry, // Entry point of your application
  output: {
    path: BUILD_DIR, // Output directory
    filename: "[name].js", // Output JavaScript file
  },
  mode: "development", // Set mode to 'production' for optimized builds
  module: {
    rules: [
      {
        test: /\.(js|jsx)$/, // Apply this rule to JavaScript and JSX files
        exclude: /node_modules/,
        use: {
          loader: "babel-loader", // Transpile JavaScript with Babel
          options: {
            presets: [
              "@babel/preset-env", // Transpile ES6+ to ES5
              "@babel/preset-react", // Transpile JSX to JavaScript
            ],
          },
        },
      },
      {
        test: /\.scss$/, // Apply this rule to SCSS files
        use: [MiniCssExtractPlugin.loader, "css-loader", "sass-loader"],
      },
      {
        test: /\.(png|jpg|svg|gif|ico)$/, // Match image files
        use: {
          loader: "file-loader", // Use file-loader to process
          options: {
            name: "[name].[ext]", // Specify the output file name pattern
            outputPath: "images/", // Define the output directory for images
            publicPath:
              process.env.NODE_ENV === "production" ? "../" : "../../", // Set the public path dynamically based on environment
          },
        },
      },
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: "mini_css/[name].css", // Output CSS file
    }),
    new CleanWebpackPlugin(), // Add the CleanWebpackPlugin to the plugins array
    new DependencyExtractionWebpackPlugin({
      injectPolyfill: true,
      combineAssets: true,
    }),
    new CopyPlugin({
      patterns: [{ from: LIB_DIR, to: BUILD_DIR + "/library" }],
    }),
  ],
  optimization: {
    minimize: false, // Enable optimization
    minimizer: [
      new TerserPlugin({
        terserOptions: {
          compress: {
            drop_console: false,
          },
        },
      }), // Minify JavaScript
      new CssMinimizerPlugin(), // Minify CSS (optional, recommended)
    ],
  },
  externals: {
    jquery: "jQuery", // Externalize jQuery to avoid bundling it
  },
  resolve: {
    extensions: [".js", ".jsx"], // Resolve .js and .jsx files without explicitly specifying extensions
  },
};
