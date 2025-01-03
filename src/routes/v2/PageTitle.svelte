<script lang="ts">
	export let title: string
</script>

<div>
	<h2>{title}</h2>
</div>

<style lang="postcss">
	div {
		@apply mx-2 py-1 mt-3 mb-1;
	}
	h2 {
		white-space: pre-wrap;
		@apply font-bold font-zenmaru text-3xl sm:text-4xl px-2 leading-[1.5];
	}
</style>
