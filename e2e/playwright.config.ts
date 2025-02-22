import { defineConfig } from '@playwright/test'

export default defineConfig({
	use: {
		browserName: 'firefox',
	},
	outputDir: 'pw-results',
	snapshotPathTemplate: '{testDir}/pw-screenshots/{arg}{ext}',
	reporter: [
		[
			'html',
			{
				open: 'never',
				outputFolder: 'pw-report',
			},
		],
		[
			'json',
			{
				outputFile: 'pw-results/results.json',
			},
		],
	],
	webServer: {
		cwd: '../',
		command: 'pnpm run dev',
		url: 'http://localhost:3000',
	},
})
