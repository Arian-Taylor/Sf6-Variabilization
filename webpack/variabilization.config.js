var path = require('path');
var Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/variabilization_config/')

    // public path used by the web server to access the output path
    .setPublicPath('/build/variabilization_config')

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */

    // test
    .addEntry('default_theme', './assets/sites/DEFAULT/index.js')
    .addEntry('red_site_theme', './assets/sites/RED_SITE/index.js')
    .addEntry('green_site_theme', './assets/sites/GREEN_SITE/index.js')

    // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
    .enableStimulusBridge('./assets/controllers.json')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .disableSingleRuntimeChunk()
    .enableBuildNotifications()
    .enableSassLoader()
    .cleanupOutputBeforeBuild()
    .enablePostCssLoader()
    .enableVueLoader(() => {}, {
        runtimeCompilerBuild: false,
        useJsx: true,
    })

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .enableSourceMaps(false)

    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })
    
    .configureCssLoader((options) => {
        options.url = false; // Désactiver le traitement des URLs dans le css ou scss
    });

var variabilization_config = Encore.getWebpackConfig();

// https://stackoverflow.com/questions/43107233/configuration-resolve-has-an-unknown-property-root
variabilization_config.resolve.modules = [path.resolve('./assets'), 'node_modules']

// Set a unique name for the config (needed later!)
variabilization_config.name = 'variabilization_config';

// reset Encore to build the second config
Encore.reset();

// yarn encore dev --config-name variabilization_config
module.exports = variabilization_config;