<script lang="ts">
	export let published: string
</script>

<div>
	{published}
</div>

<style lang="postcss">
	div {
		letter-spacing: 1px;
		@apply mx-1 px-2 text-right text-base font-semibold font-zenmaru;
	}
</style>
