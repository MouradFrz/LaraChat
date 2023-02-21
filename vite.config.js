import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/sass/convo.scss",
                "resources/sass/homepage.scss",
                "resources/js/app.js",
                "resources/js/AnyMessage.js",
                "resources/js/PrivateListener.js",
                "resources/js/userSearch.js",
                "resources/js/listener.js",
            ],
            refresh: true,
        }),
    ],
});
