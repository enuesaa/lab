<script lang="ts">
	import './app.css'
	import Footer from './Footer.svelte'
	import Header from './Header.svelte'
</script>

<svelte:head>
	<title>雑コード置き場</title>
	<meta name="Hatena::Bookmark" content="nocomment" />
	<link rel="icon" href="/favicon.ico" />
	<link rel="icon" href="/favicon.svg" sizes="32x32" type="image/svg+xml" />
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png" />
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png" />
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
	<link rel="manifest" href="/manifest.json" />
	<meta name="theme-color" content="#cccccc" />
</svelte:head>

<Header />

<main>
	<div class="container mx-auto px-1 py-8">
		<slot />
	</div>
</main>

<Footer />

<style lang="postcss">
	main {
		@apply bg-gray min-h-screen sm:mx-3 sm:w-[calc(100%_-_24px)] sm:shadow-sm;
	}
</style>
