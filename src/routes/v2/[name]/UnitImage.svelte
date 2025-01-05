<script lang="ts">
	export let projectName: string
	export let image: string
</script>

<img src={`/prototype/${projectName}/${image}`} alt={image} />

<style lang="postcss">
	img {
		@apply block mx-auto max-w-[min(100%,1000px)] mb-3;
	}
</style>
