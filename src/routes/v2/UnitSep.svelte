<script lang="ts">
	export let text: string
</script>

<div>
	{text}
</div>

<style lang="postcss">
	div {
		@apply w-full px-2 pt-1 pb-[2px] font-medium text-sm bg-editorsep text-gray;
		@apply border-t-[0.5px] border-b-[0.5px] border-editortext/50 text-center;
		@apply relative;
	}
</style>
