<script lang="ts">
	export let title: string
</script>

<div>
	<h2 style="line-height: 1.5;">{title}</h2>
</div>

<style lang="postcss">
	div {
		@apply mx-2 py-1 mt-1 mb-2;
	}
	h2 {
		white-space: pre-wrap;
		@apply font-bold font-zenmaru text-3xl sm:text-4xl px-2;
	}
</style>
