const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/')
    .setPublicPath('/bundles/markocupicfontawesomeiconpicker')
    .setManifestKeyPrefix('')

    //.addEntry('frontend', './bar/foo.js')

    .copyFiles({
        from: './assets',
        to: '[path][name].[hash:8].[ext]'
    })

    .disableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableSourceMaps()
    .enableVersioning()

    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    .enablePostCssLoader()
;

module.exports = Encore.getWebpackConfig();
