<script lang="ts">
	import { getViewing, type TreeData } from '$lib/prototype/tree'
	import type { CodeFiles } from '$lib/prototype/types'

	export let codeFiles: CodeFiles
	export let filename: string

	const viewing = getViewing()

	function searchFile(files: CodeFiles): TreeData|undefined {
		for (const data of files) {
			if (data.id === filename) {
				return data
			}
			if (data?.children !== undefined) {
				const ret = searchFile(data.children)
				if (ret !== undefined) {
					return ret
				}
			}
		}
		return undefined
	}

	function handleClick() {
		const data = searchFile(codeFiles)
		if (data !== undefined) {
			viewing.set(data)
		}
	}
</script>

<button on:click|preventDefault={handleClick}>
	{filename}
</button>

<style lang="postcss">
	button {
		@apply block rounded-2xl px-2 pb-1 mt-1 mb-2 ml-2 border;
		@apply font-zenmaru font-medium bg-gray shadow-2xl;
		@apply bg-gray-500/30 border-[0.5px] border-gray-700 hover:bg-gray-600;
	}
</style>
