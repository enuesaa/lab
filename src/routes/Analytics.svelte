<script lang="ts">
	import { onMount } from 'svelte'

	onMount(() => {
		// @ts-ignore
		window.dataLayer = window.dataLayer || [];
		// @ts-ignore
		window.dataLayer.push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' });
		const gtmScript = document.createElement('script');
		gtmScript.src = 'https://www.googletagmanager.com/gtm.js?id=GTM-5BP6TN66';
		document.head.append(gtmScript);
	});
</script>
