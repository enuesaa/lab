<script lang="ts">
	export let filename: string
</script>

<div>
	{filename}
</div>

<style lang="postcss">
	div {
		@apply absolute top-[-25px] left-6 text-[15px] font-murecho;
		@apply bg-editorbg text-editortext px-[10px] pt-[1px] rounded-t-lg;
		@apply border-[0.5px] border-b-0 border-editortext/50 whitespace-nowrap select-all cursor-auto;
	}
</style>
