<script lang="ts">
	import { useCodeViewer, type TreeData } from '$lib/prototype/tree'
	import type { CodeFiles } from '$lib/prototype/types'

	export let codeFiles: CodeFiles
	export let mark: string

	const split = mark.split(':')
	const filename = split.length === 2 ? split[0] : ''
	const markLine = split.length === 2 ? parseInt(split[1], 10) : undefined

	const viewing = useCodeViewer()

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
			viewing.set({...data, markLine})
		}
	}
</script>

<button on:click|preventDefault={handleClick}>
	{mark}
</button>

<style lang="postcss">
	button {
		@apply block rounded-2xl px-2 pb-1 mt-2 mb-2 ml-2 border;
		@apply font-zenmaru font-medium bg-gray shadow-2xl;
		@apply bg-gray-500/30 border-[0.5px] border-gray-700 hover:bg-gray-600;
	}
</style>
