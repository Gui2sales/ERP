import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.scss'
                , 'resources/css/botoes.scss'
                , 'resources/css/graficos.scss'
                , 'resources/css/logo.scss'
                , 'resources/css/main.scss'
                , 'resources/css/tabela.scss'

                , 'resources/js/app.js'
                , 'resources/js/bootstrap.js' 
            ],
            refresh: true,
        }),
    ],
});
