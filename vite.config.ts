/// <reference types="vitest" />
import { defineConfig } from 'vite'
import { sveltekit } from '@sveltejs/kit/vite'
import path from 'node:path'
import { listProjectsV2 } from './src/lib/prototype/server/project'
import { copyUnitImage } from './src/lib/prototype/server/image'

export default defineConfig({
	plugins: [
		sveltekit(),
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
