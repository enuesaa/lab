<script lang="ts">
	import type { TreeData } from '$lib/prototype/tree'
	import type { CodeFiles } from '$lib/prototype/types'
	import JSZip from 'jszip'
	import { Download } from 'lucide-svelte'

	export let codeFiles: CodeFiles

	async function createZipBlob(): Promise<Blob> {
		const zip = new JSZip()
		function append(dir: string, data: TreeData) {
			const filepath = `${dir}/${data.title}`
			if (!data.isDir) {
				zip.file(filepath, data.code)
			}

			// append children
			for (const d of data.children) {
				append(filepath, d)
			}
			// create .gitkeep if dir is empty
			if (data.isDir && data.children.length === 0) {
				zip.file(`${filepath}/.gitkeep`, '')
			}
		}
		for (const d of codeFiles) {
			append('.', d)
		}
		const blob = await zip.generateAsync({ type: 'blob' })

		return blob
	}

	async function handleClick() {
		const blob = await createZipBlob()
		const url = URL.createObjectURL(blob)

		let link = document.createElement('a')
		link.download = 'code.zip'
		link.href = url
		link.click()

		// メモリ解放らしい
		URL.revokeObjectURL(url)
	}
</script>

<button on:click|preventDefault={handleClick}>
	download<Download class="inline-block pt-[1px] pb-[6px] pl-[1px]" />
</button>

<style lang="postcss">
	button {
		@apply inline-block text-base px-2 rounded-2xl;
		@apply bg-gray-600 text-gray-900 hover:bg-gray-700/30 max-md:hidden;
	}
</style>
