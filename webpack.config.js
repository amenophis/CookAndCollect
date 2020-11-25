let Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

// App config
Encore
    .setOutputPath('public/build/app/')
    .setPublicPath('/build/app')
    .addEntry('main', './assets/app/main.js')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })
    .enableSassLoader()
    .enableIntegrityHashes(Encore.isProduction())
    .enablePostCssLoader((options) => {
        options.postcssOptions = {
            config: __dirname + '/assets/app/postcss.config.js'
        };
    })
;
const appConfig = Encore.getWebpackConfig();
appConfig.name = 'app';

// reset Encore to build the second config
Encore.reset();

// Admin config
Encore
    .setOutputPath('public/build/admin/')
    .setPublicPath('/build/admin')
    .addEntry('main', './assets/admin/main.js')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })
    .enableSassLoader()
    .enableIntegrityHashes(Encore.isProduction())
    .enablePostCssLoader((options) => {
        options.postcssOptions = {
            config: __dirname + '/assets/admin/postcss.config.js'
        };
    })
;

const adminConfig = Encore.getWebpackConfig();
adminConfig.name = 'admin';

module.exports = [appConfig, adminConfig];
