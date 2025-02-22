import { test, expect } from '@playwright/test'
import { pages, realBaseUrl, localBaseUrl } from './pages'

for (const { name, path } of pages) {
	test(`diff ${name} (${path})`, async ({ page }, testinfo) => {
		const filename = `${name}.png`

		const realUrl = `${realBaseUrl}${path}`
		const capturePath = testinfo.snapshotPath(filename)
		await page.goto(realUrl)
		await page.screenshot({ path: capturePath, fullPage: true })

		const localUrl = `${localBaseUrl}${path}`
		await page.goto(localUrl)
		await expect(page).toHaveScreenshot(filename, { fullPage: true })
	})
}
