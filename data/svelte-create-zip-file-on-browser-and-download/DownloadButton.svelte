<script lang="ts">
	import JSZip from 'jszip'

	async function handleClick() {
		// zip を作成
		const zip = new JSZip()
		zip.file('README.md', '# hello')
		zip.file('aa/README.md', '# aa')
		zip.file('bb/README.md', '# bb')

		// blob へ
		const blob = await zip.generateAsync({ type: 'blob' })
		const url = URL.createObjectURL(blob)

		// リンク作成
		const link = document.createElement('a')
		link.download = 'archive.zip' // ファイル名
		link.href = url
		link.click()

		// メモリ解放らしい
		URL.revokeObjectURL(url)
	}
</script>

<button on:click|preventDefault={handleClick}>
	download
</button>
