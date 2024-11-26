<script lang="ts">
	import JSZip from 'jszip'

	let url: undefined|string = undefined
	let downloadLinkRef: undefined|HTMLAnchorElement = undefined

	async function handleClick() {
		const zip = new JSZip()
        zip.file("data.json", JSON.stringify({aaa: 'b'}, null, 2))

        const blob = await zip.generateAsync({ type: 'blob' })
        url = URL.createObjectURL(blob)

		setTimeout(() => {
			if (downloadLinkRef !== undefined) {
				downloadLinkRef.click()
			}
        }, 1000) 

		// donwloadLinkRef.click()
        // URL.revokeObjectURL(url)
	}
</script>

<button on:click|preventDefault={handleClick}>downlaod</button>

{#if url !== undefined}
	<a href={url} download='archive.zip' bind:this={downloadLinkRef}>a</a>
{/if}
