/// <reference types="vitest" />
import { defineConfig } from 'vite'
import { sveltekit } from '@sveltejs/kit/vite'
import path from 'node:path'
import { listProjectsV2 } from './src/lib/prototype/server/project'
import { copyUnitImage } from './src/lib/prototype/server/image'
import adapter from '@sveltejs/adapter-static'
import { vitePreprocess } from '@sveltejs/vite-plugin-svelte'
import { sequence, preprocessMeltUI } from '@melt-ui/pp'

export default defineConfig({
	plugins: [
		sveltekit({
			preprocess: sequence([vitePreprocess(), preprocessMeltUI()]),
			adapter: adapter({
				pages: 'dist',
				fallback: '404.html',
			}),
			prerender: {
				handleHttpError: 'ignore',
			},
		}),
		{
			name: 'file-copy',
			async buildStart() {
				const projects = await listProjectsV2()
				for (const project of projects) {
					await copyUnitImage(project)
				}
				console.log('file copied!')
			},
		},
	],
	resolve: {
		alias: {
			$lib: path.join(__dirname, './src/lib'),
		},
	},
	test: {
		include: ['src/**/*.test.ts'],
		exclude: ['e2e'],
	},
})
