<script lang="ts">
	export let text: string = ''
</script>

<div>
	{text}
</div>

<style lang="postcss">
	div {
		@apply w-full font-zenmaru text-3xl text-center font-medium;
		@apply mt-16 mb-1;
	}
</style>
