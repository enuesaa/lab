<script lang="ts">
	export let showCodeUnits: boolean

	function handleClick() {
		showCodeUnits = !showCodeUnits
	}
</script>

<!-- svelte-ignore a11y_click_events_have_key_events -->
<!-- svelte-ignore a11y_no_static_element_interactions -->
<div on:click|preventDefault={handleClick}></div>

<style lang="postcss">
	div {
		@apply absolute top-0 left-0 w-full h-full hidden max-md:block bg-black/70;
	}
</style>