<script lang="ts">
	export let text: string
</script>

<div>
	{text}
</div>

<style lang="postcss">
	div {
		@apply w-full px-2 py-1 font-semibold text-sm bg-editorsep text-gray;
		@apply border-t-[0.5px] border-b-[0.5px] border-editortext/50;
	}
</style>