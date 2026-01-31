<script lang="ts">
	import type { MouseEventHandler } from 'svelte/elements'

	export let filename: string

	const handleClick: MouseEventHandler<HTMLDivElement> = (e) => {
		e.preventDefault()
		if (!e.target) {
			return
		}
		const range = document.createRange();
		range.selectNodeContents(e.target as Node);
		const selection = window.getSelection();
		selection?.removeAllRanges();
		selection?.addRange(range);
	}
</script>

<!-- svelte-ignore a11y_no_static_element_interactions a11y_click_events_have_key_events -->
<div on:click={handleClick}>
	{filename}
</div>

<style lang="postcss">
	div {
		@apply absolute top-[-25px] left-6 text-[15px] font-murecho;
		@apply bg-editorbg text-editortext px-[10px] pt-[1px] rounded-t-lg;
		@apply border-[0.5px] border-b-0 border-editortext/50 whitespace-nowrap select-all cursor-auto;
	}
</style>
