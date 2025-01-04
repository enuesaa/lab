<script lang="ts">
	export let filename: string
</script>

<div>
	{filename}
</div>

<style lang="postcss">
	div {
		@apply absolute top-[-25px] left-6;
		@apply bg-editorbg text-editortext px-[10px] pt-[1px] rounded-t-lg;
		@apply text-[15px] font-murecho;
		@apply border-[0.5px] border-b-0 border-editortext/50;
	}
</style>
