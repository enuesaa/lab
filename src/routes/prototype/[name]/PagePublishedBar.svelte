<script lang="ts">
	export let published: string
</script>

<div class="mx-1 px-2 text-right text-base font-semibold font-zenmaru">
	{published}
</div>

<style lang="postcss">
	@reference "#app.css";

	div {
		letter-spacing: 1px;
	}
</style>
