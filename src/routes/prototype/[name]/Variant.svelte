<script lang="ts">
	import VariantNav from './VariantNav.svelte'
	import VariantBody from './VariantBody.svelte'
	import type { VariantWithTreeData } from '$lib/types/tree'

	export let variant: VariantWithTreeData

	let showing: boolean = true
</script>

<VariantNav {variant} bind:showing={showing} />
<VariantBody {variant} bind:showing={showing} />
