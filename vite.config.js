import { defineConfig } from 'vite';
import path from 'path';

const rootDir = __dirname;

export default defineConfig({
  root: rootDir,
  publicDir: false,
  base: '', 
  resolve: {
    alias: {
      '@': path.resolve(rootDir, 'resources/js'),
    },
  },
  build: {
    outDir: path.resolve(rootDir, 'public/vendor/laravisitors'),
    emptyOutDir: true,
    cssCodeSplit: false,
    rollupOptions: {
      input: {
        app: path.resolve(rootDir, 'resources/js/app.js'),
      },
      output: {
        entryFileNames: 'assets/app.js',
        chunkFileNames: 'assets/[name]-[hash].js',
        assetFileNames: (assetInfo) => {
          if (assetInfo.name && assetInfo.name.endsWith('.css')) {
            return 'assets/app.css';
          }
          return 'assets/[name]-[hash][extname]';
        },
      },
    },
  },
});