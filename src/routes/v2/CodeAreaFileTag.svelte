<script lang="ts">
	export let filename: string
</script>

<div>
	{filename}
</div>

<style lang="postcss">
	div {
		@apply absolute top-[1px] left-[20%];
		@apply bg-editorbg text-editortext px-3 py-[1px] rounded-t-lg;
		@apply text-base font-murecho;
		@apply border-[0.5px] border-b-0 border-editortext/50;
	}
</style>
