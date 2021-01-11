const mix = require('laravel-mix');
const path = require('path');

mix
  .js('resources/js/app.ts', 'public/js')
  .vue()
  .sass('resources/sass/app.scss', 'public/css')
  .webpackConfig({
    resolve: {
      extensions: ['*', '.js', '.jsx', '.vue', '.ts', '.tsx'],
      alias: {
        '@': path.resolve('resources'),
        '~': path.resolve('resources/js'),
      },
    },
    module: {
      rules: [
        {
          test: /\.tsx?$/,
          loader: 'ts-loader',
          options: { appendTsSuffixTo: [/\.vue$/] },
          exclude: /node_modules/,
        },
      ],
    },
  });

if (mix.inProduction()) {
  mix.version();
} else {
  mix.browserSync('booj.localhost');
}

mix.sourceMaps();
