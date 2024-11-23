import { defineConfig } from 'vite'
import { sveltekit } from '@sveltejs/kit/vite'
import path from 'node:path'
import fs from 'node:fs/promises'

export default defineConfig({
	plugins: [
		sveltekit(),

		// 追加したコード
		{
			name: 'file-copy',

			// buildStart にて呼ばれる
			// see https://rollupjs.org/plugin-development/#buildstart
			async buildStart() {

				// 画像ファイルの格納先ディレクトリを作成
				try {
					// remove old assets
					await fs.rm('./static/images', { recursive: true })
					await fs.mkdir('./static/images', { recursive: true })
				} catch(e) {}

				// 画像ファイルを配置
				const src = path.join('./data', 'something-image-file.png')
				const dest = path.join('./static/images', 'something-image-file.png')
				await fs.copyFile(src, dest)

				console.log('file copied!')
			},
		},
	],
})
